<?php ob_start(); ?>

<div class="card">

    <h2 class="text-2xl font-bold mb-6">
        Modifier un lot
    </h2>

    <form
        method="POST"
        action="/inventory/update"
    >

        <input
            type="hidden"
            name="id"
            value="<?= $batch['id'] ?>"
        >

        <div class="mb-4">

            <label>Numéro lot</label>

            <input
                type="text"
                name="batch_number"
                value="<?= htmlspecialchars($batch['batch_number']) ?>"
                class="w-full"
            >

        </div>

        <div class="mb-4">

            <label>Expiration</label>

            <input
                type="date"
                name="expiry_date"
                value="<?= $batch['expiry_date'] ?>"
                class="w-full"
            >

        </div>

        <div class="mb-4">

            <label>Quantité</label>

            <input
                type="number"
                name="quantity"
                value="<?= $batch['quantity'] ?>"
                class="w-full"
            >

        </div>

        <div class="mb-4">

            <label>Fournisseur</label>

            <input
                type="text"
                name="supplier"
                value="<?= htmlspecialchars($batch['supplier']) ?>"
                class="w-full"
            >

        </div>

        <div class="mb-4">

            <label>Prix achat</label>

            <input
                type="number"
                step="0.01"
                name="purchase_price"
                value="<?= $batch['purchase_price'] ?>"
                class="w-full"
            >

        </div>

        <div class="mb-4">

            <label>Prix vente</label>

            <input
                type="number"
                step="0.01"
                name="selling_price"
                value="<?= $batch['selling_price'] ?>"
                class="w-full"
            >

        </div>

        <button
            type="submit"
            class="btn"
        >
            Enregistrer
        </button>

    </form>

</div>

<?php

$content = ob_get_clean();

$pageTitle = 'Modifier lot';

include dirname(__DIR__)
    . '/layouts/app.php';