/**
 * GPS Altos de Podesta - Router basado en grafo
 * - Construye un grafo de circulacion usando datos existentes del mapa.
 * - Ejecuta A* para calcular rutas.
 * - Evita atravesar manzanas validando colision de segmentos con obstaculos.
 */

class Router {
    constructor() {
        this.callesH = BarrioData.callesH;
        this.callesV = BarrioData.callesV;
        this.nodos = BarrioData.nodosManzana;
        this.manzanasDerechaVerde = BarrioData.manzanasDerechaVerde;

        this.obstacles = this.buildObstacleRects();
        this.baseGraph = this.buildBaseGraph();
        this.validateRandomRoutes(20);
    }

    // ========= Public API =========

    rutaDesdeFlorida(destManzana, destCasa) {
        const start = BarrioData.accesos.florida;
        const end = this.getPuntoMarcador(null, destManzana, destCasa);
        return this.routeBetweenPoints(start, end);
    }

    rutaDesdePrincipal(destManzana, destCasa) {
        const start = BarrioData.accesos.principal;
        const end = this.getPuntoMarcador(null, destManzana, destCasa);
        return this.routeBetweenPoints(start, end);
    }

    rutaEntreManzanas(origManzana, origCasa, destManzana, destCasa) {
        const start = this.getPuntoMarcador(null, origManzana, origCasa);
        const end = this.getPuntoMarcador(null, destManzana, destCasa);
        return this.routeBetweenPoints(start, end);
    }

    rutaDesdeGPS(gpsPos, destManzana, destCasa) {
        const snappedStart = this.snapPointToPath(gpsPos, 18);
        const end = this.getPuntoMarcador(null, destManzana, destCasa);
        return this.routeBetweenPoints(snappedStart || gpsPos, end);
    }

    calcularDistancia(puntos) {
        let total = 0;
        for (let i = 1; i < puntos.length; i++) {
            const dx = puntos[i].x - puntos[i - 1].x;
            const dy = puntos[i].y - puntos[i - 1].y;
            total += Math.sqrt(dx * dx + dy * dy);
        }
        return Math.round(total);
    }

    getPuntoMarcador(tipo, manzana, casa) {
        if (tipo === 'florida') return BarrioData.accesos.florida;
        if (tipo === 'principal') return BarrioData.accesos.principal;
        if (casa) return this.getPosicionCasa(manzana, casa);
        return this.nodos[manzana];
    }

    snapPointToPath(point, maxDistance = 20) {
        const nearest = this.findNearestEdgeProjection(point);
        if (!nearest || nearest.distance > maxDistance) return null;
        return nearest.point;
    }

    validateRandomRoutes(total = 20) {
        const manzanas = Object.keys(BarrioData.casasPorManzana).map((n) => parseInt(n, 10));
        const issues = [];

        for (let i = 0; i < total; i++) {
            const m1 = manzanas[Math.floor(Math.random() * manzanas.length)];
            const m2 = manzanas[Math.floor(Math.random() * manzanas.length)];
            const c1 = 1 + Math.floor(Math.random() * BarrioData.casasPorManzana[m1]);
            const c2 = 1 + Math.floor(Math.random() * BarrioData.casasPorManzana[m2]);
            const route = this.rutaEntreManzanas(m1, c1, m2, c2);

            if (route.length < 2) {
                issues.push(`sin ruta: M${m1}C${c1} -> M${m2}C${c2}`);
                continue;
            }

            let crosses = false;
            for (let s = 1; s < route.length; s++) {
                if (!this.isSegmentWalkable(route[s - 1], route[s])) {
                    crosses = true;
                    break;
                }
            }
            if (crosses) issues.push(`interseccion obstaculo: M${m1}C${c1} -> M${m2}C${c2}`);
        }

        if (issues.length) {
            console.warn('[Router] Validacion aleatoria con incidencias:', issues);
        } else {
            console.info(`[Router] Validacion aleatoria OK (${total} rutas sin cruces de manzanas).`);
        }
    }

    // ========= Core routing =========

    routeBetweenPoints(startPoint, endPoint) {
        const graph = this.cloneGraph(this.baseGraph);

        const startInfo = this.attachPointToGraph(graph, startPoint, 'start');
        const endInfo = this.attachPointToGraph(graph, endPoint, 'end');

        if (!startInfo || !endInfo) return [];

        const nodePath = this.aStar(graph, startInfo.nodeId, endInfo.nodeId);
        if (!nodePath.length) return [];

        const points = nodePath.map((id) => {
            const n = graph.nodes.get(id);
            return { x: n.x, y: n.y };
        });

        return this.simplifyRoute(points);
    }

