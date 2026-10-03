/**
 * Lira Trading Chart – v3.1
 * Targets: #tradeChart (chart), #tradeDrawLayer (canvas), #tradeChartStage (resize observer)
 * Safe to call at any point after the DOM element exists.
 */
(function initLiraChart() {
    // If DOM not ready yet, retry
    const chartContainer = document.getElementById('tradeChart');
    const stage          = document.getElementById('tradeChartStage');
    const drawCanvas     = document.getElementById('tradeDrawLayer');

    if (!chartContainer || !stage) {
        // Elements not in DOM yet – wait and retry
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initLiraChart);
        } else {
            setTimeout(initLiraChart, 50);
        }
        return;
    }

    if (typeof LightweightCharts === 'undefined') {
        setTimeout(initLiraChart, 100);
        return;
    }

    const ctx = drawCanvas ? drawCanvas.getContext('2d') : null;

    // UI refs
    const priceEl        = document.getElementById('goldSpotPrice');
    const hoveredPriceEl = document.getElementById('goldHoveredPrice');
    const hoveredTimeEl  = document.getElementById('goldHoveredTime');
    const rangeEl        = document.getElementById('goldRangeText');

    // ─── Create chart ────────────────────────────────────────────────────────
    const chart = LightweightCharts.createChart(chartContainer, {
        width:  stage.clientWidth  || window.innerWidth,
        height: stage.clientHeight || 510,
        layout: {
            background: { type: 'solid', color: 'transparent' },
            textColor: '#8b92a5',
        },
        grid: {
            vertLines: { color: 'rgba(255,255,255,0.04)' },
            horzLines: { color: 'rgba(255,255,255,0.04)' },
        },
        crosshair: {
            mode: LightweightCharts.CrosshairMode.Normal,
            vertLine: { color: 'rgba(212,175,55,0.3)', labelBackgroundColor: '#161b23' },
            horzLine: { color: 'rgba(212,175,55,0.3)', labelBackgroundColor: '#161b23' },
        },
        timeScale: {
            borderColor: 'rgba(255,255,255,0.08)',
            timeVisible: true,
            secondsVisible: false,
        },
        rightPriceScale: { borderColor: 'rgba(255,255,255,0.08)' },
    });

    const mainSeries = chart.addCandlestickSeries({
        upColor:      '#2ed573',
        downColor:    '#ff4757',
        borderVisible: false,
        wickUpColor:   '#2ed573',
        wickDownColor: '#ff4757',
    });

    // ─── Sync size to stage ──────────────────────────────────────────────────
    function syncSize() {
        const w = stage.clientWidth;
        const h = stage.clientHeight;
        if (!w || !h) return;
        chart.applyOptions({ width: w, height: h });
        if (drawCanvas) {
            drawCanvas.width  = w;
            drawCanvas.height = h;
            requestOverlayDraw();
        }
    }

    // Run right away, then observe
    syncSize();
    setTimeout(syncSize, 100);
    new ResizeObserver(syncSize).observe(stage);
    window.addEventListener('resize', syncSize);

    // ─── Mock BTC candle data ────────────────────────────────────────────────
    const now = Math.floor(Date.now() / 1000);
    const mockData = [];
    let lastClose = 67000;

    for (let i = -120; i <= 0; i++) {
        const time  = now + i * 300;
        const wave  = Math.sin(i / 7) * 120;
        const noise = (Math.random() - 0.5) * 80;
        const open  = lastClose;
        const close = open + wave + noise;
        const high  = Math.max(open, close) + Math.random() * 60;
        const low   = Math.min(open, close) - Math.random() * 60;
        lastClose   = close;
        mockData.push({
            time,
            open:  +open.toFixed(2),
            high:  +high.toFixed(2),
            low:   +low.toFixed(2),
            close: +close.toFixed(2),
        });
    }

    mainSeries.setData(mockData);
    chart.timeScale().fitContent();

    // Set initial price
    const firstPrice = mockData[mockData.length - 1].close;
    if (priceEl)        priceEl.textContent        = firstPrice.toFixed(2);
    if (hoveredPriceEl) hoveredPriceEl.textContent = firstPrice.toFixed(2);

    // ─── Live tick ───────────────────────────────────────────────────────────
    setInterval(() => {
        const dt     = Math.floor(Date.now() / 1000);
        const candle = mockData[mockData.length - 1];
        const change = (Math.random() - 0.48) * 40;

        if (dt - candle.time >= 300) {
            const newC = {
                time:  dt,
                open:  candle.close,
                high:  candle.close + Math.random() * 50,
                low:   candle.close - Math.random() * 50,
                close: candle.close + change,
            };
            mockData.push(newC);
            mainSeries.update(newC);
        } else {
            candle.close = candle.close + change;
            candle.high  = Math.max(candle.high,  candle.close);
            candle.low   = Math.min(candle.low,   candle.close);
            mainSeries.update(candle);
        }

        if (priceEl) priceEl.textContent = candle.close.toFixed(2);
        requestOverlayDraw();
    }, 1000);

    // ─── Crosshair ───────────────────────────────────────────────────────────
    chart.subscribeCrosshairMove(param => {
        if (param.point && param.time) {
            const price = mainSeries.coordinateToPrice(param.point.y);
            if (hoveredPriceEl && price) hoveredPriceEl.textContent = price.toFixed(2);
            if (hoveredTimeEl && param.time) {
                const d  = new Date(param.time * 1000);
                const hh = String(d.getHours()).padStart(2, '0');
                const mm = String(d.getMinutes()).padStart(2, '0');
                hoveredTimeEl.textContent = `${hh}:${mm}`;
            }
        }
    });

    chart.timeScale().subscribeVisibleTimeRangeChange(range => {
        if (range && rangeEl) {
            const fmt = t => {
                const d = new Date(t * 1000);
                return `${String(d.getHours()).padStart(2,'0')}:${String(d.getMinutes()).padStart(2,'0')}`;
            };
            rangeEl.textContent = `${fmt(range.from)} – ${fmt(range.to)}`;
        }
        requestOverlayDraw();
    });

    // ─── Drawing system ───────────────────────────────────────────────────────
    const drawings = [];
    let drawMode = 'cursor';
    let draggingPoint = null;

    const toolbarBtns = document.querySelectorAll('.lira-draw-item[data-tool]');

    toolbarBtns.forEach(btn => {
        btn.addEventListener('click', e => {
            e.stopPropagation();
            toolbarBtns.forEach(b => b.classList.remove('is-active'));
            btn.classList.add('is-active');
            drawMode = btn.dataset.tool;
            const lbl = document.getElementById('activeToolLabel');
            if (lbl) lbl.textContent = btn.innerText.trim();
            if (drawCanvas) drawCanvas.style.cursor = drawMode === 'cursor' ? 'default' : 'crosshair';
            document.getElementById('drawMenu')?.classList.remove('show');
        });
    });

    document.querySelectorAll('.lira-draw-item[data-action="clear"]').forEach(btn => {
        btn.addEventListener('click', e => {
            e.stopPropagation();
            drawings.length = 0;
            requestOverlayDraw();
            document.getElementById('drawMenu')?.classList.remove('show');
        });
    });

    document.querySelectorAll('.lira-draw-item[data-action="follow-live"]').forEach(btn => {
        btn.addEventListener('click', e => {
            e.stopPropagation();
            chart.timeScale().scrollToRealTime();
            document.getElementById('drawMenu')?.classList.remove('show');
        });
    });

    // ─── Canvas overlay rendering ─────────────────────────────────────────────
    function getCanvasPos(t, price) {
        const x = chart.timeScale().timeToCoordinate(t);
        const y = mainSeries.priceToCoordinate(price);
        if (x === null || y === null) return null;
        return { x, y };
    }

    function drawHandle(x, y, color = '#2ed573') {
        ctx.beginPath();
        ctx.arc(x, y, 5, 0, 2 * Math.PI);
        ctx.fillStyle = color;
        ctx.fill();
        ctx.strokeStyle = '#000';
        ctx.lineWidth = 1.5;
        ctx.stroke();
    }

    function requestOverlayDraw() {
        if (!ctx || !drawCanvas) return;
        ctx.clearRect(0, 0, drawCanvas.width, drawCanvas.height);

        drawings.forEach(d => {
            if (d.type === 'trend') {
                const p1 = getCanvasPos(d.time1, d.price1);
                const p2 = getCanvasPos(d.time2, d.price2);
                if (p1 && p2) {
                    ctx.beginPath(); ctx.moveTo(p1.x, p1.y); ctx.lineTo(p2.x, p2.y);
                    ctx.strokeStyle = '#2ed573'; ctx.lineWidth = 1.5; ctx.stroke();
                    drawHandle(p1.x, p1.y, '#2ed573');
                    drawHandle(p2.x, p2.y, '#2ed573');
                }
            } else if (d.type === 'rect') {
                const p1 = getCanvasPos(d.time1, d.price1);
                const p2 = getCanvasPos(d.time2, d.price2);
                if (p1 && p2) {
                    const x = Math.min(p1.x, p2.x), y = Math.min(p1.y, p2.y);
                    const w = Math.abs(p2.x - p1.x), h = Math.abs(p2.y - p1.y);
                    ctx.fillStyle = 'rgba(212,175,55,0.1)'; ctx.fillRect(x, y, w, h);
                    ctx.strokeStyle = 'rgba(212,175,55,0.6)'; ctx.lineWidth = 1; ctx.strokeRect(x, y, w, h);
                    drawHandle(p1.x, p1.y, '#d4af37'); drawHandle(p2.x, p2.y, '#d4af37');
                }
            } else if (d.type === 'hline') {
                const p1 = getCanvasPos(d.time1, d.price1);
                if (p1) {
                    ctx.beginPath(); ctx.moveTo(0, p1.y); ctx.lineTo(drawCanvas.width, p1.y);
                    ctx.strokeStyle = 'rgba(255,255,255,0.5)'; ctx.lineWidth = 1; ctx.setLineDash([6, 4]); ctx.stroke(); ctx.setLineDash([]);
                    drawHandle(drawCanvas.width / 2, p1.y);
                }
            } else if (d.type === 'vline') {
                const p1 = getCanvasPos(d.time1, d.price1);
                if (p1) {
                    ctx.beginPath(); ctx.moveTo(p1.x, 0); ctx.lineTo(p1.x, drawCanvas.height);
                    ctx.strokeStyle = 'rgba(255,255,255,0.5)'; ctx.lineWidth = 1; ctx.setLineDash([6, 4]); ctx.stroke(); ctx.setLineDash([]);
                    drawHandle(p1.x, drawCanvas.height / 2);
                }
            }
        });
    }

    // ─── Mouse events on draw canvas ─────────────────────────────────────────
    if (drawCanvas) {
        drawCanvas.addEventListener('mousedown', e => {
            const rect  = drawCanvas.getBoundingClientRect();
            const x     = e.clientX - rect.left;
            const y     = e.clientY - rect.top;

            if (drawMode === 'cursor') {
                draggingPoint = null;
                for (let i = drawings.length - 1; i >= 0; i--) {
                    const d  = drawings[i];
                    const p1 = getCanvasPos(d.time1, d.price1);
                    if (p1 && dist(x, y, p1.x, p1.y) < 12) { draggingPoint = { drawing: d, point: 1 }; break; }
                    if (d.time2) {
                        const p2 = getCanvasPos(d.time2, d.price2);
                        if (p2 && dist(x, y, p2.x, p2.y) < 12) { draggingPoint = { drawing: d, point: 2 }; break; }
                    }
                }
                return;
            }

            // Instant placement
            const price = mainSeries.coordinateToPrice(y);
            const time  = chart.timeScale().coordinateToTime(x);
            if (!price || !time) return;

            if      (drawMode === 'trend') drawings.push({ type: 'trend', time1: time, price1: price, time2: time + 300 * 8, price2: price + 200 });
            else if (drawMode === 'rect')  drawings.push({ type: 'rect',  time1: time, price1: price, time2: time + 300 * 8, price2: price - 300 });
            else if (drawMode === 'hline') drawings.push({ type: 'hline', time1: time, price1: price });
            else if (drawMode === 'vline') drawings.push({ type: 'vline', time1: time, price1: price });

            // Auto-revert to cursor
            drawMode = 'cursor';
            drawCanvas.style.cursor = 'default';
            toolbarBtns.forEach(b => {
                b.classList.remove('is-active');
                if (b.dataset.tool === 'cursor') b.classList.add('is-active');
            });
            const lbl = document.getElementById('activeToolLabel');
            if (lbl) lbl.textContent = 'Cursor';
            requestOverlayDraw();
        });

        drawCanvas.addEventListener('mousemove', e => {
            if (!draggingPoint) return;
            const rect  = drawCanvas.getBoundingClientRect();
            const price = mainSeries.coordinateToPrice(e.clientY - rect.top);
            const time  = chart.timeScale().coordinateToTime(e.clientX - rect.left);
            if (!price || !time) return;
            if (draggingPoint.point === 1) { draggingPoint.drawing.time1 = time; draggingPoint.drawing.price1 = price; }
            else                           { draggingPoint.drawing.time2 = time; draggingPoint.drawing.price2 = price; }
            requestOverlayDraw();
        });

        drawCanvas.addEventListener('mouseup',    () => { draggingPoint = null; });
        drawCanvas.addEventListener('mouseleave', () => { draggingPoint = null; });
    }

    function dist(x1, y1, x2, y2) { return Math.sqrt((x2 - x1) ** 2 + (y2 - y1) ** 2); }
})();
