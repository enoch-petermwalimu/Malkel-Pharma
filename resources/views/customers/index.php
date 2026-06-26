<?php ob_start(); ?>

<div class="page-header">

    <div>

        <h1>
            Customers
        </h1>

        <p>
            Manage pharmacy customers and loyalty points
        </p>

    </div>

    <a
        href="#"
        class="btn-primary"
        onclick="alert('Customer creation is handled during POS checkout')"
    >
        Add Customer
    </a>

</div>

<div class="card">

    <div class="search-bar">

        <input
            type="text"
            placeholder="Search customer..."
            class="input-premium"
        >

    </div>

</div>

<div class="customer-grid">

<?php if(!empty($customers)): ?>

    <?php foreach($customers as $customer): ?>

        <div class="customer-card">

            <div class="customer-avatar">

                <?=
                strtoupper(
                    substr(
                        $customer['full_name'],
                        0,
                        2
                    )
                )
                ?>

            </div>

            <div class="customer-name">

                <?= htmlspecialchars(
                    $customer['full_name']
                ) ?>

            </div>

            <div class="customer-phone">

                <?= htmlspecialchars(
                    $customer['phone']
                    ?? '-'
                ) ?>

            </div>

            <div class="customer-email">

                <?= htmlspecialchars(
                    $customer['email']
                    ?? '-'
                ) ?>

            </div>

            <div class="loyalty-box">

                <span>
                    Loyalty Points
                </span>

                <strong>

                    <?= (int)
                    $customer['loyalty_points'] ?>

                </strong>

            </div>

            <div class="customer-actions">

                <a
                href="#"
                class="btn-secondary"
                onclick="alert('Customer profile view coming soon')"
                >
                    Profile
                </a>

                <a
                href="#"
                class="btn-primary"
                onclick="alert('Customer edit coming soon')"
                >
                    Edit
                </a>

            </div>

        </div>

    <?php endforeach; ?>

<?php else: ?>

<div class="card">

    No customers found.

</div>

<?php endif; ?>

</div>

<?php

$content =
ob_get_clean();

$pageTitle =
'Customers';

include
dirname(__DIR__)
.'/layouts/app.php';
