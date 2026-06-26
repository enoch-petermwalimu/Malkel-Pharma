<?php ob_start(); ?>

<div class="hero-v2">

    <div>

        <span class="hero-tag">
            Sales History
        </span>

        <h1>
            Sales Management
        </h1>

        <p>
            View, search and manage all completed sales transactions.
        </p>

    </div>

    <div class="hero-actions">

        <a
            href="/pos"
            class="btn-primary"
        >
            New Sale
        </a>

    </div>

</div>

<div class="panel-card">

    <div class="panel-title">
        Search Sales
    </div>

    <div class="filter-bar">

        <input
            type="text"
            id="salesSearch"
            placeholder="Search by invoice number or customer name..."
        >

    </div>

</div>

<div class="panel-card mt-2">

    <div class="panel-title">
        Sales List
    </div>

    <div class="table-wrapper">

        <table
            class="malkel-table"
            id="salesTable"
        >

            <thead>

                <tr>

                    <th>Invoice</th>

                    <th>Customer</th>

                    <th>Total</th>

                    <th>Payment</th>

                    <th>Date</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

            <?php foreach (($sales ?? []) as $sale): ?>

                <tr>

                    <td>

                        <strong>
                            <?= htmlspecialchars(
                                $sale['invoice_number']
                            ) ?>
                        </strong>

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

                        <?php
                        $paymentMethod =
                            $sale['payment_method']
                            ?? '-';
                        ?>

                        <span class="badge badge-info">
                            <?= htmlspecialchars($paymentMethod) ?>
                        </span>

                    </td>

                    <td>

                        <?= htmlspecialchars(
                            $sale['created_at']
                        ) ?>

                    </td>

                    <td>

                        <a
                            href="/sales/show?id=<?= $sale['id'] ?>"
                            class="btn-secondary"
                        >
                            View
                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<script>

document
.getElementById('salesSearch')
.addEventListener(
'keyup',
function(){

    const search =
        this.value.toLowerCase();

    const rows =
        document.querySelectorAll(
            '#salesTable tbody tr'
        );

    rows.forEach(row => {

        const text =
            row.innerText.toLowerCase();

        row.style.display =
            text.includes(search)
            ? ''
            : 'none';

    });

});

</script>

<?php

$content =
    ob_get_clean();

$pageTitle =
    'Sales';

include dirname(__DIR__)
    . '/layouts/app.php';
