<?php ob_start(); ?>

<div class="hero-v2">

    <div>

        <span class="hero-tag">
            Sales Management
        </span>

        <h1>
            Sales History
        </h1>

        <p>
            Track, review and print all pharmacy transactions.
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

<!-- =====================================================
     FILTERS
===================================================== -->

<div class="panel-card">

    <div class="panel-title">
        Search & Filters
    </div>

    <div class="filter-bar">

        <input
            type="text"
            id="salesSearch"
            placeholder="Invoice, customer..."
        >

        <input
            type="date"
            id="startDate"
        >

        <input
            type="date"
            id="endDate"
        >

        <button
            class="btn-secondary"
            onclick="filterSales()"
        >
            Search
        </button>

    </div>

</div>

<!-- =====================================================
     SALES TABLE
===================================================== -->

<div class="panel-card mt-2">

    <div class="panel-title">
        Sales Transactions
    </div>

    <div class="table-wrapper">

        <table
            class="malkel-table"
            id="salesTable"
        >

            <thead>

                <tr>

                    <th>
                        Invoice
                    </th>

                    <th>
                        Customer
                    </th>

                    <th>
                        Total
                    </th>

                    <th>
                        Date
                    </th>

                    <th>
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody>

            <?php if (!empty($sales)): ?>

                <?php foreach ($sales as $sale): ?>

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
                                ?? 'Walk-in Customer'
                            ) ?>

                        </td>

                        <td>

                            $

                            <?= number_format(
                                (float) $sale['total'],
                                2
                            ) ?>

                        </td>

                        <td>

                            <?= date(
                                'd/m/Y H:i',
                                strtotime(
                                    $sale['created_at']
                                )
                            ) ?>

                        </td>

                        <td>

                            <div
                                style="
                                    display:flex;
                                    gap:8px;
                                    flex-wrap:wrap;
                                "
                            >

                                <a
                                    href="/sales/show?id=<?= $sale['id'] ?>"
                                    class="btn-primary"
                                >
                                    View
                                </a>

                                <a
                                    href="/sales/pdf?id=<?= $sale['id'] ?>"
                                    class="btn-secondary"
                                    target="_blank"
                                >
                                    PDF
                                </a>

                                <a
                                    href="/sales/receipt?id=<?= $sale['id'] ?>"
                                    class="btn-secondary"
                                    target="_blank"
                                >
                                    Receipt
                                </a>

                            </div>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>

                    <td
                        colspan="5"
                        style="
                            text-align:center;
                            padding:40px;
                        "
                    >

                        No sales found.

                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<script>

function filterSales()
{
    const search =
        document
        .getElementById(
            'salesSearch'
        )
        .value
        .toLowerCase();

    const rows =
        document.querySelectorAll(
            '#salesTable tbody tr'
        );

    rows.forEach(row => {

        const text =
            row.innerText
            .toLowerCase();

        row.style.display =
            text.includes(search)
            ? ''
            : 'none';
    });
}

</script>

<?php

$content =
    ob_get_clean();

$pageTitle =
    'Sales History';

include dirname(__DIR__)
    . '/layouts/app.php';