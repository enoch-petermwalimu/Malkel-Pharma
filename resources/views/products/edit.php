<?php ob_start();

// Ensure $product is defined to avoid "Undefined variable" notices
$product = $product ?? [];
?>

<div class="card">

    <h2 style="margin-bottom:20px;">
        Modifier Produit
    </h2>

    <form
        method="POST"
        action="/products/update"
    >

        <input
            type="hidden"
            name="id"
            value="<?= htmlspecialchars($product['id'] ?? '') ?>"
        >

        <div style="margin-bottom:15px;">

            <label>Nom du produit</label>

            <input
                type="text"
                name="name"
                value="<?= htmlspecialchars($product['name'] ?? '') ?>"
                required
            >

        </div>

        <div style="margin-bottom:15px;">

            <label>Code barre</label>

            <input
                type="text"
                name="barcode"
                value="<?= htmlspecialchars($product['barcode'] ?? '') ?>"
            >

        </div>

        <div style="margin-bottom:15px;">

            <label>Dosage</label>

            <input
                type="text"
                name="strength"
                value="<?= htmlspecialchars($product['strength'] ?? '') ?>"
            >

        </div>

        <div style="margin-bottom:15px;">

            <label>Prix vente</label>

            <input
                type="number"
                step="0.01"
                name="price"
                value="<?= htmlspecialchars($product['selling_price'] ?? 0) ?>"
            >

        </div>

        <div style="margin-bottom:15px;">

            <label>Prix achat</label>

            <input
                type="number"
                step="0.01"
                name="purchase_price"
                value="<?= htmlspecialchars($product['purchase_price'] ?? 0) ?>"
            >

        </div>

        <div style="margin-bottom:15px;">

            <label>Stock</label>

            <input
                type="number"
                name="stock_quantity"
                value="<?= htmlspecialchars($product['stock_quantity'] ?? 0) ?>"
            >

        </div>

        <div style="margin-bottom:15px;">

            <label>Stock minimum</label>

            <input
                type="number"
                name="minimum_stock_level"
                value="<?= htmlspecialchars($product['minimum_stock_level'] ?? 0) ?>"
            >

        </div>

        <button
            type="submit"
            class="btn"
        >
            Enregistrer les modifications
        </button>

    </form>

</div>

<?php

$content = ob_get_clean();

$pageTitle = 'Modifier Produit';

include __DIR__ . '/../layouts/app.php';