    aStar(graph, startId, goalId) {
        const open = new Set([startId]);
        const cameFrom = new Map();
        const gScore = new Map();
        const fScore = new Map();

        for (const id of graph.nodes.keys()) {
            gScore.set(id, Number.POSITIVE_INFINITY);
            fScore.set(id, Number.POSITIVE_INFINITY);
        }
        gScore.set(startId, 0);
        fScore.set(startId, this.heuristic(graph, startId, goalId));

        while (open.size) {
            let current = null;
            let best = Number.POSITIVE_INFINITY;
            for (const id of open) {
                const f = fScore.get(id);
                if (f < best) {
                    best = f;
                    current = id;
                }
            }

            if (current === goalId) return this.reconstructPath(cameFrom, current);

            open.delete(current);
            const neighbors = graph.adjacency.get(current) || [];
            for (const edge of neighbors) {
                const tentative = gScore.get(current) + edge.weight;
                if (tentative >= gScore.get(edge.to)) continue;

                cameFrom.set(edge.to, current);
                gScore.set(edge.to, tentative);
                fScore.set(edge.to, tentative + this.heuristic(graph, edge.to, goalId));
                open.add(edge.to);
            }
        }

        return [];
    }

    heuristic(graph, fromId, toId) {
        const a = graph.nodes.get(fromId);
        const b = graph.nodes.get(toId);
        return Math.abs(a.x - b.x) + Math.abs(a.y - b.y);
    }

    reconstructPath(cameFrom, current) {
        const path = [current];
        while (cameFrom.has(current)) {
            current = cameFrom.get(current);
            path.unshift(current);
        }
        return path;
    }

    simplifyRoute(points) {
        if (points.length < 3) return points;
        const cleaned = [points[0]];

        for (let i = 1; i < points.length - 1; i++) {
            const a = cleaned[cleaned.length - 1];
            const b = points[i];
            const c = points[i + 1];

            const collinearX = Math.abs(a.x - b.x) < 0.01 && Math.abs(b.x - c.x) < 0.01;
            const collinearY = Math.abs(a.y - b.y) < 0.01 && Math.abs(b.y - c.y) < 0.01;
            if (collinearX || collinearY) continue;

            cleaned.push(b);
        }

        cleaned.push(points[points.length - 1]);
        return cleaned;
    }

    // ========= Graph construction =========

    buildBaseGraph() {
        const graph = {
            nodes: new Map(),
            adjacency: new Map(),
            edges: []
        };

        const xValues = new Set();
        const yValues = new Set();

        Object.values(this.nodos).forEach((n) => {
            xValues.add(this.roundCoord(n.x));
            yValues.add(this.roundCoord(n.y));
        });
        Object.values(BarrioData.accesos).forEach((n) => {
            xValues.add(this.roundCoord(n.x));
            yValues.add(this.roundCoord(n.y));
        });
        Object.values(this.callesV).forEach((x) => xValues.add(this.roundCoord(x)));
        Object.values(this.callesH).forEach((y) => yValues.add(this.roundCoord(y)));

        const sortedX = [...xValues].sort((a, b) => a - b);
        const sortedY = [...yValues].sort((a, b) => a - b);

        for (const x of sortedX) {
            for (const y of sortedY) {
                const p = { x, y };
                if (this.isPointBlocked(p)) continue;
                this.addNode(graph, p);
            }
        }

        this.connectOrthogonalNeighbors(graph);
        return graph;
    }

    connectOrthogonalNeighbors(graph) {
        const byY = new Map();
        const byX = new Map();

        for (const node of graph.nodes.values()) {
            const yKey = this.roundCoord(node.y);
            const xKey = this.roundCoord(node.x);

            if (!byY.has(yKey)) byY.set(yKey, []);
            if (!byX.has(xKey)) byX.set(xKey, []);
            byY.get(yKey).push(node);
            byX.get(xKey).push(node);
        }

        for (const line of byY.values()) {
            line.sort((a, b) => a.x - b.x);
            for (let i = 1; i < line.length; i++) {
                this.addEdgeIfWalkable(graph, line[i - 1].id, line[i].id);
            }
        }

        for (const line of byX.values()) {
            line.sort((a, b) => a.y - b.y);
            for (let i = 1; i < line.length; i++) {
                this.addEdgeIfWalkable(graph, line[i - 1].id, line[i].id);
            }
        }
    }

