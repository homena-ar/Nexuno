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
        this.oneWayCorridors = BarrioData.oneWayCorridors || [];
        this.extraObstacles = BarrioData.extraObstacles || [];

        this.obstacles = this.buildObstacleRects();
        this.baseGraph = this.buildBaseGraph();
        this.auditWalkableEdges();
        this.validateRandomRoutes(200);
        this.scheduleConnectivityAudit();
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
        if (origManzana === destManzana && origCasa && destCasa) {
            const start = this.getPuntoMarcador(null, origManzana, origCasa);
            const end = this.getPuntoMarcador(null, destManzana, destCasa);
            const local = this.routeAroundSameManzana(origManzana, start, end);
            if (local.length >= 2) return local;
        }

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
        const raw = casa ? this.getPosicionCasa(manzana, casa) : this.nodos[manzana];
        return this.resolveReachableAccessPoint(raw, manzana);
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
            let wrongWay = false;
            for (let s = 1; s < route.length; s++) {
                if (!this.isSegmentWalkable(route[s - 1], route[s])) {
                    crosses = true;
                    break;
                }
                if (!this.isDirectionAllowed(route[s - 1], route[s])) {
                    wrongWay = true;
                    break;
                }
            }
            if (crosses) issues.push(`interseccion obstaculo: M${m1}C${c1} -> M${m2}C${c2}`);
            if (wrongWay) issues.push(`contramano: M${m1}C${c1} -> M${m2}C${c2}`);
        }

        if (issues.length) {
            console.warn('[Router] Validacion aleatoria con incidencias:', issues);
        } else {
            console.info(`[Router] Validacion aleatoria OK (${total} rutas sin cruces de manzanas).`);
        }
    }

    validateAllConnectivity() {
        const report = [];
        const manzanas = Object.keys(BarrioData.casasPorManzana).map((n) => parseInt(n, 10));
        for (const manzana of manzanas) {
            const casas = BarrioData.casasPorManzana[manzana];
            let unreachable = 0;
            let sample = null;

            for (let casa = 1; casa <= casas; casa++) {
                const r1 = this.rutaDesdePrincipal(manzana, casa);
                const r2 = this.rutaDesdeFlorida(manzana, casa);
                const hasRoute = (r1 && r1.length >= 2) || (r2 && r2.length >= 2);
                if (hasRoute) continue;

                unreachable++;
                if (!sample) {
                    const anchor = this.getPosicionCasa(manzana, casa);
                    sample = this.describeDisconnection(anchor);
                    sample.casa = casa;
                }
            }

            if (unreachable > 0) {
                report.push({
                    manzana,
                    casasSinRuta: unreachable,
                    totalCasas: casas,
                    zonaCorte: sample
                });
            }
        }

        if (report.length) {
            console.warn('[Router] Reporte de conectividad (manzanas inaccesibles)', report);
        } else {
            console.info('[Router] Conectividad completa: todas las manzanas/casas tienen ruta.');
        }
    }

    scheduleConnectivityAudit() {
        if (typeof window === 'undefined' || typeof window.setTimeout !== 'function') return;
        window.setTimeout(() => this.validateAllConnectivityAsync(), 0);
    }

    validateAllConnectivityAsync(chunkSize = 80) {
        const manzanas = Object.keys(BarrioData.casasPorManzana).map((n) => parseInt(n, 10));
        const queue = [];
        for (const manzana of manzanas) {
            const casas = BarrioData.casasPorManzana[manzana];
            for (let casa = 1; casa <= casas; casa++) {
                queue.push({ manzana, casa, totalCasas: casas });
            }
        }

        const byManzana = new Map();
        const tick = () => {
            let processed = 0;
            while (queue.length && processed < chunkSize) {
                processed++;
                const item = queue.shift();
                const r1 = this.rutaDesdePrincipal(item.manzana, item.casa);
                const r2 = this.rutaDesdeFlorida(item.manzana, item.casa);
                const hasRoute = (r1 && r1.length >= 2) || (r2 && r2.length >= 2);
                if (hasRoute) continue;

                const prev = byManzana.get(item.manzana) || {
                    manzana: item.manzana,
                    casasSinRuta: 0,
                    totalCasas: item.totalCasas,
                    zonaCorte: null
                };
                prev.casasSinRuta++;
                if (!prev.zonaCorte) {
                    const anchor = this.getPosicionCasa(item.manzana, item.casa);
                    prev.zonaCorte = { casa: item.casa, ...this.describeDisconnection(anchor) };
                }
                byManzana.set(item.manzana, prev);
            }

            if (queue.length) {
                window.setTimeout(tick, 0);
                return;
            }

            const report = [...byManzana.values()];
            if (report.length) {
                console.warn('[Router] Reporte de conectividad (manzanas inaccesibles)', report);
            } else {
                console.info('[Router] Conectividad completa: todas las manzanas/casas tienen ruta.');
            }
        };

        tick();
    }

    getDebugData() {
        const nodes = [];
        const edges = [];
        for (const node of this.baseGraph.nodes.values()) {
            nodes.push({ x: node.x, y: node.y });
        }
        for (const edge of this.baseGraph.edges) {
            const a = this.baseGraph.nodes.get(edge.from);
            const b = this.baseGraph.nodes.get(edge.to);
            if (a && b) {
                edges.push({ a: { x: a.x, y: a.y }, b: { x: b.x, y: b.y } });
            }
        }
        const obstacles = this.obstacles.map((o) => ({
            left: o.left,
            top: o.top,
            width: o.right - o.left,
            height: o.bottom - o.top
        }));

        return { nodes, edges, obstacles };
    }

    auditWalkableEdges(limit = 40) {
        let issues = 0;
        for (const edge of this.baseGraph.edges) {
            const a = this.baseGraph.nodes.get(edge.from);
            const b = this.baseGraph.nodes.get(edge.to);
            const crossing = this.getFirstCrossedObstacle(a, b);
            if (!crossing) continue;

            issues++;
            if (issues <= limit) {
                console.error('[Router] Edge walkable cruza manzana', {
                    edgeId: edge.key,
                    from: edge.from,
                    to: edge.to,
                    a,
                    b,
                    obstacleId: crossing.id,
                    obstacle: crossing
                });
            }
        }

        if (issues > limit) {
            console.error(`[Router] Se detectaron ${issues - limit} cruces extra no mostrados.`);
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
        this.addEdgeByTrafficRule(graph, idA, idB);
    }

    addAccessEdgeIfWalkable(graph, idA, idB) {
        const a = graph.nodes.get(idA);
        const b = graph.nodes.get(idB);
        if (!a || !b) return;
        if (!this.isSegmentWalkable(a, b)) return;
        this.addDirectedEdge(graph, idA, idB);
        this.addDirectedEdge(graph, idB, idA);
    }

    addEdgeByTrafficRule(graph, idA, idB) {
        const a = graph.nodes.get(idA);
        const b = graph.nodes.get(idB);
        if (!a || !b) return;

        const allowAB = this.isDirectionAllowed(a, b);
        const allowBA = this.isDirectionAllowed(b, a);

        if (allowAB) this.addDirectedEdge(graph, idA, idB);
        if (allowBA) this.addDirectedEdge(graph, idB, idA);
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
        this.addAccessEdgeIfWalkable(graph, sourceNode.id, snapNodeId);

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
        for (const obs of this.extraObstacles) {
            rects.push({
                id: obs.id,
                left: obs.left,
                top: obs.top,
                right: obs.right,
                bottom: obs.bottom
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

    isSegmentWalkable(a, b, eps = 0.4) {
        if (this.isPointBlocked(a, eps) || this.isPointBlocked(b, eps)) return false;
        return !this.getFirstCrossedObstacle(a, b, eps);
    }

    getFirstCrossedObstacle(a, b, eps = 0.4) {
        for (const rect of this.obstacles) {
            if (this.segmentIntersectsRect(a, b, rect, eps)) return rect;
        }
        return null;
    }

    // Intersección robusta segmento-rectángulo (Liang-Barsky).
    // Toca o atraviesa interior => true.
    segmentIntersectsRect(a, b, rect, eps = 0.4) {
        const rx1 = rect.left - eps;
        const ry1 = rect.top - eps;
        const rx2 = rect.right + eps;
        const ry2 = rect.bottom + eps;

        if (Math.max(a.x, b.x) < rx1 || Math.min(a.x, b.x) > rx2 || Math.max(a.y, b.y) < ry1 || Math.min(a.y, b.y) > ry2) {
            return false;
        }

        const dx = b.x - a.x;
        const dy = b.y - a.y;
        const p = [-dx, dx, -dy, dy];
        const q = [a.x - rx1, rx2 - a.x, a.y - ry1, ry2 - a.y];

        let u1 = 0;
        let u2 = 1;

        for (let i = 0; i < 4; i++) {
            if (Math.abs(p[i]) < 1e-12) {
                if (q[i] < 0) return false;
                continue;
            }
            const t = q[i] / p[i];
            if (p[i] < 0) {
                if (t > u2) return false;
                if (t > u1) u1 = t;
            } else {
                if (t < u1) return false;
                if (t < u2) u2 = t;
            }
        }

        return u1 <= u2;
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

    isDirectionAllowed(from, to) {
        const corridor = this.getMatchingCorridor(from, to);
        if (!corridor) return true;

        if (corridor.orientation === 'vertical') {
            const dy = to.y - from.y;
            if (Math.abs(dy) < 0.01) return true;
            return corridor.forward === 'up' ? dy < 0 : dy > 0;
        }

        if (corridor.orientation === 'horizontal') {
            const dx = to.x - from.x;
            if (Math.abs(dx) < 0.01) return true;
            return corridor.forward === 'right' ? dx > 0 : dx < 0;
        }

        return true;
    }

    getMatchingCorridor(a, b) {
        const dx = Math.abs(a.x - b.x);
        const dy = Math.abs(a.y - b.y);
        const mx = (a.x + b.x) / 2;
        const my = (a.y + b.y) / 2;
        const tol = 1.2;

        for (const c of this.oneWayCorridors) {
            if (c.orientation === 'vertical' && dx > tol) continue;
            if (c.orientation === 'horizontal' && dy > tol) continue;
            if (mx < c.minX || mx > c.maxX || my < c.minY || my > c.maxY) continue;
            return c;
        }
        return null;
    }

    resolveReachableAccessPoint(rawPoint, manzana) {
        if (!rawPoint || !manzana || !BarrioData.manzanasPosiciones[manzana]) return rawPoint;
        const candidates = this.buildManzanaAccessCandidates(manzana, rawPoint);

        let best = rawPoint;
        let bestDist = Number.POSITIVE_INFINITY;
        for (const candidate of candidates) {
            if (!candidate || this.isPointBlocked(candidate, 0.4)) continue;
            const projection = this.findNearestEdgeProjection(candidate);
            if (!projection) continue;
            if (!this.isSegmentWalkable(candidate, projection.point)) continue;
            if (projection.distance < bestDist) {
                bestDist = projection.distance;
                best = candidate;
            }
        }

        return best;
    }

    buildManzanaAccessCandidates(manzana, basePoint) {
        const pos = BarrioData.manzanasPosiciones[manzana];
        if (!pos) return [basePoint];

        const w = pos.w || 19.42;
        const h = pos.h || 35.33;
        const west = { x: pos.l - 3, y: pos.t + h / 2 };
        const east = { x: pos.l + w + 3, y: pos.t + h / 2 };
        const north = { x: pos.l + w / 2, y: pos.t - 3 };
        const south = { x: pos.l + w / 2, y: pos.t + h + 3 };

        const preferWest = this.manzanasDerechaVerde.includes(Number(manzana));
        return preferWest
            ? [west, south, north, east, basePoint]
            : [basePoint, east, west, north, south];
    }

    describeDisconnection(point) {
        const projection = this.findNearestEdgeProjection(point);
        if (!projection) {
            return { reason: 'sin proyeccion a la red', point };
        }

        const crossing = this.getFirstCrossedObstacle(point, projection.point);
        if (crossing) {
            return {
                reason: 'bloqueo por obstaculo al conectar al grafo',
                point,
                snap: projection.point,
                obstacleId: crossing.id
            };
        }

        return {
            reason: 'sin camino A* entre nodos conectados',
            point,
            snap: projection.point
        };
    }

    routeAroundSameManzana(manzana, start, end) {
        const pos = BarrioData.manzanasPosiciones[manzana];
        if (!pos || !start || !end) return [];
        if (this.isSegmentWalkable(start, end)) return [start, end];

        const w = pos.w || 19.42;
        const h = pos.h || 35.33;
        const margin = 3.4;
        const nodes = [
            { id: 'S', x: start.x, y: start.y },
            { id: 'E', x: end.x, y: end.y },
            { id: 'NW', x: pos.l - margin, y: pos.t - margin },
            { id: 'NE', x: pos.l + w + margin, y: pos.t - margin },
            { id: 'SE', x: pos.l + w + margin, y: pos.t + h + margin },
            { id: 'SW', x: pos.l - margin, y: pos.t + h + margin }
        ];

        const adj = new Map(nodes.map((n) => [n.id, []]));
        for (let i = 0; i < nodes.length; i++) {
            for (let j = i + 1; j < nodes.length; j++) {
                const a = nodes[i];
                const b = nodes[j];
                if (!this.isSegmentWalkable(a, b, 0.15)) continue;
                const wgt = this.distance(a, b);
                adj.get(a.id).push({ to: b.id, w: wgt });
                adj.get(b.id).push({ to: a.id, w: wgt });
            }
        }

        const pathIds = this.dijkstraLocal(adj, 'S', 'E');
        if (!pathIds.length) return [];
        return pathIds.map((id) => {
            const n = nodes.find((x) => x.id === id);
            return { x: n.x, y: n.y };
        });
    }

    dijkstraLocal(adj, startId, endId) {
        const dist = new Map();
        const prev = new Map();
        const q = new Set(adj.keys());

        for (const id of q) dist.set(id, Number.POSITIVE_INFINITY);
        dist.set(startId, 0);

        while (q.size) {
            let u = null;
            let best = Number.POSITIVE_INFINITY;
            for (const id of q) {
                const d = dist.get(id);
                if (d < best) {
                    best = d;
                    u = id;
                }
            }
            if (u === null || u === endId) break;
            q.delete(u);

            for (const edge of adj.get(u) || []) {
                if (!q.has(edge.to)) continue;
                const alt = dist.get(u) + edge.w;
                if (alt < dist.get(edge.to)) {
                    dist.set(edge.to, alt);
                    prev.set(edge.to, u);
                }
            }
        }

        if (!Number.isFinite(dist.get(endId))) return [];
        const path = [endId];
        let cur = endId;
        while (prev.has(cur)) {
            cur = prev.get(cur);
            path.unshift(cur);
        }
        return path[0] === startId ? path : [];
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

    addDirectedEdge(graph, idA, idB) {
        if (idA === idB) return;
        const a = graph.nodes.get(idA);
        const b = graph.nodes.get(idB);
        if (!a || !b) return;

        const w = this.distance(a, b);
        const arrA = graph.adjacency.get(idA) || [];
        if (!graph.adjacency.has(idA)) graph.adjacency.set(idA, arrA);
        if (!arrA.some((e) => e.to === idB)) arrA.push({ to: idB, weight: w });

        const keyA = `${idA}->${idB}`;
        if (!graph.edges.some((e) => e.key === keyA)) {
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
