<?php ob_start(); ?>

<div class="hero-v2">

    <div>

        <span class="hero-tag">
            Pharmacy Inventory
        </span>

        <h1>
            Products Management
        </h1>

        <p>
            Manage pharmaceutical products, pricing and stock levels.
        </p>

    </div>

    <div class="hero-actions">

        <a
            href="/products/create"
            class="btn-primary"
        >
            Add Product
        </a>

    </div>

</div>

<div class="panel-card">

    <div class="panel-title">
        Search Products
    </div>

    <div class="filter-bar">

        <input
            type="text"
            id="productSearch"
            placeholder="Search by name, barcode or SKU..."
        >

    </div>

</div>

<div class="panel-card mt-2">

    <div class="panel-title">
        Products List
    </div>

    <div class="table-wrapper">

        <table
            class="malkel-table"
            id="productsTable"
        >

            <thead>

                <tr>

                    <th>Name</th>

                    <th>Barcode</th>

                    <th>Price</th>

                    <th>Stock</th>

                    <th>Status</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

            <?php foreach (($products ?? []) as $product): ?>

                <?php

                $stock =
                    (int) ($product['current_stock'] ?? 0);

                $minimum =
                    (int) ($product['minimum_stock_level'] ?? 0);

                ?>

                <tr>

                    <td>

                        <strong>
                            <?= htmlspecialchars(
                                $product['name']
                            ) ?>
                        </strong>

                    </td>

                    <td>

                        <?= htmlspecialchars(
                            $product['barcode']
                            ?? '-'
                        ) ?>

                    </td>

                    <td>

                        $

                        <?= number_format(
                            (float) ($product['selling_price'] ?? 0),
                            2
                        ) ?>

                    </td>

                    <td>

                        <?= $stock ?>

                    </td>

                    <td>

                        <?php if ($stock <= 0): ?>

                            <span class="status-danger">
                                Out of Stock
                            </span>

                        <?php elseif ($stock <= $minimum): ?>

                            <span class="status-warning">
                                Low Stock
                            </span>

                        <?php else: ?>

                            <span class="status-success">
                                Available
                            </span>

                        <?php endif; ?>

                    </td>

                    <td>

                        <a
                            href="/products/edit?id=<?= $product['id'] ?>"
                            class="btn-secondary"
                        >
                            Edit
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
.getElementById('productSearch')
.addEventListener(
'keyup',
function(){

    const search =
        this.value.toLowerCase();

    const rows =
        document.querySelectorAll(
            '#productsTable tbody tr'
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
    'Products';

include dirname(__DIR__)
    . '/layouts/app.php';