<?php ob_start(); ?>

<div class="hero-v2">

    <div>

        <span class="hero-tag">
            Return Details
        </span>

        <h1>
            Return #<?= htmlspecialchars($return['return_number'] ?? '-') ?>
        </h1>

        <p>
            Complete information about this return.
        </p>

    </div>

    <div class="hero-actions">

        <a
            href="/returns"
            class="btn-secondary"
        >
            Back to Returns
        </a>

    </div>

</div>

<div class="dashboard-two-cols">

    <div class="panel-card">

        <div class="panel-title">
            Return Information
        </div>

        <div class="info-grid">

            <div class="info-item">

                <span class="info-label">
                    Return Number
                </span>

                <strong>
                    <?= htmlspecialchars($return['return_number']) ?>
                </strong>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Invoice
                </span>

                <strong>
                    <?= htmlspecialchars($return['invoice_number'] ?? '-') ?>
                </strong>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Customer
                </span>

                <strong>
                    <?= htmlspecialchars($return['customer_name'] ?? '-') ?>
                </strong>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Status
                </span>

                <strong>
                    <?= htmlspecialchars($return['status'] ?? 'pending') ?>
                </strong>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Date
                </span>

                <strong>
                    <?= htmlspecialchars($return['created_at']) ?>
                </strong>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Reason
                </span>

                <strong>
                    <?= htmlspecialchars($return['reason'] ?? '-') ?>
                </strong>

            </div>

        </div>

    </div>

    <div class="panel-card">

        <div class="panel-title">
            Refund Summary
        </div>

        <div class="invoice-summary">

            <div class="summary-card">

                <span>
                    Total Refund
                </span>

                <h2>

                    $

                    <?= number_format(
                        (float) ($return['total_refund'] ?? 0),
                        2
                    ) ?>

                </h2>

            </div>

        </div>

    </div>

</div>

<div class="panel-card mt-2">

    <div class="panel-title">
        Returned Items
    </div>

    <div class="table-wrapper">

        <table class="malkel-table">

            <thead>

                <tr>

                    <th>Product</th>

                    <th>Quantity</th>

                    <th>Unit Price</th>

                    <th>Total Refund</th>

                    <th>Reason</th>

                </tr>

            </thead>

            <tbody>

            <?php foreach (($items ?? []) as $item): ?>

                <tr>

                    <td>

                        <?= htmlspecialchars(
                            $item['product_name']
                        ) ?>

                    </td>

                    <td>

                        <?= (int) $item['quantity'] ?>

                    </td>

                    <td>

                        $

                        <?= number_format(
                            (float) ($item['unit_price'] ?? 0),
                            2
                        ) ?>

                    </td>

                    <td>

                        $

                        <?= number_format(
                            (float) ($item['total_refund'] ?? 0),
                            2
                        ) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars(
                            $item['reason']
                            ?? '-'
                        ) ?>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php

$content = ob_get_clean();

$pageTitle = 'Return Details';

include dirname(__DIR__) . '/layouts/app.php';
