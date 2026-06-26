<?php ob_start(); ?>

<div class="hero-v2">

    <div>

        <span class="hero-tag">
            Transaction Details
        </span>

        <h1>
            Sale Details
        </h1>

        <p>
            Complete information about this transaction.
        </p>

    </div>

    <div class="hero-actions">

        <a
            href="/sales/pdf?id=<?= $sale['id'] ?>"
            target="_blank"
            class="btn-primary"
        >
            PDF Invoice
        </a>

        <a
            href="/sales/receipt?id=<?= $sale['id'] ?>"
            target="_blank"
            class="btn-secondary"
        >
            Receipt
        </a>

        <a
            href="/returns"
            class="btn-secondary"
        >
            Return
        </a>

    </div>

</div>

<!-- =====================================================
     SALE INFO
===================================================== -->

<div class="dashboard-two-cols">

    <div class="panel-card">

        <div class="panel-title">
            Sale Information
        </div>

        <div class="info-grid">

            <div class="info-item">

                <span class="info-label">
                    Invoice Number
                </span>

                <strong>
                    <?= htmlspecialchars(
                        $sale['invoice_number']
                    ) ?>
                </strong>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Date
                </span>

                <strong>

                    <?= date(
                        'd/m/Y H:i',
                        strtotime(
                            $sale['created_at']
                        )
                    ) ?>

                </strong>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Customer
                </span>

                <strong>

                    <?= htmlspecialchars(
                        $sale['customer_name']
                        ?? 'Walk-in Customer'
                    ) ?>

                </strong>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Payment Status
                </span>

                <strong>

                    <?= htmlspecialchars(
                        $sale['payment_status']
                        ?? 'Paid'
                    ) ?>

                </strong>

            </div>

        </div>

    </div>

    <div class="panel-card">

        <div class="panel-title">
            Financial Summary
        </div>

        <div class="invoice-summary">

            <div class="summary-card">

                <span>
                    Subtotal
                </span>

                <h3>

                    $

                    <?= number_format(
                        $sale['subtotal']
                        ?? $sale['total'],
                        2
                    ) ?>

                </h3>

            </div>

            <div class="summary-card">

                <span>
                    Discount
                </span>

                <h3>

                    $

                    <?= number_format(
                        $sale['discount']
                        ?? 0,
                        2
                    ) ?>

                </h3>

            </div>

            <div class="summary-card">

                <span>
                    Tax
                </span>

                <h3>

                    $

                    <?= number_format(
                        $sale['tax']
                        ?? 0,
                        2
                    ) ?>

                </h3>

            </div>

            <div class="summary-card">

                <span>
                    Total
                </span>

                <h2>

                    $

                    <?= number_format(
                        $sale['total'],
                        2
                    ) ?>

                </h2>

            </div>

        </div>

    </div>

</div>

<!-- =====================================================
     PRODUCTS
===================================================== -->

<div class="panel-card mt-2">

    <div class="panel-title">
        Products Sold
    </div>

    <div class="table-wrapper">

        <table class="malkel-table">

            <thead>

                <tr>

                    <th>
                        Product
                    </th>

                    <th>
                        Quantity
                    </th>

                    <th>
                        Unit Price
                    </th>

                    <th>
                        Total
                    </th>

                </tr>

            </thead>

            <tbody>

            <?php foreach ($items as $item): ?>

                <tr>

                    <td>

                        <?= htmlspecialchars(
                            $item['product_name']
                            ?? $item['name']
                            ?? '-'
                        ) ?>

                    </td>

                    <td>

                        <?= (int)
                            $item['quantity'] ?>

                    </td>

                    <td>

                        $

                        <?= number_format(
                            $item['unit_price'],
                            2
                        ) ?>

                    </td>

                    <td>

                        $

                        <?= number_format(
                            $item['total_price'],
                            2
                        ) ?>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php

$content =
    ob_get_clean();

$pageTitle =
    'Sale Details';

include dirname(__DIR__)
    . '/layouts/app.php';