    addEdgeIfWalkable(graph, idA, idB) {
        const a = graph.nodes.get(idA);
        const b = graph.nodes.get(idB);
        if (!a || !b) return;
        if (!this.isSegmentWalkable(a, b)) return;
        this.addUndirectedEdge(graph, idA, idB);
    }

    attachPointToGraph(graph, point, prefix) {
        if (this.isPointBlocked(point)) return null;

        const nearestNode = this.findNearestNode(graph, point);
        if (nearestNode && this.distance(point, nearestNode) < 0.8) {
            return { nodeId: nearestNode.id, snapped: nearestNode };
        }

        const projection = this.findNearestEdgeProjection(point, graph);
        if (!projection) return null;

        let snapNodeId;
        const nearA = this.distance(projection.point, projection.a) < 0.8;
        const nearB = this.distance(projection.point, projection.b) < 0.8;

        if (nearA) {
            snapNodeId = projection.a.id;
        } else if (nearB) {
            snapNodeId = projection.b.id;
        } else {
            const snapNode = this.addNode(graph, projection.point, `${prefix}_snap`);
            snapNodeId = snapNode.id;
            this.addEdgeIfWalkable(graph, snapNodeId, projection.a.id);
            this.addEdgeIfWalkable(graph, snapNodeId, projection.b.id);
        }

        const sourceNode = this.addNode(graph, point, `${prefix}_src`);
        this.addEdgeIfWalkable(graph, sourceNode.id, snapNodeId);

        const neighbors = graph.adjacency.get(sourceNode.id) || [];
        if (!neighbors.length) return null;
        return { nodeId: sourceNode.id, snapped: graph.nodes.get(snapNodeId) };
    }

    findNearestNode(graph, point) {
        let best = null;
        let bestDist = Number.POSITIVE_INFINITY;
        for (const n of graph.nodes.values()) {
            const d = this.distance(n, point);
            if (d < bestDist) {
                bestDist = d;
                best = n;
            }
        }
        return best;
    }

    findNearestEdgeProjection(point, graph = this.baseGraph) {
        let best = null;
        let bestDistance = Number.POSITIVE_INFINITY;

        for (const edge of graph.edges) {
            const a = graph.nodes.get(edge.from);
            const b = graph.nodes.get(edge.to);
            const projected = this.projectPointToSegment(point, a, b);

            if (!this.isSegmentWalkable(point, projected.point)) continue;
            if (projected.distance < bestDistance) {
                bestDistance = projected.distance;
                best = { ...projected, a, b, distance: projected.distance };
            }
        }

        return best;
    }

