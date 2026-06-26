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
        Search & Filter Sales
    </div>

    <div class="filter-bar">

        <div class="filter-grid">

            <div>

                <label>Search</label>

                <input
                    type="text"
                    id="salesSearch"
                    placeholder="Invoice or customer..."
                >

            </div>

            <div>

                <label>From</label>

                <input
                    type="date"
                    id="filterFrom"
                >

            </div>

            <div>

                <label>To</label>

                <input
                    type="date"
                    id="filterTo"
                >

            </div>

            <div>

                <label>Payment</label>

                <select id="filterPayment">

                    <option value="">
                        All
                    </option>

                    <option value="cash">
                        Cash
                    </option>

                    <option value="card">
                        Card
                    </option>

                    <option value="mobile_money">
                        Mobile Money
                    </option>

                    <option value="bank_transfer">
                        Bank Transfer
                    </option>

                </select>

            </div>

            <div>

                <label>Status</label>

                <select id="filterStatus">

                    <option value="">
                        All
                    </option>

                    <option value="completed">
                        Completed
                    </option>

                    <option value="cancelled">
                        Cancelled
                    </option>

                    <option value="refunded">
                        Refunded
                    </option>

                </select>

            </div>

        </div>

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

                <tr data-status="<?= htmlspecialchars($sale['sale_status'] ?? $sale['status'] ?? 'completed') ?>">

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

function filterSales() {
    const search = document.getElementById('salesSearch').value.toLowerCase();
    const fromDate = document.getElementById('filterFrom').value;
    const toDate = document.getElementById('filterTo').value;
    const paymentFilter = document.getElementById('filterPayment').value.toLowerCase();
    const statusFilter = document.getElementById('filterStatus').value.toLowerCase();

    const rows = document.querySelectorAll('#salesTable tbody tr');

    rows.forEach(row => {
        const invoice = row.querySelector('td:nth-child(1)')?.innerText.toLowerCase() || '';
        const customer = row.querySelector('td:nth-child(2)')?.innerText.toLowerCase() || '';
        const payment = row.querySelector('td:nth-child(4)')?.innerText.toLowerCase() || '';
        const dateText = row.querySelector('td:nth-child(5)')?.innerText || '';
        const status = row.dataset.status || '';

        // Search filter
        const matchesSearch = search === '' || invoice.includes(search) || customer.includes(search);

        // Payment filter
        const matchesPayment = paymentFilter === '' || payment.includes(paymentFilter);

        // Status filter
        const matchesStatus = statusFilter === '' || status.includes(statusFilter);

        // Date filter
        let matchesDate = true;
        if (fromDate && dateText) {
            matchesDate = dateText >= fromDate;
        }
        if (toDate && dateText && matchesDate) {
            matchesDate = dateText <= toDate;
        }

        row.style.display = (matchesSearch && matchesPayment && matchesStatus && matchesDate) ? '' : 'none';
    });
}

document.getElementById('salesSearch').addEventListener('keyup', filterSales);
document.getElementById('filterFrom').addEventListener('change', filterSales);
document.getElementById('filterTo').addEventListener('change', filterSales);
document.getElementById('filterPayment').addEventListener('change', filterSales);
document.getElementById('filterStatus').addEventListener('change', filterSales);

</script>

<?php

$content =
    ob_get_clean();

$pageTitle =
    'Sales';

include dirname(__DIR__)
    . '/layouts/app.php';
