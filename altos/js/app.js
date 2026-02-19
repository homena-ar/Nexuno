/**
 * GPS Altos de Podestá - Main Application
 * Conecta todos los módulos y maneja la UI
 */

class App {
    constructor() {
        // Estado
        this.origen = { tipo: null, manzana: null, casa: null };
        this.destino = { manzana: null, casa: null };
        this.gpsActivo = false;
        this.gpsWatchId = null;
        this.posicionGPS = null;
        this.gpsHistory = [];
        this.gpsMaxAccuracy = 50;
        this.gpsSmoothingWindow = 5;
        this.gpsSnapDistance = 20;
        this.gpsCalibrationStorageKey = 'altos_gps_affine_calibration_v1';
        this.gpsCalibrationMode = false;
        this.gpsCalibrationSamples = [];
        this.gpsAffine = null;
        this.modalManzana = null;
        this.lastFocusedElement = null;
        
        // Módulos
        this.map = null;
        this.router = null;
        
        // Inicializar cuando el DOM esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.init());
        } else {
            this.init();
        }
    }

    init() {
        // Crear instancias
        this.map = new MapRenderer('mapContainer');
        this.router = new Router();
        this.map.setDebugData(this.router.getDebugData());
        this.map.onMapPointClick = (point) => this.onMapPointClick(point);
        this.initGpsAffine();
        
        // Configurar callbacks
        this.map.onManzanaClick = (manzana) => this.abrirModal(manzana);
        
        // Elementos DOM
        this.elements = {
            menuBtn: document.getElementById('menuBtn'),
            navPanel: document.getElementById('navPanel'),
            origenM: document.getElementById('origenM'),
            origenC: document.getElementById('origenC'),
            origenTag: document.getElementById('origenTag'),
            destinoM: document.getElementById('destinoM'),
            destinoC: document.getElementById('destinoC'),
            destinoTag: document.getElementById('destinoTag'),
            calcularBtn: document.getElementById('calcularBtn'),
            limpiarBtn: document.getElementById('limpiarBtn'),
            routeInfo: document.getElementById('routeInfo'),
            routeFrom: document.getElementById('routeFrom'),
            routeTo: document.getElementById('routeTo'),
            routeDist: document.getElementById('routeDist'),
            modalOverlay: document.getElementById('modalOverlay'),
            modalManzana: document.getElementById('modalManzana'),
            modalCasas: document.getElementById('modalCasas'),
            modalCasa: document.getElementById('modalCasa'),
            modalOrigenBtn: document.getElementById('modalOrigenBtn'),
            modalDestinoBtn: document.getElementById('modalDestinoBtn'),
            modalCloseBtn: document.getElementById('modalCloseBtn'),
            gpsBtn: document.getElementById('gpsBtn'),
            zoomInBtn: document.getElementById('zoomInBtn'),
            zoomOutBtn: document.getElementById('zoomOutBtn'),
            centerBtn: document.getElementById('centerBtn'),
            toastContainer: document.getElementById('toastContainer')
        };
        
        this.setupEventListeners();
        this.setupPanelHeight();
    }

    setupEventListeners() {
        // Limitar inputs a dígitos para evitar estados inválidos
        [this.elements.origenM, this.elements.origenC, this.elements.destinoM, this.elements.destinoC, this.elements.modalCasa]
            .forEach(el => el.addEventListener('input', () => this.restringirInputNumerico(el)));

        // Menu toggle
        this.elements.menuBtn.addEventListener('click', () => {
            this.elements.menuBtn.classList.toggle('active');
            this.elements.navPanel.classList.toggle('collapsed');
            this.updateMapMargin();
        });
        
        // Inputs de origen
        this.elements.origenM.addEventListener('input', () => this.onOrigenInput());
        this.elements.origenC.addEventListener('input', () => this.onOrigenInput());
        
        // Inputs de destino
        this.elements.destinoM.addEventListener('input', () => this.onDestinoInput());
        this.elements.destinoC.addEventListener('input', () => this.onDestinoInput());
        
        // Enter para calcular
        [this.elements.origenM, this.elements.origenC, this.elements.destinoM, this.elements.destinoC]
            .forEach(el => el.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') this.calcularRuta();
            }));
        
        // Botones de acción
        this.elements.calcularBtn.addEventListener('click', () => this.calcularRuta());
        this.elements.limpiarBtn.addEventListener('click', () => this.limpiarTodo());
        
        // Quick actions (chips)
        document.querySelectorAll('[data-action]').forEach(btn => {
            btn.addEventListener('click', () => this.handleQuickAction(btn.dataset.action));
        });
        
        // Modal
        this.elements.modalOrigenBtn.addEventListener('click', () => this.confirmarModal('origen'));
        this.elements.modalDestinoBtn.addEventListener('click', () => this.confirmarModal('destino'));
        this.elements.modalCloseBtn.addEventListener('click', () => this.cerrarModal());
        this.elements.modalOverlay.addEventListener('click', (e) => {
            if (e.target === this.elements.modalOverlay) this.cerrarModal();
        });
        this.elements.modalCasa.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                this.confirmarModal(this.origen.manzana ? 'destino' : 'origen');
            }
        });
        
        // Zoom controls
        this.elements.zoomInBtn.addEventListener('click', () => this.map.zoomIn());
        this.elements.zoomOutBtn.addEventListener('click', () => this.map.zoomOut());
        this.elements.centerBtn.addEventListener('click', () => this.map.centerMap());
        
        // Keyboard
        document.addEventListener('keydown', (e) => this.onGlobalKeydown(e));
        
        // Resize
        window.addEventListener('resize', () => {
            this.updateMapMargin();
            this.map.centerMap();
        });
    }

    setupPanelHeight() {
        // Calcular altura del panel y ajustar margen del mapa
        this.updateMapMargin();
    }

    updateMapMargin() {
        const header = document.querySelector('.header');
        const panel = this.elements.navPanel;
        const mapContainer = document.getElementById('mapContainer');
        
        if (window.innerWidth >= 1024) {
            // Desktop: panel lateral
            mapContainer.style.marginTop = `${header.offsetHeight}px`;
            mapContainer.style.marginLeft = '400px';
        } else {
            // Mobile: panel arriba
            const panelHeight = panel.classList.contains('collapsed') ? 60 : panel.offsetHeight;
            mapContainer.style.marginTop = `${header.offsetHeight + panelHeight}px`;
            mapContainer.style.marginLeft = '0';
        }
    }

    // ============ INPUTS ============

    restringirInputNumerico(input) {
        if (!input) return;
        const digits = input.value.replace(/\D+/g, '');
        if (input.value !== digits) {
            input.value = digits;
        }
    }

    marcarErrorInput(input, message) {
        if (!input) return;
        input.classList.add('input-error');
        input.setAttribute('aria-invalid', 'true');
        input.focus();
        this.toast(message, 'error');
    }

    limpiarErrorInput(input) {
        if (!input) return;
        input.classList.remove('input-error');
        input.removeAttribute('aria-invalid');
    }

    limpiarErroresValidacion() {
        [
            this.elements.origenM,
            this.elements.origenC,
            this.elements.destinoM,
            this.elements.destinoC,
            this.elements.modalCasa
        ].forEach((input) => this.limpiarErrorInput(input));
    }

    onOrigenInput() {
        this.limpiarErrorInput(this.elements.origenM);
        this.limpiarErrorInput(this.elements.origenC);
        const m = parseInt(this.elements.origenM.value, 10);
        const origenCasaValue = parseInt(this.elements.origenC.value, 10);

        if (!m || !BarrioData.casasPorManzana[m]) {
            if (this.origen.tipo === 'manzana' || this.origen.manzana) {
                this.origen = { tipo: null, manzana: null, casa: null };
                this.actualizarTagOrigen();
            }
            return;
        }

        const c = this.normalizarCasa(m, origenCasaValue);
        this.origen = { tipo: 'manzana', manzana: m, casa: c };
        document.querySelectorAll('.chip').forEach(chip => chip.classList.remove('active'));
        this.actualizarTagOrigen();
    }

    onDestinoInput() {
        this.limpiarErrorInput(this.elements.destinoM);
        this.limpiarErrorInput(this.elements.destinoC);
        const m = parseInt(this.elements.destinoM.value, 10);
        const destinoCasaValue = parseInt(this.elements.destinoC.value, 10);

        if (!m || !BarrioData.casasPorManzana[m]) {
            if (this.destino.manzana) {
                this.destino = { manzana: null, casa: null };
                this.actualizarTagDestino();
            }
            return;
        }

        const c = this.normalizarCasa(m, destinoCasaValue);
        this.destino = { manzana: m, casa: c };
        this.actualizarTagDestino();
    }

    actualizarTagOrigen() {
        const tag = this.elements.origenTag;
        let texto = 'Sin seleccionar';
        
        if (this.origen.tipo === 'florida') {
            texto = '📍 Acceso Florida';
        } else if (this.origen.tipo === 'principal') {
            texto = '📍 Acceso Principal';
        } else if (this.origen.tipo === 'gps') {
            texto = '📡 GPS';
        } else if (this.origen.manzana) {
            texto = this.origen.casa 
                ? `M${this.origen.manzana} Casa ${this.origen.casa}`
                : `Manzana ${this.origen.manzana}`;
        }
        
        tag.querySelector('span').textContent = texto;
        tag.classList.toggle('active', this.origen.tipo || this.origen.manzana);
    }

    actualizarTagDestino() {
        const tag = this.elements.destinoTag;
        let texto = 'Sin seleccionar';
        
        if (this.destino.manzana) {
            texto = this.destino.casa 
                ? `M${this.destino.manzana} Casa ${this.destino.casa}`
                : `Manzana ${this.destino.manzana}`;
        }
        
        tag.querySelector('span').textContent = texto;
        tag.classList.toggle('active', !!this.destino.manzana);
    }

    // ============ QUICK ACTIONS ============

    handleQuickAction(action) {
        // Limpiar chips activos
        document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
        
        switch (action) {
            case 'origen-florida':
                this.origen = { tipo: 'florida', manzana: null, casa: null };
                this.elements.origenM.value = '';
                this.elements.origenC.value = '';
                document.querySelector('[data-action="origen-florida"]').classList.add('active');
                this.toast('Origen: Acceso Florida');
                break;
                
            case 'origen-principal':
                this.origen = { tipo: 'principal', manzana: null, casa: null };
                this.elements.origenM.value = '';
                this.elements.origenC.value = '';
                document.querySelector('[data-action="origen-principal"]').classList.add('active');
                this.toast('Origen: Acceso Principal');
                break;
                
            case 'origen-gps':
                this.toggleGPS();
                break;
        }
        
        this.actualizarTagOrigen();
    }

    // ============ GPS ============

    toggleGPS() {
        if (this.gpsActivo) {
            this.desactivarGPS();
        } else {
            this.activarGPS();
        }
    }

    activarGPS() {
        if (!navigator.geolocation) {
            this.toast('GPS no disponible', 'error');
            return;
        }
        
        this.gpsActivo = true;
        this.origen = { tipo: 'gps', manzana: null, casa: null };
        this.elements.gpsBtn.classList.add('active');
        this.elements.origenM.value = '';
        this.elements.origenC.value = '';
        this.actualizarTagOrigen();
        
        this.gpsWatchId = navigator.geolocation.watchPosition(
            (pos) => this.onGPSUpdate(pos),
            (err) => this.onGPSError(err),
            { enableHighAccuracy: true, maximumAge: 1000, timeout: 10000 }
        );
        
        this.toast('GPS activado');
    }

    desactivarGPS(showToast = true) {
        if (this.gpsWatchId) {
            navigator.geolocation.clearWatch(this.gpsWatchId);
        }
        
        this.gpsActivo = false;
        this.gpsWatchId = null;
        this.posicionGPS = null;
        this.gpsHistory = [];
        this.elements.gpsBtn.classList.remove('active');
        this.map.hideMarker('user');
        
        if (this.origen.tipo === 'gps') {
            this.origen = { tipo: null, manzana: null, casa: null };
            this.actualizarTagOrigen();
        }
        
        if (showToast) this.toast('GPS desactivado');
    }

    onGPSUpdate(pos) {
        const limits = BarrioData.gpsLimits;
        const { latitude, longitude, accuracy } = pos.coords;
        const timestamp = new Date(pos.timestamp).toISOString();

        if (typeof accuracy === 'number' && accuracy > this.gpsMaxAccuracy) {
            console.warn('[GPS] Lectura ignorada por baja precision', {
                latitude,
                longitude,
                accuracy,
                timestamp
            });
            return;
        }

        const raw = this.convertGpsToMapCoordinates(latitude, longitude, limits);
        const smooth = this.smoothGpsPoint(raw);
        const snapped = this.router.snapPointToPath(smooth, this.gpsSnapDistance) || smooth;

        this.posicionGPS = snapped;
        this.map.showMarker('user', this.posicionGPS.x, this.posicionGPS.y, 'GPS');

        console.info('[GPS] update', {
            latitude,
            longitude,
            accuracy,
            timestamp,
            rawXY: raw,
            smoothXY: smooth,
            snappedXY: snapped,
            finalXY: snapped
        });
    }

    onGPSError(err) {
        console.warn('GPS Error:', err);
        this.toast('No se pudo obtener tu ubicación GPS', 'error');
        this.desactivarGPS(false);
    }

    mapear(valor, inMin, inMax, outMin, outMax) {
        return (valor - inMin) * (outMax - outMin) / (inMax - inMin) + outMin;
    }

    convertGpsToMapCoordinates(latitude, longitude, limits) {
        if (this.gpsAffine) {
            const raw = this.projectLatLonAffine(latitude, longitude, this.gpsAffine);
            const v = BarrioData.mapViewBox || { xMin: limits.xMin, xMax: limits.xMax, yMin: limits.yMin, yMax: limits.yMax };
            return {
                x: Math.max(v.xMin, Math.min(v.xMax, raw.x)),
                y: Math.max(v.yMin, Math.min(v.yMax, raw.y))
            };
        }

        const x = this.mapear(longitude, limits.lonMin, limits.lonMax, limits.xMin, limits.xMax);
        const y = this.mapear(latitude, limits.latMax, limits.latMin, limits.yMin, limits.yMax);
        return { x, y };
    }

    smoothGpsPoint(point) {
        this.gpsHistory.push(point);
        if (this.gpsHistory.length > this.gpsSmoothingWindow) {
            this.gpsHistory.shift();
        }

        const total = this.gpsHistory.reduce(
            (acc, p) => ({ x: acc.x + p.x, y: acc.y + p.y }),
            { x: 0, y: 0 }
        );
        return {
            x: total.x / this.gpsHistory.length,
            y: total.y / this.gpsHistory.length
        };
    }

    initGpsAffine() {
        const stored = this.loadGpsCalibrationFromStorage();
        if (stored && stored.points && stored.points.length === 3) {
            const affine = this.solveAffine(stored.points);
            if (affine) {
                this.gpsAffine = affine;
                console.info('[GPS] Usando calibración affine desde localStorage');
                return;
            }
        }

        const base = BarrioData.gpsControlPoints || [];
        if (base.length === 3) {
            this.gpsAffine = this.solveAffine(base);
            if (this.gpsAffine) {
                console.info('[GPS] Usando calibración affine por defecto en data.js');
            }
        }
    }

    onMapPointClick(point) {
        if (!this.gpsCalibrationMode) return;
        this.captureCalibrationSample(point);
    }

    toggleGpsCalibrationMode() {
        this.gpsCalibrationMode = !this.gpsCalibrationMode;
        if (!this.gpsCalibrationMode) {
            this.gpsCalibrationSamples = [];
            this.toast('Calibración GPS desactivada');
            return;
        }

        this.gpsCalibrationSamples = [];
        this.toast('Calibración GPS ON: tocá 3 puntos y cargá lat,lon', 'warning');
    }

    captureCalibrationSample(mapPoint) {
        const idx = this.gpsCalibrationSamples.length + 1;
        const input = window.prompt(`Punto ${idx}/3: ingresá "lat,lon"`, '');
        if (!input) return;

        const parsed = this.parseLatLonInput(input);
        if (!parsed) {
            this.toast('Formato inválido. Usá: lat,lon', 'error');
            return;
        }

        this.gpsCalibrationSamples.push({
            lat: parsed.lat,
            lon: parsed.lon,
            x: mapPoint.x,
            y: mapPoint.y
        });

        this.toast(`Punto ${idx}/3 guardado`);

        if (this.gpsCalibrationSamples.length < 3) return;

        const affine = this.solveAffine(this.gpsCalibrationSamples);
        if (!affine) {
            this.toast('No se pudo calcular la matriz affine', 'error');
            this.gpsCalibrationSamples = [];
            return;
        }

        this.gpsAffine = affine;
        this.saveGpsCalibrationToStorage(this.gpsCalibrationSamples);
        this.gpsCalibrationMode = false;
        this.gpsCalibrationSamples = [];
        this.toast('Calibración GPS aplicada ✓', 'success');
    }

    parseLatLonInput(input) {
        const parts = input.split(',').map((s) => s.trim());
        if (parts.length !== 2) return null;
        const lat = Number(parts[0]);
        const lon = Number(parts[1]);
        if (!Number.isFinite(lat) || !Number.isFinite(lon)) return null;
        return { lat, lon };
    }

    loadGpsCalibrationFromStorage() {
        try {
            const raw = localStorage.getItem(this.gpsCalibrationStorageKey);
            if (!raw) return null;
            return JSON.parse(raw);
        } catch (err) {
            console.warn('[GPS] No se pudo leer calibración guardada', err);
            return null;
        }
    }

    saveGpsCalibrationToStorage(points) {
        try {
            localStorage.setItem(this.gpsCalibrationStorageKey, JSON.stringify({ points, savedAt: Date.now() }));
        } catch (err) {
            console.warn('[GPS] No se pudo guardar calibración', err);
        }
    }

    projectLatLonAffine(lat, lon, affine) {
        return {
            x: affine.ax * lon + affine.bx * lat + affine.cx,
            y: affine.ay * lon + affine.by * lat + affine.cy
        };
    }

    solveAffine(points) {
        if (!Array.isArray(points) || points.length !== 3) return null;
        const m = points.map((p) => [p.lon, p.lat, 1]);
        const bx = points.map((p) => p.x);
        const by = points.map((p) => p.y);

        const sx = this.solveLinear3x3(m, bx);
        const sy = this.solveLinear3x3(m, by);
        if (!sx || !sy) return null;

        return {
            ax: sx[0], bx: sx[1], cx: sx[2],
            ay: sy[0], by: sy[1], cy: sy[2]
        };
    }

    solveLinear3x3(matrix, rhs) {
        const a = matrix.map((row, i) => [...row, rhs[i]]);

        for (let col = 0; col < 3; col++) {
            let pivot = col;
            for (let r = col + 1; r < 3; r++) {
                if (Math.abs(a[r][col]) > Math.abs(a[pivot][col])) pivot = r;
            }
            if (Math.abs(a[pivot][col]) < 1e-12) return null;

            if (pivot !== col) {
                const tmp = a[col];
                a[col] = a[pivot];
                a[pivot] = tmp;
            }

            const div = a[col][col];
            for (let c = col; c < 4; c++) a[col][c] /= div;

            for (let r = 0; r < 3; r++) {
                if (r === col) continue;
                const factor = a[r][col];
                for (let c = col; c < 4; c++) {
                    a[r][c] -= factor * a[col][c];
                }
            }
        }

        return [a[0][3], a[1][3], a[2][3]];
    }

    // ============ MODAL ============

    abrirModal(manzana) {
        this.modalManzana = manzana;
        this.lastFocusedElement = document.activeElement;
        const casas = BarrioData.casasPorManzana[manzana];
        
        this.elements.modalManzana.textContent = manzana;
        this.elements.modalCasas.textContent = casas;
        this.elements.modalCasa.value = '';
        this.elements.modalCasa.max = casas;
        
        this.elements.modalOverlay.classList.add('show');
        
        // Focus con delay para animación
        setTimeout(() => this.elements.modalCasa.focus(), 300);
    }

    cerrarModal() {
        this.elements.modalOverlay.classList.remove('show');
        this.modalManzana = null;
        if (this.lastFocusedElement && typeof this.lastFocusedElement.focus === 'function') {
            this.lastFocusedElement.focus();
        }
        this.lastFocusedElement = null;
    }

    onGlobalKeydown(e) {
        if (e.ctrlKey && e.shiftKey && (e.key === 'D' || e.key === 'd')) {
            e.preventDefault();
            const enabled = this.map.toggleDebugOverlay();
            this.toast(`Debug grafo: ${enabled ? 'ON' : 'OFF'}`);
            return;
        }

        if (e.ctrlKey && e.shiftKey && (e.key === 'G' || e.key === 'g')) {
            e.preventDefault();
            this.toggleGpsCalibrationMode();
            return;
        }

        if (e.key === 'Escape' && this.modalManzana !== null) {
            this.cerrarModal();
            return;
        }

        if (e.key !== 'Tab' || this.modalManzana === null) return;

        const focusables = this.elements.modalOverlay.querySelectorAll(
            'button, input, [href], [tabindex]:not([tabindex="-1"])'
        );
        if (!focusables.length) return;

        const first = focusables[0];
        const last = focusables[focusables.length - 1];
        const active = document.activeElement;

        if (e.shiftKey && active === first) {
            e.preventDefault();
            last.focus();
        } else if (!e.shiftKey && active === last) {
            e.preventDefault();
            first.focus();
        }
    }

    confirmarModal(tipo) {
        this.limpiarErrorInput(this.elements.modalCasa);
        const casa = parseInt(this.elements.modalCasa.value, 10) || null;
        const maxCasas = BarrioData.casasPorManzana[this.modalManzana];
        
        if (casa && (casa < 1 || casa > maxCasas)) {
            this.marcarErrorInput(this.elements.modalCasa, `Casa debe ser 1-${maxCasas}`);
            return;
        }
        
        if (tipo === 'origen') {
            this.origen = { tipo: 'manzana', manzana: this.modalManzana, casa };
            this.elements.origenM.value = this.modalManzana;
            this.elements.origenC.value = casa || '';
            document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
            this.actualizarTagOrigen();
        } else {
            this.destino = { manzana: this.modalManzana, casa };
            this.elements.destinoM.value = this.modalManzana;
            this.elements.destinoC.value = casa || '';
            this.actualizarTagDestino();
        }
        
        this.cerrarModal();
        this.toast(`${tipo === 'origen' ? 'Origen' : 'Destino'}: M${this.modalManzana}${casa ? ' C' + casa : ''}`);
    }

    // ============ RUTA ============

    normalizarCasa(manzana, casa) {
        const maxCasas = BarrioData.casasPorManzana[manzana];
        if (!Number.isInteger(casa)) return null;
        if (casa < 1 || casa > maxCasas) return null;
        return casa;
    }

    leerOrigenDesdeInputs(mostrarToast = false) {
        this.limpiarErrorInput(this.elements.origenM);
        this.limpiarErrorInput(this.elements.origenC);
        const origenMRaw = this.elements.origenM.value.trim();
        const origenCRaw = this.elements.origenC.value.trim();
        const m = parseInt(this.elements.origenM.value, 10);
        const cIngresada = parseInt(this.elements.origenC.value, 10);

        if (!m || !BarrioData.casasPorManzana[m]) {
            if (mostrarToast) {
                if (!origenMRaw) {
                    this.marcarErrorInput(this.elements.origenM, 'Ingresá manzana de origen');
                } else {
                    this.marcarErrorInput(this.elements.origenM, 'La manzana de origen no existe');
                }
            }
            return null;
        }

        const c = this.normalizarCasa(m, cIngresada);
        if (origenCRaw && c === null && mostrarToast) {
            this.marcarErrorInput(
                this.elements.origenC,
                `Casa origen debe ser 1-${BarrioData.casasPorManzana[m]}`
            );
            return null;
        }

        return { tipo: 'manzana', manzana: m, casa: c };
    }

    leerDestinoDesdeInputs(mostrarToast = false) {
        this.limpiarErrorInput(this.elements.destinoM);
        this.limpiarErrorInput(this.elements.destinoC);
        const destinoMRaw = this.elements.destinoM.value.trim();
        const destinoCRaw = this.elements.destinoC.value.trim();
        const m = parseInt(this.elements.destinoM.value, 10);
        const cIngresada = parseInt(this.elements.destinoC.value, 10);

        if (!m || !BarrioData.casasPorManzana[m]) {
            if (mostrarToast) {
                if (!destinoMRaw) {
                    this.marcarErrorInput(this.elements.destinoM, 'Ingresá manzana de destino');
                } else {
                    this.marcarErrorInput(this.elements.destinoM, 'La manzana de destino no existe');
                }
            }
            return null;
        }

        const c = this.normalizarCasa(m, cIngresada);
        if (destinoCRaw && c === null && mostrarToast) {
            this.marcarErrorInput(
                this.elements.destinoC,
                `Casa destino debe ser 1-${BarrioData.casasPorManzana[m]}`
            );
            return null;
        }

        return { manzana: m, casa: c };
    }

    calcularRuta() {
        this.limpiarErroresValidacion();

        // Validar origen
        if (!this.origen.tipo && !this.origen.manzana) {
            const origenInput = this.leerOrigenDesdeInputs(true);
            if (!origenInput) return;
            this.origen = origenInput;
        }
        
        // Validar destino
        if (!this.destino.manzana) {
            const destinoInput = this.leerDestinoDesdeInputs(true);
            if (!destinoInput) return;
            this.destino = destinoInput;
        }
        
        // Validar GPS
        if (this.origen.tipo === 'gps' && !this.posicionGPS) {
            this.toast('Esperando ubicación GPS...', 'warning');
            return;
        }
        
        // Limpiar ruta anterior
        this.limpiarRuta();
        
        // Calcular puntos
        let puntos;
        let origenTexto;
        
        if (this.origen.tipo === 'florida') {
            puntos = this.router.rutaDesdeFlorida(this.destino.manzana, this.destino.casa);
            origenTexto = 'Florida';
        } else if (this.origen.tipo === 'principal') {
            puntos = this.router.rutaDesdePrincipal(this.destino.manzana, this.destino.casa);
            origenTexto = 'Principal';
        } else if (this.origen.tipo === 'gps') {
            puntos = this.router.rutaDesdeGPS(this.posicionGPS, this.destino.manzana, this.destino.casa);
            origenTexto = 'GPS';
        } else {
            puntos = this.router.rutaEntreManzanas(
                this.origen.manzana, this.origen.casa,
                this.destino.manzana, this.destino.casa
            );
            origenTexto = this.origen.casa 
                ? `M${this.origen.manzana}C${this.origen.casa}` 
                : `M${this.origen.manzana}`;
        }

        if (!puntos || puntos.length < 2) {
            this.toast('No se encontró una ruta válida por calles/pasillos', 'error');
            return;
        }
        
        const destinoTexto = this.destino.casa 
            ? `M${this.destino.manzana}C${this.destino.casa}` 
            : `M${this.destino.manzana}`;
        
        // Dibujar
        this.map.drawRoute(puntos);
        
        // Marcadores
        if (this.origen.tipo !== 'gps') {
            const origenPos = this.router.getPuntoMarcador(
                this.origen.tipo, this.origen.manzana, this.origen.casa
            );
            this.map.showMarker('origin', origenPos.x, origenPos.y, origenTexto);
        }
        
        const destinoPos = this.router.getPuntoMarcador(null, this.destino.manzana, this.destino.casa);
        this.map.showMarker('dest', destinoPos.x, destinoPos.y, destinoTexto);
        
        // Highlights
        if (this.origen.manzana) {
            this.map.highlightManzana(this.origen.manzana, 'origin');
        }
        this.map.highlightManzana(this.destino.manzana, 'destination');
        
        // Info
        const distancia = this.router.calcularDistancia(puntos);
        this.elements.routeFrom.textContent = origenTexto;
        this.elements.routeTo.textContent = destinoTexto;
        this.elements.routeDist.textContent = `${distancia} m`;
        this.elements.routeInfo.classList.add('show');
        
        this.toast('Ruta calculada ✓', 'success');
    }

    limpiarRuta() {
        this.map.clearRoute();
        this.map.hideMarker('origin');
        this.map.hideMarker('dest');
        this.map.clearHighlights();
        this.elements.routeInfo.classList.remove('show');
    }

    limpiarTodo() {
        if (this.modalManzana !== null) {
            this.cerrarModal();
        }

        this.limpiarRuta();
        this.limpiarErroresValidacion();
        
        this.origen = { tipo: null, manzana: null, casa: null };
        this.destino = { manzana: null, casa: null };
        
        this.elements.origenM.value = '';
        this.elements.origenC.value = '';
        this.elements.destinoM.value = '';
        this.elements.destinoC.value = '';
        
        document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
        
        this.actualizarTagOrigen();
        this.actualizarTagDestino();
        
        if (this.gpsActivo) {
            this.desactivarGPS();
        }
    }

    // ============ TOAST ============

    toast(message, type = 'default') {
        if (this.elements.toastContainer.children.length >= 3) {
            this.elements.toastContainer.firstElementChild?.remove();
        }

        const toast = document.createElement('div');
        toast.className = `toast toast--${type}`;
        toast.textContent = message;
        const role = type === 'error' || type === 'warning' ? 'alert' : 'status';
        toast.setAttribute('role', role);
        toast.setAttribute('aria-live', role === 'alert' ? 'assertive' : 'polite');
        
        this.elements.toastContainer.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(() => toast.remove(), 300);
        }, 2500);
    }
}

// Iniciar aplicación
const app = new App();
