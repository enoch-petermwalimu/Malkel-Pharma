<?php ob_start(); ?>

<div class="hero-v2">

    <div>

        <span class="hero-tag">
            Business Intelligence Center
        </span>

        <h1>
            MALKEL PHARMA
        </h1>

        <p>
            Real-time analytics, sales monitoring and pharmacy performance.
        </p>

    </div>

    <div class="hero-actions">

        <a href="/pos" class="action-btn">
            New Sale
        </a>

        <a href="/products/create" class="action-btn secondary">
            Add Product
        </a>

    </div>

</div>

<!-- FILTERS -->

<div class="filter-bar">

    <input type="date">

    <input type="date">

    <button class="filter-btn">
        Apply Filter
    </button>

</div>

<!-- REVENUE -->

<div class="dashboard-grid">

    <div class="metric-card">

        <span>Revenue Today</span>

        <h2>
            $
            <?= number_format($todayRevenue ?? 0, 2) ?>
        </h2>

    </div>

    <div class="metric-card">

        <span>Revenue 3 Days</span>

        <h2>
            $
            <?= number_format($revenue3Days ?? 0, 2) ?>
        </h2>

    </div>

    <div class="metric-card">

        <span>Revenue 7 Days</span>

        <h2>
            $
            <?= number_format($revenue7Days ?? 0, 2) ?>
        </h2>

    </div>

    <div class="metric-card">

        <span>Revenue 30 Days</span>

        <h2>
            $
            <?= number_format($revenue30Days ?? 0, 2) ?>
        </h2>

        </div>

        <a href="/sales/history?period=today"
            class="metric-link">
            View Sales →
        </a>

</div>

<!-- STATS -->

<div class="dashboard-grid">

    <div class="metric-card">

        <span>Sales Today</span>

        <h2>
            <?= $salesToday ?? 0 ?>
        </h2>

    </div>

    <div class="metric-card">

        <span>Customers</span>

        <h2>
            <?= $customersCount ?? 0 ?>
        </h2>

    </div>

    <div class="metric-card">

        <span>Products</span>

        <h2>
            <?= $productsCount ?? 0 ?>
        </h2>

    </div>

    <div class="metric-card">

        <span>Users</span>

        <h2>
            <?= $usersCount ?? 0 ?>
        </h2>

    </div>

</div>

<!-- CHART -->

<div class="panel-card chart-card">

    <div class="panel-title">
        Revenue Analytics
    </div>

    <canvas id="salesChart"></canvas>

</div>

<!-- SECOND ROW -->

<div class="dashboard-two-cols">

    <!-- TOP PRODUCTS -->

    <div class="panel-card">

        <div class="panel-title">
            Top Products
        </div>

        <?php if (!empty($topProducts)): ?>

            <?php foreach ($topProducts as $product): ?>

                <div class="product-row">

                    <span>
                        <?= htmlspecialchars($product['name']) ?>
                    </span>

                    <strong>
                        <?= $product['sold_qty'] ?>
                    </strong>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <p class="empty-state">
                No products sold yet.
            </p>

        <?php endif; ?>

    </div>

    <!-- LOW STOCK -->

    <div class="panel-card">

        <div class="panel-title">
            Low Stock Products
        </div>

        <?php if (!empty($lowStock)): ?>

            <?php foreach ($lowStock as $item): ?>

                <div class="product-row">

                    <span>
                        <?= htmlspecialchars($item['name']) ?>
                    </span>

                    <strong style="color:#ef4444;">
                        <?= $item['total_stock'] ?>
                    </strong>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <p class="empty-state">
                No critical stock.
            </p>

        <?php endif; ?>

    </div>

</div>

<!-- THIRD ROW -->

<div class="dashboard-two-cols">

    <!-- EXPIRING -->

    <div class="panel-card">

        <div class="panel-title">
            Expiring Soon
        </div>

        <?php if (!empty($expiringSoon)): ?>

            <?php foreach ($expiringSoon as $batch): ?>

                <div class="product-row">

                    <span>
                        Batch #
                        <?= htmlspecialchars($batch['batch_number'] ?? '-') ?>
                    </span>

                    <strong>
                        <?= htmlspecialchars($batch['expiry_date']) ?>
                    </strong>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <p class="empty-state">
                No upcoming expirations.
            </p>

        <?php endif; ?>

    </div>

    <!-- ACTIVITY -->

    <div class="panel-card">

        <div class="panel-title">
            Recent Activity
        </div>

        <div class="activity-item">
            Sale registered
        </div>

        <div class="activity-item">
            Product added
        </div>

        <div class="activity-item">
            Stock updated
        </div>

        <div class="activity-item">
            Customer created
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx =
document.getElementById('salesChart');

new Chart(ctx, {

    type:'line',

    data:{

        labels:[
            'Mon',
            'Tue',
            'Wed',
            'Thu',
            'Fri',
            'Sat',
            'Sun'
        ],

        datasets:[{

            label:'Sales',

            data:[
                12,
                19,
                8,
                15,
                22,
                17,
                30
            ],

            borderColor:'#3b82f6',

            tension:.4,

            fill:false
        }]
    },

    options:{

        responsive:true,

        plugins:{
            legend:{
                labels:{
                    color:'#cbd5e1'
                }
            }
        },

        scales:{

            y:{
                ticks:{
                    color:'#94a3b8'
                }
            },

            x:{
                ticks:{
                    color:'#94a3b8'
                }
            }
        }
    }
});

</script>

<?php

$content = ob_get_clean();

$pageTitle = 'Dashboard';

include dirname(__DIR__) . '/layouts/app.php';
