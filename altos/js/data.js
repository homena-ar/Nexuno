/**
 * GPS Altos de Podestá - Data
 * Datos del barrio: manzanas, casas, calles, coordenadas
 */

const BarrioData = {
    // Cantidad de casas por manzana
    casasPorManzana: {
        3: 32, 4: 26, 5: 32, 6: 26, 7: 32, 8: 32, 9: 32, 10: 32,
        11: 32, 12: 32, 13: 32, 14: 32, 15: 20, 16: 20, 17: 20, 18: 20,
        19: 20, 20: 20, 23: 32, 24: 32, 25: 28, 26: 28, 27: 24, 28: 20,
        29: 18, 30: 32, 31: 32, 32: 32, 33: 32, 34: 32, 35: 32, 36: 32,
        37: 32, 38: 32, 39: 32, 40: 32, 41: 32, 42: 32, 43: 32, 44: 32,
        45: 32, 46: 32, 47: 32, 48: 32, 49: 32, 50: 26, 51: 26, 52: 32,
        53: 32, 54: 32, 55: 32, 56: 32, 57: 32, 58: 22, 59: 48, 60: 41,
        61: 18, 62: 32, 63: 32, 64: 32, 65: 26, 66: 26, 67: 26, 70: 26,
        75: 32, 78: 32, 79: 32, 80: 32, 81: 32, 82: 32, 83: 32, 84: 32,
        85: 32, 86: 32, 87: 32, 88: 32, 89: 32, 90: 32, 91: 32, 92: 32,
        93: 32, 94: 32, 95: 32, 96: 32, 97: 32, 99: 32
    },

    // Calles horizontales (Y)
    callesH: {
        florida: 73,
        bajo_f1: 110,
        bajo_f2: 152,
        bajo_f3: 193,
        bajo_f4: 234,
        bajo_verde_h: 244,
        bajo_f5: 284,
        bajo_f6: 324,
        bajo_f7: 364,
        bajo_f8: 405,
        bajo_f9: 436,
        bajo_f10: 463,
        bajo_f11: 491,
        bajo_f12: 519,
        bajo_f13: 549,
        bajo_f14: 577,
        principal: 590
    },

    // Calles verticales importantes
    callesV: {
        verde_izq: 405,
        verde_der: 416
    },

    // Nodos de manzana (punto de acceso en la calle)
    nodosManzana: {
        99: {x: 256, y: 110}, 94: {x: 283, y: 110}, 93: {x: 310, y: 110},
        92: {x: 337, y: 110}, 91: {x: 364, y: 110},
        
        97: {x: 229, y: 152}, 96: {x: 256, y: 152}, 95: {x: 283, y: 152},
        84: {x: 310, y: 152}, 83: {x: 337, y: 152}, 82: {x: 364, y: 152},
        81: {x: 391, y: 152}, 80: {x: 429, y: 152}, 79: {x: 456, y: 152},
        
        90: {x: 175, y: 193}, 89: {x: 202, y: 193}, 88: {x: 229, y: 193},
        87: {x: 256, y: 193}, 86: {x: 283, y: 193}, 85: {x: 310, y: 193},
        64: {x: 337, y: 193}, 63: {x: 364, y: 193}, 62: {x: 391, y: 193},
        3:  {x: 429, y: 193}, 5:  {x: 456, y: 193},
        
        70: {x: 175, y: 234}, 51: {x: 202, y: 234}, 50: {x: 229, y: 234},
        67: {x: 337, y: 234}, 66: {x: 364, y: 234}, 65: {x: 391, y: 234},
        4:  {x: 429, y: 234}, 6:  {x: 456, y: 234},
        
        52: {x: 202, y: 284}, 47: {x: 230, y: 284}, 44: {x: 258, y: 284},
        41: {x: 287, y: 284}, 38: {x: 316, y: 284}, 34: {x: 344, y: 284},
        30: {x: 374, y: 284}, 11: {x: 429, y: 284}, 7:  {x: 456, y: 284},
        
        53: {x: 202, y: 324}, 48: {x: 230, y: 324}, 45: {x: 258, y: 324},
        42: {x: 287, y: 324}, 39: {x: 316, y: 324}, 35: {x: 344, y: 324},
        31: {x: 374, y: 324}, 12: {x: 429, y: 324}, 8:  {x: 456, y: 324},
        
        54: {x: 202, y: 364}, 49: {x: 230, y: 364}, 46: {x: 258, y: 364},
        43: {x: 287, y: 364}, 40: {x: 316, y: 364}, 36: {x: 344, y: 364},
        32: {x: 374, y: 364}, 13: {x: 429, y: 364}, 9:  {x: 456, y: 364},
        
        78: {x: 122, y: 405}, 75: {x: 148, y: 405}, 57: {x: 184, y: 405},
        56: {x: 215, y: 405}, 55: {x: 243, y: 405}, 37: {x: 337, y: 405},
        33: {x: 368, y: 405}, 23: {x: 395, y: 405}, 14: {x: 429, y: 405},
        10: {x: 456, y: 405},
        
        59: {x: 187, y: 436}, 58: {x: 285, y: 436}, 24: {x: 362, y: 436},
        15: {x: 444, y: 436},
        
        60: {x: 209, y: 463}, 25: {x: 365, y: 463}, 16: {x: 444, y: 463},
        
        61: {x: 209, y: 491}, 26: {x: 367, y: 491}, 17: {x: 444, y: 491},
        
        27: {x: 371, y: 519}, 18: {x: 444, y: 519},
        
        28: {x: 374, y: 549}, 19: {x: 444, y: 549},
        
        29: {x: 376, y: 577}, 20: {x: 444, y: 577}
    },

    // Manzanas del lado derecho del verde (acceso diferente)
    manzanasDerechaVerde: [79, 80, 5, 3, 6, 4, 7, 11, 8, 12, 9, 13, 10, 14, 15, 16, 17, 18, 19, 20],

    // Posiciones de las manzanas para el mapa (left, top, width, height, tipo)
    manzanasPosiciones: {
        // Fila 1
        99: {l: 246.34, t: 72.75, w: 19.42, h: 35.33, tipo: 'v'},
        94: {l: 273.41, t: 72.75, w: 19.42, h: 35.33, tipo: 'v'},
        93: {l: 300.48, t: 72.75, w: 19.42, h: 35.33, tipo: 'v'},
        92: {l: 327.55, t: 72.75, w: 19.42, h: 35.33, tipo: 'v'},
        91: {l: 354.62, t: 72.75, w: 19.42, h: 35.33, tipo: 'v'},
        
        // Fila 2
        97: {l: 219.27, t: 114.14, w: 19.42, h: 35.33, tipo: 'v'},
        96: {l: 246.34, t: 114.14, w: 19.42, h: 35.33, tipo: 'v'},
        95: {l: 273.41, t: 114.14, w: 19.42, h: 35.33, tipo: 'v'},
        84: {l: 300.48, t: 114.14, w: 19.42, h: 35.33, tipo: 'v'},
        83: {l: 327.55, t: 114.14, w: 19.42, h: 35.33, tipo: 'v'},
        82: {l: 354.62, t: 114.14, w: 19.42, h: 35.33, tipo: 'v'},
        81: {l: 381.69, t: 114.14, w: 19.42, h: 35.33, tipo: 'v'},
        80: {l: 419.77, t: 114.14, w: 19.42, h: 35.33, tipo: 'v'},
        79: {l: 446.84, t: 114.14, w: 19.42, h: 35.33, tipo: 'v'},
        
        // Fila 3
        90: {l: 164.98, t: 155.53, w: 19.42, h: 35.33, tipo: 'v'},
        89: {l: 192.62, t: 155.53, w: 19.42, h: 35.33, tipo: 'v'},
        88: {l: 219.27, t: 155.53, w: 19.42, h: 35.33, tipo: 'v'},
        87: {l: 246.34, t: 155.53, w: 19.42, h: 35.33, tipo: 'v'},
        86: {l: 273.41, t: 155.53, w: 19.42, h: 35.33, tipo: 'v'},
        85: {l: 300.48, t: 155.53, w: 19.42, h: 35.33, tipo: 'v'},
        64: {l: 327.55, t: 155.53, w: 19.42, h: 35.33, tipo: 'v'},
        63: {l: 354.62, t: 155.53, w: 19.42, h: 35.33, tipo: 'v'},
        62: {l: 381.69, t: 155.53, w: 19.42, h: 35.33, tipo: 'v'},
        3:  {l: 419.77, t: 155.53, w: 19.42, h: 35.33, tipo: 'v'},
        5:  {l: 446.84, t: 155.53, w: 19.42, h: 35.33, tipo: 'v'},
        
        // Fila 4
        70: {l: 164.98, t: 196.91, w: 19.42, h: 35.33, tipo: 'v'},
        51: {l: 192.62, t: 196.91, w: 19.42, h: 35.33, tipo: 'v'},
        50: {l: 219.27, t: 196.91, w: 19.42, h: 35.33, tipo: 'v'},
        67: {l: 327.55, t: 196.91, w: 19.42, h: 35.33, tipo: 'v'},
        66: {l: 354.62, t: 196.91, w: 19.42, h: 35.33, tipo: 'v'},
        65: {l: 381.69, t: 196.91, w: 19.42, h: 35.33, tipo: 'v'},
        4:  {l: 419.77, t: 196.91, w: 19.42, h: 35.33, tipo: 'v'},
        6:  {l: 446.84, t: 196.91, w: 19.42, h: 35.33, tipo: 'v'},
        
        // Fila 5
        52: {l: 192.19, t: 247.30, w: 19.42, h: 35.33, tipo: 'v'},
        47: {l: 220.27, t: 247.30, w: 19.42, h: 35.33, tipo: 'v'},
        44: {l: 248.45, t: 247.30, w: 19.42, h: 35.33, tipo: 'v'},
        41: {l: 277.64, t: 247.30, w: 19.42, h: 35.33, tipo: 'v'},
        38: {l: 306.76, t: 247.30, w: 19.42, h: 35.33, tipo: 'v'},
        34: {l: 334.66, t: 247.30, w: 19.42, h: 35.33, tipo: 'v'},
        30: {l: 364.33, t: 247.30, w: 19.42, h: 35.33, tipo: 'v'},
        11: {l: 419.77, t: 247.30, w: 19.42, h: 35.33, tipo: 'v'},
        7:  {l: 446.84, t: 247.30, w: 19.42, h: 35.33, tipo: 'v'},
        
        // Fila 6
        53: {l: 192.19, t: 287.19, w: 19.42, h: 35.33, tipo: 'v'},
        48: {l: 220.27, t: 287.19, w: 19.42, h: 35.33, tipo: 'v'},
        45: {l: 248.45, t: 287.19, w: 19.42, h: 35.33, tipo: 'v'},
        42: {l: 277.64, t: 287.19, w: 19.42, h: 35.33, tipo: 'v'},
        39: {l: 306.76, t: 287.19, w: 19.42, h: 35.33, tipo: 'v'},
        35: {l: 335.20, t: 287.19, w: 19.42, h: 35.33, tipo: 'v'},
        31: {l: 364.33, t: 287.19, w: 19.42, h: 35.33, tipo: 'v'},
        12: {l: 419.77, t: 287.19, w: 19.42, h: 35.33, tipo: 'v'},
        8:  {l: 446.84, t: 287.19, w: 19.42, h: 35.33, tipo: 'v'},
        
        // Fila 7
        54: {l: 192.19, t: 327.07, w: 19.42, h: 35.33, tipo: 'v'},
        49: {l: 220.27, t: 327.07, w: 19.42, h: 35.33, tipo: 'v'},
        46: {l: 248.45, t: 327.07, w: 19.42, h: 35.33, tipo: 'v'},
        43: {l: 277.64, t: 327.07, w: 19.42, h: 35.33, tipo: 'v'},
        40: {l: 306.76, t: 327.07, w: 19.42, h: 35.33, tipo: 'v'},
        36: {l: 335.20, t: 327.07, w: 19.42, h: 35.33, tipo: 'v'},
        32: {l: 364.33, t: 327.07, w: 19.42, h: 35.33, tipo: 'v'},
        13: {l: 419.77, t: 327.07, w: 19.42, h: 35.33, tipo: 'v'},
        9:  {l: 446.84, t: 327.07, w: 19.42, h: 35.33, tipo: 'v'},
        
        // Fila 8
        78: {l: 112.27, t: 367.46, w: 19.42, h: 35.33, tipo: 'v'},
        75: {l: 138.70, t: 367.46, w: 19.42, h: 35.33, tipo: 'v'},
        57: {l: 174.83, t: 367.46, w: 19.42, h: 35.33, tipo: 'v'},
        56: {l: 205.64, t: 367.46, w: 19.42, h: 35.33, tipo: 'v'},
        55: {l: 233.12, t: 367.46, w: 19.42, h: 35.33, tipo: 'v'},
        37: {l: 327.55, t: 367.46, w: 19.42, h: 35.33, tipo: 'v'},
        33: {l: 358.61, t: 367.46, w: 19.42, h: 35.33, tipo: 'v'},
        23: {l: 385.10, t: 367.46, w: 19.42, h: 35.33, tipo: 'v'},
        14: {l: 419.77, t: 367.46, w: 19.42, h: 35.33, tipo: 'v'},
        10: {l: 446.84, t: 367.46, w: 19.42, h: 35.33, tipo: 'v'},
        
        // Horizontales
        59: {l: 120.74, t: 414.63, w: 132.12, h: 18.94, tipo: 'h'},
        58: {l: 258.16, t: 414.63, w: 53.14, h: 18.94, tipo: 'h'},
        24: {l: 321.19, t: 414.63, w: 81.20, h: 18.94, tipo: 'h'},
        15: {l: 419.91, t: 414.63, w: 48.41, h: 18.94, tipo: 'h'},
        
        60: {l: 138.79, t: 441.51, w: 140.69, h: 18.94, tipo: 'h'},
        25: {l: 327.99, t: 442.57, w: 73.99, h: 18.94, tipo: 'h'},
        16: {l: 419.91, t: 442.57, w: 48.41, h: 18.94, tipo: 'h'},
        
        61: {l: 188.89, t: 468.80, w: 41.28, h: 18.94, tipo: 'h'},
        26: {l: 332.84, t: 470.92, w: 69.27, h: 18.94, tipo: 'h'},
        17: {l: 419.91, t: 470.92, w: 48.41, h: 18.94, tipo: 'h'},
        
        27: {l: 339.21, t: 499.26, w: 63.10, h: 18.94, tipo: 'h'},
        18: {l: 419.91, t: 499.26, w: 48.41, h: 18.94, tipo: 'h'},
        
        28: {l: 345.67, t: 527.61, w: 56.83, h: 18.94, tipo: 'h'},
        19: {l: 419.91, t: 527.61, w: 48.41, h: 18.94, tipo: 'h'},
        
        29: {l: 350.38, t: 555.96, w: 52.26, h: 18.94, tipo: 'h'},
        20: {l: 419.91, t: 555.96, w: 48.41, h: 18.94, tipo: 'h'}
    },

    // Coordenadas GPS del barrio (para conversión)
    gpsLimits: {
        latMin: -34.5940,
        latMax: -34.5890,
        lonMin: -58.6230,
        lonMax: -58.6160,
        xMin: 108,
        xMax: 470,
        yMin: 70,
        yMax: 590
    },

    // ViewBox útil del mapa renderizado
    mapViewBox: {
        xMin: 0,
        xMax: 573.16,
        yMin: 0,
        yMax: 704.08
    },

    // Puntos de control base para proyección afín GPS -> mapa.
    // Formato: lat/lon reales y su coordenada x/y en el plano del mapa.
    gpsControlPoints: [
        { lat: -34.5890, lon: -58.6230, x: 108, y: 70 },  // NW
        { lat: -34.5890, lon: -58.6160, x: 470, y: 70 },  // NE
        { lat: -34.5940, lon: -58.6230, x: 108, y: 590 }  // SW
    ],

    // Corredores con sentido único cuando hay separador verde.
    // Si no hay corredor aplicable, se asume doble mano.
    oneWayCorridors: [
        // Eje vertical principal con separador verde central.
        // Derecha (x mayor): ingreso hacia adentro del barrio (y decrece).
        { id: 'principal-east-inbound', orientation: 'vertical', minX: 420, maxX: 466, minY: 110, maxY: 590, forward: 'up' },
        // Izquierda (x menor): egreso (y crece).
        { id: 'principal-west-outbound', orientation: 'vertical', minX: 380, maxX: 404.5, minY: 110, maxY: 590, forward: 'down' }
    ],

    // Obstáculos no caminables adicionales a las manzanas.
    // Se usan rectángulos existentes del dibujo del mapa (no inventados).
    extraObstacles: [
        { id: 'plaza-secundaria', left: 245.62, top: 195.05, right: 319.89, bottom: 232.24 },
        { id: 'plaza-benitez', left: 259.91, top: 365.74, right: 322.07, bottom: 402.78 },
        { id: 'verde-vert-1', left: 408.11, top: 114.14, right: 412.49, bottom: 149.47 },
        { id: 'verde-vert-2', left: 408.11, top: 155.53, right: 412.49, bottom: 190.86 },
        { id: 'verde-vert-3', left: 408.11, top: 196.91, right: 412.49, bottom: 232.24 },
        { id: 'verde-vert-4', left: 409.40, top: 247.30, right: 413.78, bottom: 282.63 },
        { id: 'verde-vert-5', left: 409.40, top: 287.19, right: 413.78, bottom: 322.52 },
        { id: 'verde-vert-6', left: 409.40, top: 325.97, right: 413.78, bottom: 362.40 },
        { id: 'verde-vert-7', left: 410.28, top: 367.53, right: 414.66, bottom: 402.86 },
        { id: 'verde-vert-8', left: 409.24, top: 414.22, right: 413.62, bottom: 434.37 },
        { id: 'verde-vert-9', left: 408.62, top: 440.91, right: 413.15, bottom: 463.09 },
        { id: 'verde-vert-10', left: 408.62, top: 469.29, right: 413.15, bottom: 491.47 },
        { id: 'verde-vert-11', left: 408.62, top: 497.68, right: 413.15, bottom: 516.89 },
        { id: 'verde-vert-12', left: 408.62, top: 525.59, right: 413.15, bottom: 546.55 },
        { id: 'verde-vert-13', left: 408.62, top: 553.94, right: 413.15, bottom: 574.90 },
        { id: 'verde-vert-14', left: 390.11, top: 247.30, right: 405.07, bottom: 282.63 },
        { id: 'verde-vert-15', left: 164.42, top: 365.74, right: 168.53, bottom: 402.78 },
        { id: 'verde-sep-1', left: 164.08, top: 237.19, right: 186.12, bottom: 242.34 },
        { id: 'verde-sep-2', left: 192.19, top: 237.19, right: 214.23, bottom: 242.34 },
        { id: 'verde-sep-3', left: 220.27, top: 237.19, right: 242.31, bottom: 242.34 },
        { id: 'verde-sep-4', left: 247.14, top: 237.19, right: 269.18, bottom: 242.34 },
        { id: 'verde-sep-5', left: 276.33, top: 237.19, right: 298.37, bottom: 242.34 },
        { id: 'verde-sep-6', left: 305.45, top: 237.19, right: 319.71, bottom: 242.34 },
        { id: 'verde-sep-7', left: 330.65, top: 237.19, right: 344.91, bottom: 242.34 },
        { id: 'verde-sep-8', left: 353.17, top: 237.19, right: 374.04, bottom: 242.34 },
        { id: 'verde-sep-9', left: 381.69, top: 237.19, right: 402.56, bottom: 242.34 },
        { id: 'verde-sep-10', left: 418.32, top: 237.19, right: 439.19, bottom: 242.34 },
        { id: 'verde-sep-11', left: 445.39, top: 237.19, right: 467.55, bottom: 242.34 }
    ],

    // Accesos
    accesos: {
        florida: { x: 456, y: 73 },
        principal: { x: 410, y: 590 }
    }
};

// Congelar para evitar modificaciones
Object.freeze(BarrioData);
Object.freeze(BarrioData.casasPorManzana);
Object.freeze(BarrioData.nodosManzana);
Object.freeze(BarrioData.manzanasPosiciones);
