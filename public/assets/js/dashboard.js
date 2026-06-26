/**
 * Dashboard charts
 */

document.addEventListener('DOMContentLoaded', () => {
    const canvas =
        document.getElementById('salesChart');

    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: topProductsLabels,
            datasets: [{
                label: 'Units Sold',
                data: topProductsData
            }]
        }
    });
});