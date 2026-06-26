<?php ob_start(); ?>

<div class="flex justify-between items-center mb-6">

    <div>

        <h2 class="text-2xl font-bold">
            Purchase Management
        </h2>

        <p class="text-slate-400">
            Réception des marchandises fournisseurs
        </p>

    </div>

    <a
        href="/purchases/history"
        class="px-4 py-2 bg-slate-700 rounded-xl"
    >
        Historique
    </a>

</div>

<!-- FOURNISSEUR -->

<div class="glass rounded-3xl p-6 mb-6">

    <h3 class="font-bold mb-4">
        Fournisseur
    </h3>

    <input
        type="text"
        id="supplier-search"
        placeholder="Rechercher un fournisseur..."
        class="w-full p-3 rounded-xl bg-slate-800"
    >

    <input
        type="hidden"
        id="supplier_id"
    >

    <div
        id="supplier-results"
        class="mt-3"
    ></div>

</div>

<!-- AJOUT PRODUIT -->

<div class="glass rounded-3xl p-6 mb-6">

    <h3 class="font-bold mb-4">
        Ajouter un produit
    </h3>

    <div class="grid grid-cols-5 gap-4">

        <div>

            <label>
                Produit
            </label>

            <input
                type="text"
                id="product-search"
                class="w-full p-3 rounded-xl bg-slate-800"
            >

            <input
                type="hidden"
                id="product_id"
            >

            <div
                id="product-results"
            ></div>

        </div>

        <div>

            <label>
                Quantité
            </label>

            <input
                type="number"
                id="quantity"
                class="w-full p-3 rounded-xl bg-slate-800"
            >

        </div>

        <div>

            <label>
                Prix Achat
            </label>

            <input
                type="number"
                step="0.01"
                id="unit_cost"
                class="w-full p-3 rounded-xl bg-slate-800"
            >

        </div>

        <div>

            <label>
                Expiration
            </label>

            <input
                type="date"
                id="expiry_date"
                class="w-full p-3 rounded-xl bg-slate-800"
            >

        </div>

        <div>

            <label>
                Lot
            </label>

            <input
                type="text"
                id="batch_number"
                class="w-full p-3 rounded-xl bg-slate-800"
            >

        </div>

    </div>

    <button
        id="add-product-btn"
        class="mt-4 px-4 py-2 bg-blue-600 rounded-xl"
    >
        Ajouter
    </button>

</div>

<!-- TABLEAU -->

<div class="glass rounded-3xl overflow-hidden">

    <table class="w-full">

        <thead class="bg-slate-900">

            <tr>

                <th class="p-4 text-left">
                    Produit
                </th>

                <th class="p-4 text-left">
                    Qté
                </th>

                <th class="p-4 text-left">
                    Prix Achat
                </th>

                <th class="p-4 text-left">
                    Total
                </th>

                <th class="p-4 text-left">
                    Lot
                </th>

                <th class="p-4 text-left">
                    Expiration
                </th>

                <th class="p-4 text-left">
                    Actions
                </th>

            </tr>

        </thead>

        <tbody id="purchase-items">

            <tr>

                <td
                    colspan="7"
                    class="p-6 text-center text-slate-400"
                >
                    Aucun produit ajouté
                </td>

            </tr>

        </tbody>

    </table>

</div>

<!-- TOTAL -->

<div class="mt-6 text-right">

    <h2 class="text-2xl font-bold">

        Total :

        <span id="purchase-total">
            0.00
        </span>

    </h2>

</div>

<!-- ACTION -->

<div class="mt-6">

    <button
        id="save-purchase-btn"
        class="px-6 py-3 bg-green-600 rounded-xl"
    >
        Valider Achat
    </button>

</div>

<?php

$content = ob_get_clean();

$pageTitle = 'Purchases';

include dirname(__DIR__)
    . '/layouts/app.php';