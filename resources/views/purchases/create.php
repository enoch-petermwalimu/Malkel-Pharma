<?php ob_start(); ?>

<div class="max-w-6xl mx-auto">

    <div class="glass rounded-3xl p-8 border border-slate-800">

        <div class="mb-8">
            <h3 class="text-3xl font-bold">
                Nouvel Achat
            </h3>

            <p class="text-slate-400 mt-2">
                Créez un bon de commande fournisseur.
            </p>
        </div>

        <form id="purchaseForm">

            <!-- Supplier Selection -->
            <div class="mb-6">

                <label class="block mb-2 font-medium">
                    Fournisseur
                </label>

                <input
                    type="text"
                    id="supplierSearch"
                    placeholder="Rechercher un fournisseur..."
                    class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    autocomplete="off"
                >

                <input
                    type="hidden"
                    name="supplier_id"
                    id="supplierId"
                >

                <div
                    id="supplierResults"
                    class="mt-2"
                ></div>

            </div>

            <!-- Product Selection -->
            <div class="mb-6">

                <h4 class="font-bold mb-4">
                    Produits
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                    <div>
                        <label class="block mb-2 text-sm">
                            Produit
                        </label>

                        <input
                            type="text"
                            id="productSearch"
                            placeholder="Rechercher..."
                            class="w-full p-3 rounded-xl bg-slate-900 border border-slate-700"
                            autocomplete="off"
                        >

                        <input
                            type="hidden"
                            id="productId"
                        >

                        <div
                            id="productResults"
                            class="mt-1"
                        ></div>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm">
                            Quantité
                        </label>

                        <input
                            type="number"
                            id="quantity"
                            min="1"
                            value="1"
                            class="w-full p-3 rounded-xl bg-slate-900 border border-slate-700"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 text-sm">
                            Prix unitaire
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            id="unitCost"
                            class="w-full p-3 rounded-xl bg-slate-900 border border-slate-700"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 text-sm">
                            Lot
                        </label>

                        <input
                            type="text"
                            id="batchNumber"
                            class="w-full p-3 rounded-xl bg-slate-900 border border-slate-700"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 text-sm">
                            Expiration
                        </label>

                        <input
                            type="date"
                            id="expiryDate"
                            class="w-full p-3 rounded-xl bg-slate-900 border border-slate-700"
                        >
                    </div>

                </div>

                <button
                    type="button"
                    id="addProductBtn"
                    class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-xl"
                >
                    Ajouter le produit
                </button>

            </div>

            <!-- Items Table -->
            <div class="mb-6">

                <h4 class="font-bold mb-4">
                    Produits ajoutés
                </h4>

                <div class="overflow-x-auto">

                    <table class="w-full" id="itemsTable">

                        <thead class="bg-slate-900">

                            <tr>

                                <th class="p-3 text-left">
                                    Produit
                                </th>

                                <th class="p-3 text-left">
                                    Qté
                                </th>

                                <th class="p-3 text-left">
                                    Prix unitaire
                                </th>

                                <th class="p-3 text-left">
                                    Total
                                </th>

                                <th class="p-3 text-left">
                                    Lot
                                </th>

                                <th class="p-3 text-left">
                                    Expiration
                                </th>

                                <th class="p-3 text-left">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody id="itemsBody">

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

            </div>

            <!-- Totals -->
            <div class="text-right mb-6">

                <h2 class="text-2xl font-bold">

                    Total :

                    <span id="purchaseTotal">
                        0.00
                    </span>

                </h2>

            </div>

            <!-- Submit -->
            <div class="text-right">

                <button
                    type="submit"
                    id="savePurchaseBtn"
                    class="px-8 py-4 bg-green-600 hover:bg-green-500 rounded-2xl font-bold"
                >
                    Valider l'achat
                </button>

            </div>

        </form>

    </div>

</div>

<script>

let purchaseItems = [];
let selectedSupplierId = null;

// Supplier search
document.getElementById('supplierSearch').addEventListener('keyup', async function() {
    const query = this.value.trim();
    if (query.length < 1) {
        document.getElementById('supplierResults').innerHTML = '';
        return;
    }

    const response = await fetch('/suppliers/search?q=' + encodeURIComponent(query));
    const data = await response.json();

    const results = document.getElementById('supplierResults');
    results.innerHTML = '';

    if (!data.success || !data.suppliers.length) {
        results.innerHTML = '<div class="p-3 text-slate-400">Aucun fournisseur trouvé</div>';
        return;
    }

    data.suppliers.forEach(supplier => {
        const div = document.createElement('div');
        div.className = 'p-3 mb-2 border border-slate-700 rounded-xl cursor-pointer hover:bg-slate-800';
        div.innerHTML = `<strong>${supplier.company_name}</strong><br><small>${supplier.contact_name || ''}</small>`;
        div.addEventListener('click', function() {
            document.getElementById('supplierSearch').value = supplier.company_name;
            document.getElementById('supplierId').value = supplier.id;
            selectedSupplierId = supplier.id;
            results.innerHTML = '';
        });
        results.appendChild(div);
    });
});

