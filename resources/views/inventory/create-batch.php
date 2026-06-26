<?php ob_start(); ?>

<div class="max-w-3xl mx-auto">

    <div class="card">

        <h2 class="text-2xl font-bold mb-6">
            Ajouter un lot
        </h2>

        <form
            method="POST"
            action="/inventory/store-batch"
        >

            <div class="mb-4">

                <label class="block mb-2">
                    Produit
                </label>

                <input
                    type="text"
                    id="product-search"
                    placeholder="Rechercher un produit..."
                    class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700"
                    autocomplete="off"
                >

                <input
                    type="hidden"
                    name="product_id"
                    id="product_id"
                >

                <div
                    id="search-results"
                    class="mt-2"
                ></div>

            </div>

            <div class="mb-4">

                <label class="block mb-2">
                    Numéro de lot
                </label>

                <input
                    type="text"
                    name="batch_number"
                    required
                    class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700"
                >

            </div>

            <div class="mb-4">

                <label class="block mb-2">
                    Date d'expiration
                </label>

                <input
                    type="date"
                    name="expiry_date"
                    required
                    class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700"
                >

            </div>

            <div class="mb-4">

                <label class="block mb-2">
                    Quantité
                </label>

                <input
                    type="number"
                    name="quantity"
                    min="1"
                    required
                    class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700"
                >

            </div>

<div class="grid grid-cols-2 gap-4">

    <div>

        <label>
            Prix Achat USD
        </label>

        <input
            type="number"
            step="0.01"
            id="purchase_price_usd"
            name="purchase_price"
            class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700"
        >

    </div>

    <div>

        <label>
            Prix Achat CDF
        </label>

        <input
            type="number"
            id="purchase_price_cdf"
            class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700"
        >

    </div>

</div>

<div class="grid grid-cols-2 gap-4 mt-4">

    <div>

        <label>
            Prix Vente USD
        </label>

        <input
            type="number"
            step="0.01"
            id="selling_price_usd"
            name="selling_price"
            class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700"
        >

    </div>

    <div>

        <label>
            Prix Vente CDF
        </label>

        <input
            type="number"
            id="selling_price_cdf"
            class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700"
        >

    </div>

</div>

            <div class="mb-4">

                <label class="block mb-2">
                    Fournisseur
                </label>

                <input
                    type="text"
                    name="supplier"
                    class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700"
                >

            </div>

            <button
                type="submit"
                class="btn"
            >
                Enregistrer le lot
            </button>

        </form>

    </div>

</div>

<script>

document
.getElementById('product-search')
.addEventListener(
    'keyup',
    async function()
{

    const query =
        this.value.trim();

    if(query.length < 1)
    {
        document
            .getElementById(
                'search-results'
            )
            .innerHTML = '';

        return;
    }

    try
    {
        const response =
            await fetch(
                '/products/search?q=' +
                encodeURIComponent(query)
            );

        const data =
            await response.json();

        const products =
            data.products || [];
        const results =
            document.getElementById(
                'search-results'
            );

        results.innerHTML = '';

            if (!products.length)
            {
                results.innerHTML = `
                    <div class="p-3">
                        Aucun produit trouvé
                    </div>
                `;

                return;
            }

            products.forEach(product => {
            const div =
                document.createElement('div');

            div.className =
                'p-3 mb-2 border border-slate-700 rounded-xl cursor-pointer hover:bg-slate-800';

            div.innerHTML = `
                <strong>
                    ${product.name}
                </strong>
                <br>
                ${product.selling_price} USD
            `;

            div.addEventListener(
                'click',
                function()
            {

                document
                    .getElementById(
                        'product-search'
                    )
                    .value =
                        product.name;

                document
                    .getElementById(
                        'product_id'
                    )
                    .value =
                        product.id;

                results.innerHTML = '';

            });

            results.appendChild(div);

        });

    }
    catch(error)
    {
        console.error(error);
    }

});

const RATE = 2850;

const purchaseUsd =
    document.getElementById(
        'purchase_price_usd'
    );

const purchaseCdf =
    document.getElementById(
        'purchase_price_cdf'
    );

purchaseUsd?.addEventListener(
    'input',
    () => {

        purchaseCdf.value =
            Math.round(
                purchaseUsd.value
                * RATE
            );

    }
);

purchaseCdf?.addEventListener(
    'input',
    () => {

        purchaseUsd.value =
            (
                purchaseCdf.value
                / RATE
            ).toFixed(2);

    }
);

const sellingUsd =
    document.getElementById(
        'selling_price_usd'
    );

const sellingCdf =
    document.getElementById(
        'selling_price_cdf'
    );

sellingUsd?.addEventListener(
    'input',
    () => {

        sellingCdf.value =
            Math.round(
                sellingUsd.value
                * RATE
            );

    }
);

sellingCdf?.addEventListener(
    'input',
    () => {

        sellingUsd.value =
            (
                sellingCdf.value
                / RATE
            ).toFixed(2);

    }
);
</script>

<?php

$content = ob_get_clean();

$pageTitle = 'Ajouter un lot';

include dirname(__DIR__)
    . '/layouts/app.php';
