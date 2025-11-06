// =============================================
// TABLE SORTING FUNCTIONALITY
// =============================================

function makeTableSortable(tableId) {
    const table = document.getElementById(tableId);
    if (!table) return;
    
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

                // Handle numeric values
                if (column === 'id' || column === 'price' || column === 'quantity' || column === 'total_value') {
                    aValue = parseFloat(aValue.replace(/[$,]/g, '')) || 0;
                    bValue = parseFloat(bValue.replace(/[$,]/g, '')) || 0;
                }
                // Handle date values
                else if (column === 'created_date') {
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
// =============================================

function initializeDashboardCharts() {
    // Daily Sales Chart from dashboard
    const dailySalesCtx = document.getElementById('dailySalesChart');
    if (dailySalesCtx) {
        const dailySalesData = JSON.parse(dailySalesCtx.getAttribute('data-sales') || '{}');
        const labels = Object.keys(dailySalesData).map(day => `${day}`);
        const data = Object.values(dailySalesData);

        new Chart(dailySalesCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sales ($)',
                    data: data,
                    borderColor: '#00d1b2',
                    backgroundColor: 'rgba(0, 209, 178, 0.4)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.1)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#ffffff'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.1)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffffff'
                        }
                    },
                    title: {
                        color: '#ffffff'
                    }
                }
            }
        });
    }
}

function initializeReportsCharts() {
    // Category Chart
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx) {
        const categoryLabels = JSON.parse(categoryCtx.getAttribute('data-labels') || '[]');
        const categoryData = JSON.parse(categoryCtx.getAttribute('data-values') || '[]');
        
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Number of Products',
                    data: categoryData,
                    borderColor: '#00d1b2',
                    backgroundColor: 'rgba(0, 209, 178, 0.4)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.1)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#ffffff'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.1)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffffff'
                        }
                    }
                }
            }
        });
    }

    // Price Range Chart
    const priceRangeCtx = document.getElementById('priceRangeChart');
    if (priceRangeCtx) {
        const priceRangeLabels = JSON.parse(priceRangeCtx.getAttribute('data-labels') || '[]');
        const priceRangeData = JSON.parse(priceRangeCtx.getAttribute('data-values') || '[]');
        
        new Chart(priceRangeCtx, {
            type: 'bar',
            data: {
                labels: priceRangeLabels,
                datasets: [{
                    label: 'Number of Products',
                    data: priceRangeData,
                    borderColor: '#00d1b2',
                    backgroundColor: 'rgba(0, 209, 178, 0.4)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.1)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#ffffff'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.1)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffffff'
                        }
                    }
                }
            }
        });
    }

    // Monthly Sales Chart
    const monthlySalesCtx = document.getElementById('monthlySalesChart');
    if (monthlySalesCtx) {
        const monthlySalesData = JSON.parse(monthlySalesCtx.getAttribute('data-values') || '[]');
        
        new Chart(monthlySalesCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Sales ($)',
                    data: monthlySalesData,
                    borderColor: '#00d1b2',
                    backgroundColor: 'rgba(0, 209, 178, 0.4)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.1)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#ffffff'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.1)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffffff'
                        }
                    }
                }
            }
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

// Update the main DOMContentLoaded function in custom.js:
document.addEventListener('DOMContentLoaded', function() {
    // Initialize table sorting
    makeTableSortable('productsTable');
    makeTableSortable('salesTable'); // Add this line
    
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



// =============================================
// PAGE INITIALIZATION
// =============================================

document.addEventListener('DOMContentLoaded', function() {
    // Initialize table sorting
    makeTableSortable('productsTable');
    
    // Initialize charts based on page
    if (document.getElementById('dailySalesChart')) {
        initializeDashboardCharts();
    }
    
    if (document.getElementById('categoryChart')) {
        initializeReportsCharts();
    }
});