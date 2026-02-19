/**
 * GPS Altos de Podestá - Map Renderer
 * Renderiza el mapa SVG interactivo
 */

class MapRenderer {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.map = null;
        this.scale = 1;
        this.translateX = 0;
        this.translateY = 0;
        this.isDragging = false;
        this.startX = 0;
        this.startY = 0;
        this.onManzanaClick = null;
        this.showPoiLabels = false;
        
        this.init();
    }

    init() {
        this.render();
        this.setupGestures();
        this.centerMap();
    }

    render() {
        this.map = document.createElement('div');
        this.map.className = 'map';
        this.map.innerHTML = this.generateMapHTML();
        this.container.appendChild(this.map);
        
        // Agregar eventos a manzanas
        this.map.querySelectorAll('.manzana').forEach(el => {
            el.addEventListener('click', (e) => {
                e.stopPropagation();
                const manzana = parseInt(el.dataset.manzana, 10);
                if (this.onManzanaClick) {
                    this.onManzanaClick(manzana);
                }
            });
            el.addEventListener('keydown', (e) => {
                if (e.key !== 'Enter' && e.key !== ' ') return;
                e.preventDefault();
                const manzana = parseInt(el.dataset.manzana, 10);
                if (this.onManzanaClick) {
                    this.onManzanaClick(manzana);
                }
            });
        });
    }

    generateMapHTML() {
        return `
            <!-- Background -->
            <div class="map__bg"></div>
            
            <!-- Arroyo Morón -->
            <svg style="position:absolute;left:0;top:0;width:220px;height:460px;z-index:5;" viewBox="0 0 220 460">
                <path d="M218,0 C82,134 71,244 62,332 C53,414 16,447 0,457 L0,422 C2,420 5,416 5,416 C16,401 31,374 35,329 C40,277 47,226 70,169 C93,110 129,55 180,0 Z" fill="#6bbee2"/>
                <text x="45" y="300" fill="white" font-size="9" font-weight="600" transform="rotate(-75,45,300)">Arroyo Morón</text>
            </svg>
            
            <!-- Perímetro -->
            <svg style="position:absolute;left:0;top:0;width:100%;height:100%;z-index:10;pointer-events:none;" viewBox="0 0 573.16 704.08">
                <polygon points="243,47 484,47 484,589 340,589 310,489 310,466 208,520 103,457 103,268 143,145 243,47" fill="none" stroke="#1d1d1b" stroke-width="3"/>
            </svg>
            
            <!-- Tag del Barrio -->
            <div style="position:absolute;left:19px;top:16px;width:186px;height:64px;background:#f6ed84;border:2px solid #1d1d1b;border-radius:13px;display:flex;flex-direction:column;align-items:center;justify-content:center;font-weight:600;z-index:20;">
                <span style="font-size:14px;">Barrio</span>
                <span style="font-size:16px;">Altos de Podestá</span>
            </div>
            
            <!-- Brújula -->
            <svg style="position:absolute;right:15px;top:16px;width:62px;height:62px;z-index:20;" viewBox="0 0 62 62">
                <circle cx="31" cy="31" r="29" fill="white" stroke="#2cb0e3" stroke-width="3"/>
                <polygon points="31,8 35,31 31,28 27,31" fill="#f45e27"/>
                <polygon points="31,54 35,31 31,34 27,31" fill="#01477e"/>
                <text x="31" y="18" text-anchor="middle" fill="#f45e27" font-size="8" font-weight="bold">N</text>
                <text x="31" y="52" text-anchor="middle" fill="#f45e27" font-size="8" font-weight="bold">S</text>
                <text x="50" y="35" text-anchor="middle" fill="#f45e27" font-size="8" font-weight="bold">E</text>
                <text x="12" y="35" text-anchor="middle" fill="#f45e27" font-size="8" font-weight="bold">O</text>
            </svg>
            
            <!-- Espacio verde superior -->
            <svg style="position:absolute;left:150px;top:52px;width:95px;height:105px;z-index:3;" viewBox="0 0 95 105">
                <polygon points="93,0 0,92 0,105 15,105 93,25" fill="#1d653f"/>
            </svg>
            <div class="area-verde" style="left:241.83px;top:52.85px;width:160.78px;height:20px;"></div>
            <div class="area-verde" style="left:402.6px;top:52.85px;width:49px;height:20px;"></div>
            <span style="position:absolute;left:286px;top:56px;color:white;font-size:9px;font-weight:600;z-index:4;pointer-events:none;">Espacio Verde</span>
            
            <!-- Acceso Florida -->
            <div style="position:absolute;left:357px;top:8px;width:130px;text-align:center;font-size:10px;z-index:20;pointer-events:none;">
                <span style="font-weight:600;font-size:11px;">Acceso por Florida</span>
                <div style="font-size:9px;">Ingreso/Egreso 6AM-12PM</div>
            </div>
            <div style="position:absolute;left:465px;top:20px;width:0;height:0;border-left:8px solid transparent;border-right:8px solid transparent;border-top:10px solid #1d653f;z-index:20;pointer-events:none;"></div>
            
            <!-- Verde vertical segmentado -->
            ${this.generateVerdeVertical()}
            
            <!-- Verde horizontal -->
            ${this.generateVerdeHorizontal()}
            
            <!-- Manzanas -->
            ${this.generateManzanas()}
            
            <!-- Plazas -->
            <div class="plaza" style="left:245.62px;top:195.05px;width:74.27px;height:37.19px;">
                <span class="plaza__title">Plaza</span>
                <span class="plaza__subtitle">Secundaria</span>
            </div>
            
            <div class="plaza" style="left:259.91px;top:365.74px;width:62.16px;height:37.04px;">
                <span class="plaza__title">Plaza Miguel</span>
                <span class="plaza__subtitle">Benítez</span>
            </div>
            
            ${this.showPoiLabels ? this.generatePoiLabels() : ''}
            
            <!-- Verde esquina inferior -->
            <svg style="position:absolute;left:106px;top:441px;width:210px;height:85px;z-index:2;pointer-events:none;" viewBox="0 0 210 85">
                <polygon points="0,12 103,79 205,19 205,0 180,0 180,28 130,28 130,56 75,56 75,30 37,30 0,8" fill="#1d653f"/>
            </svg>
            
            <!-- Acceso Principal -->
            <div style="position:absolute;left:365px;bottom:55px;width:90px;height:50px;background:#1d1d1b;border-radius:8px 8px 0 0;display:flex;flex-direction:column;align-items:center;justify-content:center;color:white;z-index:20;pointer-events:none;">
                <div style="width:0;height:0;border-left:6px solid transparent;border-right:6px solid transparent;border-bottom:8px solid white;margin-bottom:3px;"></div>
                <span style="font-size:9px;font-weight:600;">Acceso</span>
                <span style="font-size:10px;font-weight:700;">Principal</span>
            </div>
            
            <!-- Av. Márquez -->
            <svg style="position:absolute;left:0;bottom:0;width:100%;height:50px;z-index:15;pointer-events:none;" viewBox="0 0 573 50">
                <polygon points="0,35 0,10 225,10 225,18 502,18 502,10 573,10 573,35 502,35 502,27 225,27 225,35" fill="#1d1d1b"/>
                <text x="130" y="28" fill="white" font-size="9" font-weight="600">Av. Bernabé Márquez</text>
            </svg>
            
            <!-- Route SVG -->
            <svg class="route-svg" id="routeSvg" viewBox="0 0 573.16 704.08"></svg>
            
            <!-- Markers -->
            <div class="marker marker--origin" id="markerOrigin"><span class="marker__label" id="labelOrigin"></span></div>
            <div class="marker marker--dest" id="markerDest"><span class="marker__label" id="labelDest"></span></div>
            <div class="marker marker--user" id="markerUser"><span class="marker__label">GPS</span></div>
        `;
    }

    generateVerdeVertical() {
        const segments = [
            {l: 408.11, t: 114.14, w: 4.38, h: 35.33},
            {l: 408.11, t: 155.53, w: 4.38, h: 35.33},
            {l: 408.11, t: 196.91, w: 4.38, h: 35.33},
            {l: 409.40, t: 247.30, w: 4.38, h: 35.33},
            {l: 409.40, t: 287.19, w: 4.38, h: 35.33},
            {l: 409.40, t: 325.97, w: 4.38, h: 36.43},
            {l: 410.28, t: 367.53, w: 4.38, h: 35.33},
            {l: 409.24, t: 414.22, w: 4.38, h: 20.15},
            {l: 408.62, t: 440.91, w: 4.53, h: 22.18},
            {l: 408.62, t: 469.29, w: 4.53, h: 22.18},
            {l: 408.62, t: 497.68, w: 4.53, h: 19.21},
            {l: 408.62, t: 525.59, w: 4.53, h: 20.96},
            {l: 408.62, t: 553.94, w: 4.53, h: 20.96},
            {l: 390.11, t: 247.30, w: 14.96, h: 35.33},
            {l: 164.42, t: 365.74, w: 4.11, h: 37.04}
        ];
        
        return segments.map(s => 
            `<div class="area-verde" style="left:${s.l}px;top:${s.t}px;width:${s.w}px;height:${s.h}px;"></div>`
        ).join('');
    }

    generatePoiLabels() {
        return `
            <div class="capilla" style="left:280px;top:362px;width:44px;height:24px;">Capilla</div>
            <div class="institucion institucion--escuela" style="left:384px;top:282px;width:28px;height:34px;">Esc<br>Sec<br>21</div>
            <div class="institucion institucion--escuela" style="left:384px;top:318px;width:28px;height:30px;">Esc<br>Prim<br>53</div>
            <div class="institucion institucion--jardin" style="left:384px;top:350px;width:28px;height:30px;">Jard<br>929</div>
        `;
    }

    generateVerdeHorizontal() {
        const segments = [
            {l: 164.08, t: 237.19, w: 22.04},
            {l: 192.19, t: 237.19, w: 22.04},
            {l: 220.27, t: 237.19, w: 22.04},
            {l: 247.14, t: 237.19, w: 22.04},
            {l: 276.33, t: 237.19, w: 22.04},
            {l: 305.45, t: 237.19, w: 14.26},
            {l: 330.65, t: 237.19, w: 14.26},
            {l: 353.17, t: 237.19, w: 20.87},
            {l: 381.69, t: 237.19, w: 20.87},
            {l: 418.32, t: 237.19, w: 20.87},
            {l: 445.39, t: 237.19, w: 22.16},
            {l: 175.58, t: 406.66, w: 20.15, h: 3.66},
            {l: 205.64, t: 406.66, w: 19.42, h: 3.66},
            {l: 233.45, t: 406.66, w: 19.42, h: 3.66},
            {l: 259.91, t: 406.66, w: 55.96, h: 3.66},
            {l: 328.64, t: 406.66, w: 19.05, h: 3.66},
            {l: 358.43, t: 406.66, w: 19.05, h: 3.66},
            {l: 386.70, t: 406.66, w: 18.63, h: 3.66}
        ];
        
        return segments.map(s => 
            `<div class="area-verde" style="left:${s.l}px;top:${s.t}px;width:${s.w}px;height:${s.h || 5.15}px;"></div>`
        ).join('');
    }

    generateManzanas() {
        const html = [];
        
        for (const [num, pos] of Object.entries(BarrioData.manzanasPosiciones)) {
            const displayNum = num.toString().padStart(2, '0');
            const className = pos.tipo === 'v' ? 'manzana manzana-v' : 'manzana manzana-h';
            const style = pos.tipo === 'v' 
                ? `left:${pos.l}px;top:${pos.t}px;`
                : `left:${pos.l}px;top:${pos.t}px;width:${pos.w}px;`;
            const casas = BarrioData.casasPorManzana[num] || 0;
            
            html.push(
                `<div class="${className}" data-manzana="${num}" style="${style}" tabindex="0" role="button" aria-label="Manzana ${displayNum}, ${casas} casas">${displayNum}</div>`
            );
        }
        
        return html.join('\n');
    }

    setupGestures() {
        // Touch events para mobile
        let initialDistance = 0;
        let initialScale = 1;
        
        this.container.addEventListener('touchstart', (e) => {
            if (e.touches.length === 2) {
                initialDistance = this.getDistance(e.touches[0], e.touches[1]);
                initialScale = this.scale;
            } else if (e.touches.length === 1) {
                this.isDragging = true;
                this.startX = e.touches[0].clientX - this.translateX;
                this.startY = e.touches[0].clientY - this.translateY;
            }
        }, { passive: true });
        
        this.container.addEventListener('touchmove', (e) => {
            if (e.touches.length === 2) {
                const currentDistance = this.getDistance(e.touches[0], e.touches[1]);
                const newScale = initialScale * (currentDistance / initialDistance);
                this.setScale(Math.max(0.5, Math.min(3, newScale)));
            } else if (e.touches.length === 1 && this.isDragging) {
                this.translateX = e.touches[0].clientX - this.startX;
                this.translateY = e.touches[0].clientY - this.startY;
                this.updateTransform();
            }
        }, { passive: true });
        
        this.container.addEventListener('touchend', () => {
            this.isDragging = false;
        });
        this.container.addEventListener('touchcancel', () => {
            this.isDragging = false;
        });
        
        // Mouse events para desktop
        this.container.addEventListener('mousedown', (e) => {
            if (e.button !== 0) return;
            if (e.target.closest('.manzana')) return;
            this.isDragging = true;
            this.startX = e.clientX - this.translateX;
            this.startY = e.clientY - this.translateY;
            this.container.style.cursor = 'grabbing';
        });
        
        this.container.addEventListener('mousemove', (e) => {
            if (this.isDragging) {
                this.translateX = e.clientX - this.startX;
                this.translateY = e.clientY - this.startY;
                this.updateTransform();
            }
        });
        
        this.container.addEventListener('mouseup', () => {
            this.isDragging = false;
            this.container.style.cursor = 'grab';
        });
        
        this.container.addEventListener('mouseleave', () => {
            this.isDragging = false;
            this.container.style.cursor = 'grab';
        });
        
        // Wheel zoom
        this.container.addEventListener('wheel', (e) => {
            e.preventDefault();
            const delta = e.deltaY > 0 ? 0.9 : 1.1;
            this.setScale(Math.max(0.5, Math.min(3, this.scale * delta)));
        }, { passive: false });
        
        this.container.style.cursor = 'grab';
    }

    getDistance(touch1, touch2) {
        return Math.sqrt(
            Math.pow(touch2.clientX - touch1.clientX, 2) +
            Math.pow(touch2.clientY - touch1.clientY, 2)
        );
    }

    setScale(newScale) {
        this.scale = newScale;
        this.updateTransform();
    }

    updateTransform() {
        if (this.map) {
            this.map.style.transform = `translate(${this.translateX}px, ${this.translateY}px) scale(${this.scale})`;
        }
    }

    centerMap() {
        const containerRect = this.container.getBoundingClientRect();
        const mapWidth = 573;
        const mapHeight = 704;
        
        // Escala inicial para que quepa en pantalla
        const scaleX = containerRect.width / mapWidth;
        const scaleY = containerRect.height / mapHeight;
        this.scale = Math.min(scaleX, scaleY, 1) * 0.9;
        
        // Centrar
        this.translateX = (containerRect.width - mapWidth * this.scale) / 2;
        this.translateY = (containerRect.height - mapHeight * this.scale) / 2;
        
        this.updateTransform();
    }

    zoomIn() {
        this.setScale(Math.min(3, this.scale * 1.2));
    }

    zoomOut() {
        this.setScale(Math.max(0.5, this.scale * 0.8));
    }

    // Markers
    showMarker(type, x, y, label) {
        const marker = this.map.querySelector(`#marker${type.charAt(0).toUpperCase() + type.slice(1)}`);
        const labelEl = this.map.querySelector(`#label${type.charAt(0).toUpperCase() + type.slice(1)}`);
        
        if (marker) {
            marker.style.left = `${x}px`;
            marker.style.top = `${y}px`;
            marker.style.display = 'block';
            
            if (labelEl && label) {
                labelEl.textContent = label;
            }
        }
    }

    hideMarker(type) {
        const marker = this.map.querySelector(`#marker${type.charAt(0).toUpperCase() + type.slice(1)}`);
        if (marker) {
            marker.style.display = 'none';
        }
    }

    // Manzanas highlighting
    highlightManzana(num, type) {
        const el = this.map.querySelector(`.manzana[data-manzana="${num}"]`);
        if (el) {
            el.classList.add(type);
        }
    }

    clearHighlights() {
        this.map.querySelectorAll('.manzana.origin, .manzana.destination').forEach(el => {
            el.classList.remove('origin', 'destination');
        });
    }

    // Route drawing
    drawRoute(points) {
        const svg = this.map.querySelector('#routeSvg');
        svg.innerHTML = '';
        
        if (points.length < 2) return;
        
        let d = `M ${points[0].x} ${points[0].y}`;
        for (let i = 1; i < points.length; i++) {
            d += ` L ${points[i].x} ${points[i].y}`;
        }
        
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        path.setAttribute('d', d);
        path.setAttribute('class', 'route-path');
        svg.appendChild(path);
    }

    clearRoute() {
        const svg = this.map.querySelector('#routeSvg');
        svg.innerHTML = '';
    }
}
