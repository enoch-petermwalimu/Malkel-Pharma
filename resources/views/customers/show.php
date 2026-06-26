<?php ob_start(); ?>

<div class="profile-header">

    <div class="profile-avatar">

        <?= strtoupper(
            substr(
                $customer['full_name'],
                0,
                2
            )
        ) ?>

    </div>

    <div>

        <h1>

            <?= htmlspecialchars(
                $customer['full_name']
            ) ?>

        </h1>

        <p>

            Customer Profile

        </p>

    </div>

</div>

<div class="stats-grid">

    <div class="metric-card">

        <span>Total Purchases</span>

        <h2>

            <?= (int)
            ($stats['total_sales'] ?? 0) ?>

        </h2>

    </div>

    <div class="metric-card">

        <span>Total Spent</span>

        <h2>

            $
            <?= number_format(
                $stats['total_spent']
                ?? 0,
                2
            ) ?>

        </h2>

    </div>

    <div class="metric-card">

        <span>Loyalty Points</span>

        <h2>

            <?= (int)
            $customer['loyalty_points'] ?>

        </h2>

    </div>

</div>

<div class="dashboard-two-cols">

    <div class="panel-card">

        <div class="panel-title">

            Contact Information

        </div>

        <div class="info-row">

            <strong>Phone</strong>

            <span>

                <?= htmlspecialchars(
                    $customer['phone']
                    ?? '-'
                ) ?>

            </span>

        </div>

        <div class="info-row">

            <strong>Email</strong>

            <span>

                <?= htmlspecialchars(
                    $customer['email']
                    ?? '-'
                ) ?>

            </span>

        </div>

        <div class="info-row">

            <strong>Address</strong>

            <span>

                <?= htmlspecialchars(
                    $customer['address']
                    ?? '-'
                ) ?>

            </span>

        </div>

    </div>

    <div class="panel-card">

        <div class="panel-title">

            Customer Actions

        </div>

        <div
        style="
        display:flex;
        gap:12px;
        flex-wrap:wrap;
        "
        >

            <a
            href="/pos?customer_id=<?= $customer['id'] ?>"
            class="btn-primary"
            >
                New Sale
            </a>

            <a
            href="/customers/edit?id=<?= $customer['id'] ?>"
            class="btn-secondary"
            >
                Edit
            </a>

        </div>

    </div>

</div>

<div class="panel-card">

    <div class="panel-title">

        Purchase History

    </div>

    <table class="malkel-table">

        <thead>

        <tr>

            <th>Invoice</th>

            <th>Total</th>

            <th>Status</th>

            <th>Date</th>

        </tr>

        </thead>

        <tbody>

        <?php foreach($sales as $sale): ?>

            <tr>

                <td>

                    <?= htmlspecialchars(
                        $sale['invoice_number']
                    ) ?>

                </td>

                <td>

                    $
                    <?= number_format(
                        $sale['total'],
                        2
                    ) ?>

                </td>

                <td>

                    <?= htmlspecialchars(
                        $sale['payment_status']
                    ) ?>

                </td>

                <td>

                    <?= date(
                        'd/m/Y',
                        strtotime(
                            $sale['created_at']
                        )
                    ) ?>

                </td>

            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

</div>

<?php

$content =
ob_get_clean();

$pageTitle =
'Customer Profile';

include
dirname(__DIR__)
.'/layouts/app.php';