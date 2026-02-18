/**
 * GPS Altos de Podestá - Router
 * Calcula rutas entre puntos del barrio
 */

class Router {
    constructor() {
        this.callesH = BarrioData.callesH;
        this.callesV = BarrioData.callesV;
        this.nodos = BarrioData.nodosManzana;
        this.manzanasDerechaVerde = BarrioData.manzanasDerechaVerde;
    }

    /**
     * Calcula la posición de una casa específica dentro de una manzana
     */
    getPosicionCasa(manzana, casa) {
        const pos = BarrioData.manzanasPosiciones[manzana];
        if (!pos) return this.nodos[manzana];
        
        const total = BarrioData.casasPorManzana[manzana];
        const mitad = Math.ceil(total / 2);
        const esVertical = pos.tipo === 'v';
        
        const l = pos.l;
        const t = pos.t;
        const w = pos.w || 19.42;
        const h = pos.h || 35.33;
        
        if (esVertical) {
            if (casa <= mitad) {
                return { x: l + w + 3, y: t + h * (casa - 0.5) / mitad };
            } else {
                return { x: l - 3, y: t + h - h * (casa - mitad - 0.5) / (total - mitad) };
            }
        } else {
            if (casa <= mitad) {
                return { x: l + w * (casa - 0.5) / mitad, y: t - 3 };
            } else {
                return { x: l + w - w * (casa - mitad - 0.5) / (total - mitad), y: t + h + 3 };
            }
        }
    }

    /**
     * Encuentra la calle horizontal más cercana
     */
    calleHMasCercana(y) {
        const calles = Object.values(this.callesH);
        return calles.reduce((mejor, c) => Math.abs(c - y) < Math.abs(mejor - y) ? c : mejor, calles[0]);
    }

    /**
     * Verifica si una manzana está del lado derecho del verde
     */
    estaDerechaVerde(manzana) {
        return this.manzanasDerechaVerde.includes(manzana);
    }

    /**
     * Ruta desde acceso Florida
     */
    rutaDesdeFlorida(destManzana, destCasa) {
        const puntos = [];
        const nodo = this.nodos[destManzana];
        
        puntos.push({ x: 456, y: this.callesH.florida });
        puntos.push({ x: 456, y: this.callesH.bajo_f1 });
        puntos.push({ x: 429, y: this.callesH.bajo_f1 });
        
        if (this.estaDerechaVerde(destManzana)) {
            puntos.push({ x: 429, y: nodo.y });
            if (nodo.x !== 429) {
                puntos.push({ x: nodo.x, y: nodo.y });
            }
        } else {
            puntos.push({ x: this.callesV.verde_izq, y: this.callesH.bajo_f1 });
            puntos.push({ x: this.callesV.verde_izq, y: nodo.y });
            puntos.push({ x: nodo.x, y: nodo.y });
        }
        
        if (destCasa) {
            this.agregarRutaACasa(puntos, destManzana, destCasa);
        }
        
        return puntos;
    }

    /**
     * Ruta desde acceso Principal
     */
    rutaDesdePrincipal(destManzana, destCasa) {
        const puntos = [];
        const nodo = this.nodos[destManzana];
        
        puntos.push({ x: 410, y: this.callesH.principal });
        
        if (this.estaDerechaVerde(destManzana)) {
            puntos.push({ x: 469, y: this.callesH.principal });
            puntos.push({ x: 469, y: nodo.y });
            if (nodo.x !== 469) {
                puntos.push({ x: nodo.x, y: nodo.y });
            }
        } else {
            puntos.push({ x: this.callesV.verde_der, y: this.callesH.principal });
            puntos.push({ x: this.callesV.verde_der, y: nodo.y });
            puntos.push({ x: nodo.x, y: nodo.y });
        }
        
        if (destCasa) {
            this.agregarRutaACasa(puntos, destManzana, destCasa);
        }
        
        return puntos;
    }

    /**
     * Ruta entre dos manzanas
     */
    rutaEntreManzanas(origManzana, origCasa, destManzana, destCasa) {
        const puntos = [];
        const origNodo = this.nodos[origManzana];
        const destNodo = this.nodos[destManzana];
        
        if (origCasa) {
            const inicio = this.getPosicionCasa(origManzana, origCasa);
            puntos.push(inicio);
            puntos.push({ x: inicio.x, y: origNodo.y });
            puntos.push(origNodo);
        } else {
            puntos.push(origNodo);
        }
        
        const origDerecha = this.estaDerechaVerde(origManzana);
        const destDerecha = this.estaDerechaVerde(destManzana);
        
        if (origDerecha === destDerecha) {
            if (origNodo.x !== destNodo.x) {
                puntos.push({ x: destNodo.x, y: origNodo.y });
            }
            if (origNodo.y !== destNodo.y) {
                puntos.push(destNodo);
            }
        } else {
            puntos.push({ x: origNodo.x, y: destNodo.y });
            
            if (origDerecha) {
                puntos.push({ x: this.callesV.verde_der, y: destNodo.y });
                puntos.push({ x: this.callesV.verde_izq, y: destNodo.y });
            } else {
                puntos.push({ x: this.callesV.verde_izq, y: destNodo.y });
                puntos.push({ x: this.callesV.verde_der, y: destNodo.y });
            }
            
            puntos.push(destNodo);
        }
        
        if (destCasa) {
            this.agregarRutaACasa(puntos, destManzana, destCasa);
        }
        
        return puntos;
    }

    /**
     * Ruta desde GPS
     */
    rutaDesdeGPS(gpsPos, destManzana, destCasa) {
        const puntos = [];
        const destNodo = this.nodos[destManzana];
        const calleY = this.calleHMasCercana(gpsPos.y);
        
        puntos.push(gpsPos);
        puntos.push({ x: gpsPos.x, y: calleY });
        puntos.push({ x: destNodo.x, y: calleY });
        
        if (destNodo.y !== calleY) {
            puntos.push(destNodo);
        }
        
        if (destCasa) {
            this.agregarRutaACasa(puntos, destManzana, destCasa);
        }
        
        return puntos;
    }

    /**
     * Agrega el tramo final a una casa específica
     */
    agregarRutaACasa(puntos, manzana, casa) {
        const posCasa = this.getPosicionCasa(manzana, casa);
        const ultimo = puntos[puntos.length - 1];
        
        if (Math.abs(posCasa.y - ultimo.y) < 5 || Math.abs(posCasa.x - ultimo.x) < 5) {
            puntos.push(posCasa);
        } else {
            puntos.push({ x: posCasa.x, y: ultimo.y });
            puntos.push(posCasa);
        }
    }

    /**
     * Calcula la distancia total de una ruta
     */
    calcularDistancia(puntos) {
        let total = 0;
        for (let i = 1; i < puntos.length; i++) {
            const dx = puntos[i].x - puntos[i - 1].x;
            const dy = puntos[i].y - puntos[i - 1].y;
            total += Math.sqrt(dx * dx + dy * dy);
        }
        return Math.round(total);
    }

    /**
     * Obtiene el punto para un marcador
     */
    getPuntoMarcador(tipo, manzana, casa) {
        if (tipo === 'florida') {
            return BarrioData.accesos.florida;
        }
        if (tipo === 'principal') {
            return BarrioData.accesos.principal;
        }
        if (casa) {
            return this.getPosicionCasa(manzana, casa);
        }
        return this.nodos[manzana];
    }
}
