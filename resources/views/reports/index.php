<?php ob_start(); ?>

<div class="hero-v2">

    <div>

        <span class="hero-tag">
            Financial Analytics
        </span>

        <h1>
            Financial Statistics
        </h1>

        <p>
            Revenue, sales performance and financial overview.
        </p>

    </div>

</div>

<!-- REVENUE METRICS -->

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

</div>

<!-- SALES METRICS -->

<div class="dashboard-grid">

    <div class="metric-card">

        <span>Sales Today</span>

        <h2>
            <?= $salesToday ?? 0 ?>
        </h2>

    </div>

    <div class="metric-card">

        <span>Total Sales</span>

        <h2>
            <?= $totalSalesCount ?? 0 ?>
        </h2>

    </div>

    <div class="metric-card">

        <span>Total Revenue</span>

        <h2>
            $
            <?= number_format($totalRevenue ?? 0, 2) ?>
        </h2>

    </div>

    <div class="metric-card">

        <span>Total Purchases</span>

        <h2>
            $
            <?= number_format($purchaseTotal ?? 0, 2) ?>
        </h2>

    </div>

</div>

<!-- TOP PRODUCTS -->

<div class="panel-card">

    <div class="panel-title">
        Top Selling Products
    </div>

    <?php if (!empty($topProducts)): ?>

        <?php foreach ($topProducts as $product): ?>

            <div class="product-row">

                <span>
                    <?= htmlspecialchars($product['name']) ?>
                </span>

                <strong>
                    <?= $product['sold_qty'] ?> sold
                </strong>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <p class="empty-state">
            No products sold yet.
        </p>

    <?php endif; ?>

</div>

<!-- LATEST SALES -->

<div class="panel-card">

    <div class="panel-title">
        Latest Sales
    </div>

    <?php if (!empty($latestSales)): ?>

        <div class="table-wrapper">

            <table class="malkel-table">

                <thead>

                    <tr>

                        <th>Invoice</th>

                        <th>Customer</th>

                        <th>Total</th>

                        <th>Date</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($latestSales as $sale): ?>

                        <tr>

                            <td>

                                <?= htmlspecialchars(
                                    $sale['invoice_number']
                                ) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $sale['customer_name']
                                    ?? '-'
                                ) ?>

                            </td>

                            <td>

                                $

                                <?= number_format(
                                    (float) ($sale['total'] ?? 0),
                                    2
                                ) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $sale['created_at']
                                ) ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php else: ?>

        <p class="empty-state">
            No sales recorded yet.
        </p>

    <?php endif; ?>

</div>

<?php

$content = ob_get_clean();

$pageTitle = 'Financial Statistics';

include dirname(__DIR__) . '/layouts/app.php';
