// =============================================
// TABLE SORTING FUNCTIONALITY
// =============================================

const NUMERIC_COLUMNS = ['id', 'price', 'quantity', 'total_value', 'quantity_sold', 'unit_price', 'total_amount'];
const DATE_COLUMNS = ['created_date', 'sale_date'];

function makeTableSortable(tableId) {
    const table = document.getElementById(tableId);
    if (!table) return;
    // Never attach the click handlers twice to the same table.
    if (table.dataset.sortReady === '1') return;
    table.dataset.sortReady = '1';
    
    const headers = table.querySelectorAll('th.sortable');
    const tbody = table.querySelector('tbody');
    let currentSort = { column: null, direction: 'asc' };

    headers.forEach(header => {
        header.addEventListener('click', () => {
            const column = header.getAttribute('data-sort');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            
            // Determine sort direction
            if (currentSort.column === column) {
                currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort.column = column;
                currentSort.direction = 'asc';
            }

            // Remove sort indicators from all headers
            headers.forEach(h => {
                h.classList.remove('sort-asc', 'sort-desc');
                const indicator = h.querySelector('.sort-indicator');
                if (indicator) indicator.textContent = '↕';
            });

            // Add sort indicator to current header
            header.classList.add(currentSort.direction === 'asc' ? 'sort-asc' : 'sort-desc');
            const indicator = header.querySelector('.sort-indicator');
            if (indicator) indicator.textContent = currentSort.direction === 'asc' ? '↑' : '↓';

            // Sort the rows
            rows.sort((a, b) => {
                const headerIndex = Array.from(headers).indexOf(header) + 1;
                const aCell = a.querySelector(`td:nth-child(${headerIndex})`);
                const bCell = b.querySelector(`td:nth-child(${headerIndex})`);
                
                if (!aCell || !bCell) return 0;
                
                let aValue = aCell.textContent.trim();
                let bValue = bCell.textContent.trim();

                // Handle numeric values (currency symbols and thousands separators are stripped)
                if (NUMERIC_COLUMNS.includes(column)) {
                    aValue = parseFloat(aValue.replace(/[\u20B1$,]/g, '')) || 0;
                    bValue = parseFloat(bValue.replace(/[\u20B1$,]/g, '')) || 0;
                }
                // Handle date values
                else if (DATE_COLUMNS.includes(column)) {
                    aValue = new Date(aValue);
                    bValue = new Date(bValue);
                }

                if (aValue < bValue) return currentSort.direction === 'asc' ? -1 : 1;
                if (aValue > bValue) return currentSort.direction === 'asc' ? 1 : -1;
                return 0;
            });

            // Reappend sorted rows
            rows.forEach(row => tbody.appendChild(row));
        });
    });
}

// =============================================
// CHART INITIALIZATION FUNCTIONS
// Colours/fonts come from chart-theme.js (window.StockwiseChart).
// Charts are always created through StockwiseChart.create(), which destroys a
// chart that is already attached to the canvas, so a repeated initialisation can
// no longer throw "Canvas is already in use".
// =============================================

function initializeDashboardCharts() {
    // Daily Sales Chart from dashboard
    const dailySalesCtx = document.getElementById('dailySalesChart');
    if (dailySalesCtx && window.StockwiseChart) {
        const dailySalesData = JSON.parse(dailySalesCtx.getAttribute('data-sales') || '{}');
        const labels = Object.keys(dailySalesData).map(day => `${day}`);
        const data = Object.values(dailySalesData);

        StockwiseChart.create(dailySalesCtx, {
            type: 'bar',
            data: { labels: labels, datasets: [StockwiseChart.barDataset('Sales (₱)', data)] },
            options: StockwiseChart.barOptions({ currency: true })
        });
    }
}

function initializeReportsCharts() {
    if (!window.StockwiseChart) return;

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx) {
        const categoryLabels = JSON.parse(categoryCtx.getAttribute('data-labels') || '[]');
        const categoryData = JSON.parse(categoryCtx.getAttribute('data-values') || '[]');

        StockwiseChart.create(categoryCtx, {
            type: 'bar',
            data: { labels: categoryLabels, datasets: [StockwiseChart.barDataset('Number of Products', categoryData)] },
            options: StockwiseChart.barOptions()
        });
    }

    // Price Range Chart
    const priceRangeCtx = document.getElementById('priceRangeChart');
    if (priceRangeCtx) {
        const priceRangeLabels = JSON.parse(priceRangeCtx.getAttribute('data-labels') || '[]');
        const priceRangeData = JSON.parse(priceRangeCtx.getAttribute('data-values') || '[]');

        StockwiseChart.create(priceRangeCtx, {
            type: 'bar',
            data: { labels: priceRangeLabels, datasets: [StockwiseChart.barDataset('Number of Products', priceRangeData)] },
            options: StockwiseChart.barOptions()
        });
    }

    // Monthly Sales Chart
    const monthlySalesCtx = document.getElementById('monthlySalesChart');
    if (monthlySalesCtx) {
        const monthlySalesData = JSON.parse(monthlySalesCtx.getAttribute('data-values') || '[]');

        StockwiseChart.create(monthlySalesCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [StockwiseChart.barDataset('Sales (₱)', monthlySalesData)]
            },
            options: StockwiseChart.barOptions({ currency: true })
        });
    }
}

// =============================================
// SALES PAGE INITIALIZATION
// =============================================

function initializeSalesPage() {
    // Initialize sales table sorting
    makeTableSortable('salesTable');
}

// =============================================
// PAGE INITIALIZATION
// One handler only. (The file used to register two DOMContentLoaded handlers that
// both initialised the reports charts, which caused "Canvas is already in use".)
// =============================================

document.addEventListener('DOMContentLoaded', function() {
    // Initialize table sorting (each call is a no-op when the table is absent or already initialised)
    makeTableSortable('productsTable');
    makeTableSortable('salesTable');

    // Initialize charts based on page
    if (document.getElementById('dailySalesChart')) {
        initializeDashboardCharts();
    }

    if (document.getElementById('categoryChart')) {
        initializeReportsCharts();
    }

    // Initialize sales page if needed
    if (document.getElementById('salesTable')) {
        initializeSalesPage();
    }
});