    // ========= Geometry and helpers =========

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
            if (casa <= mitad) return { x: l + w + 3, y: t + h * (casa - 0.5) / mitad };
            return { x: l - 3, y: t + h - h * (casa - mitad - 0.5) / (total - mitad) };
        }

        if (casa <= mitad) return { x: l + w * (casa - 0.5) / mitad, y: t - 3 };
        return { x: l + w - w * (casa - mitad - 0.5) / (total - mitad), y: t + h + 3 };
    }

    buildObstacleRects() {
        const rects = [];
        for (const [id, pos] of Object.entries(BarrioData.manzanasPosiciones)) {
            const w = pos.w || 19.42;
            const h = pos.h || 35.33;
            rects.push({
                id: Number(id),
                left: pos.l,
                top: pos.t,
                right: pos.l + w,
                bottom: pos.t + h
            });
        }
        return rects;
    }

    isPointBlocked(point, eps = 0.8) {
        return this.obstacles.some((r) =>
            point.x > r.left + eps &&
            point.x < r.right - eps &&
            point.y > r.top + eps &&
            point.y < r.bottom - eps
        );
    }

    isSegmentWalkable(a, b, eps = 0.8) {
        if (this.isPointBlocked(a, eps) || this.isPointBlocked(b, eps)) return false;

        for (const rect of this.obstacles) {
            if (this.segmentIntersectsRectInterior(a, b, rect, eps)) return false;
        }
        return true;
    }

    segmentIntersectsRectInterior(a, b, rect, eps = 0.8) {
        const rx1 = rect.left + eps;
        const ry1 = rect.top + eps;
        const rx2 = rect.right - eps;
        const ry2 = rect.bottom - eps;

        if (rx1 >= rx2 || ry1 >= ry2) return false;

        const inside = (p) => p.x > rx1 && p.x < rx2 && p.y > ry1 && p.y < ry2;
        if (inside(a) || inside(b)) return true;

        const edges = [
            [{ x: rx1, y: ry1 }, { x: rx2, y: ry1 }],
            [{ x: rx2, y: ry1 }, { x: rx2, y: ry2 }],
            [{ x: rx2, y: ry2 }, { x: rx1, y: ry2 }],
            [{ x: rx1, y: ry2 }, { x: rx1, y: ry1 }]
        ];

        for (const [e1, e2] of edges) {
            if (this.segmentsIntersect(a, b, e1, e2)) return true;
        }

        const mid = { x: (a.x + b.x) / 2, y: (a.y + b.y) / 2 };
        return inside(mid);
    }

    segmentsIntersect(p1, p2, q1, q2) {
        const o1 = this.orientation(p1, p2, q1);
        const o2 = this.orientation(p1, p2, q2);
        const o3 = this.orientation(q1, q2, p1);
        const o4 = this.orientation(q1, q2, p2);

        if (o1 !== o2 && o3 !== o4) return true;
        if (o1 === 0 && this.onSegment(p1, q1, p2)) return true;
        if (o2 === 0 && this.onSegment(p1, q2, p2)) return true;
        if (o3 === 0 && this.onSegment(q1, p1, q2)) return true;
        if (o4 === 0 && this.onSegment(q1, p2, q2)) return true;
        return false;
    }

    orientation(a, b, c) {
        const val = (b.y - a.y) * (c.x - b.x) - (b.x - a.x) * (c.y - b.y);
        if (Math.abs(val) < 1e-9) return 0;
        return val > 0 ? 1 : 2;
    }

    onSegment(a, b, c) {
        return (
            b.x <= Math.max(a.x, c.x) &&
            b.x >= Math.min(a.x, c.x) &&
            b.y <= Math.max(a.y, c.y) &&
            b.y >= Math.min(a.y, c.y)
        );
    }

    projectPointToSegment(point, a, b) {
        const abx = b.x - a.x;
        const aby = b.y - a.y;
        const apx = point.x - a.x;
        const apy = point.y - a.y;
        const denom = abx * abx + aby * aby;
        const t = denom === 0 ? 0 : Math.max(0, Math.min(1, (apx * abx + apy * aby) / denom));
        const px = a.x + abx * t;
        const py = a.y + aby * t;
        return { point: { x: px, y: py }, t, distance: this.distance(point, { x: px, y: py }) };
    }

    distance(a, b) {
        const dx = a.x - b.x;
        const dy = a.y - b.y;
        return Math.sqrt(dx * dx + dy * dy);
    }

    addNode(graph, point, prefix = 'n') {
        const x = this.roundCoord(point.x);
        const y = this.roundCoord(point.y);
        const id = `${prefix}:${x}:${y}`;

        if (!graph.nodes.has(id)) {
            graph.nodes.set(id, { id, x, y });
            graph.adjacency.set(id, []);
        }
        return graph.nodes.get(id);
    }

    addUndirectedEdge(graph, idA, idB) {
        if (idA === idB) return;
        const a = graph.nodes.get(idA);
        const b = graph.nodes.get(idB);
        if (!a || !b) return;

        const w = this.distance(a, b);
        const arrA = graph.adjacency.get(idA);
        const arrB = graph.adjacency.get(idB);
        if (!arrA.some((e) => e.to === idB)) arrA.push({ to: idB, weight: w });
        if (!arrB.some((e) => e.to === idA)) arrB.push({ to: idA, weight: w });

        const keyA = `${idA}->${idB}`;
        const keyB = `${idB}->${idA}`;
        if (!graph.edges.some((e) => e.key === keyA || e.key === keyB)) {
            graph.edges.push({ key: keyA, from: idA, to: idB });
        }
    }

    cloneGraph(base) {
        const graph = {
            nodes: new Map(),
            adjacency: new Map(),
            edges: base.edges.map((e) => ({ ...e }))
        };

        for (const [id, node] of base.nodes.entries()) {
            graph.nodes.set(id, { ...node });
        }
        for (const [id, edges] of base.adjacency.entries()) {
            graph.adjacency.set(id, edges.map((e) => ({ ...e })));
        }
        return graph;
    }

    roundCoord(n) {
        return Number(n.toFixed(2));
    }
}
