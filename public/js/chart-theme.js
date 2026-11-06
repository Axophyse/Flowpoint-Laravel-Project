/* ==========================================================================
   Stockwise Chart.js theme (presentation only).
   Load AFTER Chart.js and BEFORE any script that creates a chart.
   Exposes window.StockwiseChart with shared colours, a peso formatter and a
   safe chart factory that never throws "Canvas is already in use".
   ========================================================================== */
(function () {
    'use strict';
    if (!window.Chart) { return; }

    var BRAND = '#166534';
    var TEXT = '#1F2937';
    var MUTED = '#4B5563';
    var GRID = '#E5E7EB';

    // Categorical order (validated for colour-blind separation): forest, amber, blue, crimson, violet, ochre.
    // Beyond six categories the remaining slices fall back to neutral greys rather than cycling hues.
    var CATEGORICAL = ['#166534', '#D97706', '#2563EB', '#BE123C', '#7C3AED', '#A16207'];
    var NEUTRALS = ['#6B7280', '#9CA3AF', '#D1D5DB'];

    Chart.defaults.responsive = true;
    Chart.defaults.maintainAspectRatio = false;   // charts fill their .chart-frame container
    Chart.defaults.font.family = 'system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
    Chart.defaults.font.size = 12;
    Chart.defaults.color = MUTED;
    Chart.defaults.borderColor = GRID;
    Chart.defaults.plugins.legend.labels.usePointStyle = true;
    Chart.defaults.plugins.legend.labels.boxWidth = 8;
    Chart.defaults.plugins.legend.labels.boxHeight = 8;
    Chart.defaults.plugins.legend.labels.padding = 16;
    Chart.defaults.plugins.tooltip.backgroundColor = TEXT;
    Chart.defaults.plugins.tooltip.titleColor = '#FFFFFF';
    Chart.defaults.plugins.tooltip.bodyColor = '#FFFFFF';
    Chart.defaults.plugins.tooltip.padding = 10;
    Chart.defaults.plugins.tooltip.cornerRadius = 8;
    Chart.defaults.elements.bar.borderRadius = 4;
    Chart.defaults.elements.bar.borderSkipped = 'bottom';

    function peso(value, decimals) {
        var n = Number(value) || 0;
        return '₱' + n.toLocaleString('en-US', {
            minimumFractionDigits: decimals || 0,
            maximumFractionDigits: decimals === undefined ? 2 : decimals
        });
    }

    function categorical(count) {
        var out = [];
        for (var i = 0; i < count; i++) {
            out.push(i < CATEGORICAL.length ? CATEGORICAL[i] : NEUTRALS[Math.min(i - CATEGORICAL.length, NEUTRALS.length - 1)]);
        }
        return out;
    }

    // Shared options for single-series bar charts (one brand colour, light horizontal grid only).
    function barOptions(opts) {
        opts = opts || {};
        var yTicks = { precision: 0 };
        if (opts.currency) { yTicks = { callback: function (v) { return peso(v); } }; }
        return {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { grid: { display: false }, ticks: { color: MUTED, maxRotation: 0, autoSkip: true } },
                y: { beginAtZero: true, grid: { color: GRID }, border: { display: false }, ticks: yTicks }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: opts.currency ? {
                        label: function (ctx) { return ' ' + (ctx.dataset.label || '') + ': ' + peso(ctx.parsed.y, 2); }
                    } : {}
                }
            }
        };
    }

    function barDataset(label, data) {
        return { label: label, data: data, backgroundColor: BRAND, hoverBackgroundColor: '#14532D', borderWidth: 0, maxBarThickness: 44 };
    }

    // Create a chart, destroying any chart already attached to the canvas first.
    function create(canvas, config) {
        if (typeof canvas === 'string') { canvas = document.getElementById(canvas); }
        if (!canvas) { return null; }
        var existing = Chart.getChart(canvas);
        if (existing) { existing.destroy(); }
        return new Chart(canvas, config);
    }

    window.StockwiseChart = {
        brand: BRAND, text: TEXT, muted: MUTED, grid: GRID,
        peso: peso, categorical: categorical,
        barOptions: barOptions, barDataset: barDataset, create: create
    };
})();