// Product search
document.getElementById('productSearch').addEventListener('keyup', async function() {
    const query = this.value.trim();
    if (query.length < 1) {
        document.getElementById('productResults').innerHTML = '';
        return;
    }

    const response = await fetch('/products/search?q=' + encodeURIComponent(query));
    const data = await response.json();

    const results = document.getElementById('productResults');
    results.innerHTML = '';

    if (!data.success || !data.products.length) {
        results.innerHTML = '<div class="p-3 text-slate-400">Aucun produit trouvé</div>';
        return;
    }

    data.products.forEach(product => {
        const div = document.createElement('div');
        div.className = 'p-3 mb-2 border border-slate-700 rounded-xl cursor-pointer hover:bg-slate-800';
        div.innerHTML = `<strong>${product.name}</strong><br><small>${product.selling_price} USD</small>`;
        div.addEventListener('click', function() {
            document.getElementById('productSearch').value = product.name;
            document.getElementById('productId').value = product.id;
            document.getElementById('unitCost').value = product.purchase_price || 0;
            results.innerHTML = '';
        });
        results.appendChild(div);
    });
});

// Add product to items
document.getElementById('addProductBtn').addEventListener('click', function() {
    const productId = document.getElementById('productId').value;
    const productName = document.getElementById('productSearch').value;
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    const unitCost = parseFloat(document.getElementById('unitCost').value) || 0;
    const batchNumber = document.getElementById('batchNumber').value;
    const expiryDate = document.getElementById('expiryDate').value;

    if (!productId) {
        alert('Veuillez sélectionner un produit');
        return;
    }

    purchaseItems.push({
        product_id: parseInt(productId),
        product_name: productName,
        quantity: quantity,
        unit_cost: unitCost,
        total_cost: quantity * unitCost,
        batch_number: batchNumber,
        expiry_date: expiryDate
    });

    // Clear inputs
    document.getElementById('productSearch').value = '';
    document.getElementById('productId').value = '';
    document.getElementById('quantity').value = '1';
    document.getElementById('unitCost').value = '';
    document.getElementById('batchNumber').value = '';
    document.getElementById('expiryDate').value = '';

    renderItems();
});

function renderItems() {
    const tbody = document.getElementById('itemsBody');
    const totalSpan = document.getElementById('purchaseTotal');

    if (!purchaseItems.length) {
        tbody.innerHTML = '<tr><td colspan="7" class="p-6 text-center text-slate-400">Aucun produit ajouté</td></tr>';
        totalSpan.textContent = '0.00';
        return;
    }

    let total = 0;

    tbody.innerHTML = purchaseItems.map((item, index) => {
        total += item.total_cost;
        return `
            <tr>
                <td class="p-3">${item.product_name}</td>
                <td class="p-3">${item.quantity}</td>
                <td class="p-3">${item.unit_cost.toFixed(2)}</td>
                <td class="p-3">${item.total_cost.toFixed(2)}</td>
                <td class="p-3">${item.batch_number || '-'}</td>
                <td class="p-3">${item.expiry_date || '-'}</td>
                <td class="p-3">
                    <button type="button" class="text-red-500" onclick="removeItem(${index})">
                        Supprimer
                    </button>
                </td>
            </tr>
        `;
    }).join('');

    totalSpan.textContent = total.toFixed(2);
}

function removeItem(index) {
    purchaseItems.splice(index, 1);
    renderItems();
}

// Submit purchase
document.getElementById('purchaseForm').addEventListener('submit', async function(event) {
    event.preventDefault();

    if (!selectedSupplierId) {
        alert('Veuillez sélectionner un fournisseur');
        return;
    }

    if (!purchaseItems.length) {
        alert('Veuillez ajouter au moins un produit');
        return;
    }

    const subtotal = purchaseItems.reduce((sum, item) => sum + item.total_cost, 0);

    const payload = {
        supplier_id: selectedSupplierId,
        subtotal: subtotal,
        tax: 0,
        discount: 0,
        total: subtotal,
        payment_status: 'pending',
        items: purchaseItems
    };

    try {
        const response = await fetch('/purchases/store', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (data.success) {
            alert('Achat créé avec succès. N°: ' + data.purchase_number);
            window.location.href = '/purchases';
        } else {
            alert('Erreur lors de la création de l\'achat: ' + (data.message || 'Erreur inconnue'));
        }
    } catch (error) {
        alert('Erreur réseau');
    }
});

</script>

<?php

$content = ob_get_clean();

$pageTitle = 'Nouvel Achat';

include dirname(__DIR__) . '/layouts/app.php';
