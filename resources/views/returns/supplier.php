<?php ob_start(); ?>

<div class="max-w-6xl mx-auto">

    <div class="glass rounded-3xl p-8 border border-slate-800">

        <div class="mb-8">
            <h3 class="text-3xl font-bold">
                Supplier Return
            </h3>

            <p class="text-slate-400 mt-2">
                Return damaged or defective products to supplier.
            </p>
        </div>

        <form id="supplierReturnForm">

            <!-- Supplier Selection -->
            <div class="mb-6">

                <label class="block mb-2 font-medium">
                    Supplier
                </label>

                <input
                    type="text"
                    id="supplierSearch"
                    placeholder="Search supplier..."
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

            <!-- Purchase Lookup -->
            <div class="mb-6">

                <label class="block mb-2 font-medium">
                    Purchase Number
                </label>

                <div class="flex gap-4">

                    <input
                        type="text"
                        id="purchaseSearch"
                        placeholder="Enter purchase number..."
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >

                    <button
                        type="button"
                        id="lookupPurchase"
                        class="px-6 py-4 bg-blue-600 hover:bg-blue-500 rounded-xl"
                    >
                        Lookup
                    </button>

                </div>

                <input
                    type="hidden"
                    name="purchase_id"
                    id="purchaseId"
                >

                <div id="purchaseInfo" class="mt-4 hidden">

                    <div class="p-4 bg-slate-900 rounded-xl">

                        <p>
                            <strong>Supplier:</strong>
                            <span id="purchaseSupplier"></span>
                        </p>

                        <p>
                            <strong>Date:</strong>
                            <span id="purchaseDate"></span>
                        </p>

                    </div>

                </div>

            </div>

            <!-- Reason -->
            <div class="mb-6">

                <label class="block mb-2 font-medium">
                    Return Reason
                </label>

                <textarea
                    name="reason"
                    id="returnReason"
                    rows="3"
                    class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                ></textarea>

            </div>

            <!-- Items -->
            <div class="mb-6">

                <h4 class="font-bold mb-4">
                    Items to Return
                </h4>

                <div id="returnItems" class="space-y-4">

                    <p class="text-slate-400">
                        Look up a purchase to see items.
                    </p>

                </div>

            </div>

            <!-- Submit -->
            <div class="text-right">

                <button
                    type="submit"
                    id="submitReturn"
                    class="px-8 py-4 bg-green-600 hover:bg-green-500 rounded-2xl font-bold"
                >
                    Process Return
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
        results.innerHTML = '<div class="p-3 text-slate-400">No suppliers found</div>';
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

// Purchase lookup
document.getElementById('lookupPurchase').addEventListener('click', async function() {
    const purchaseNumber = document.getElementById('purchaseSearch').value.trim();

    if (!purchaseNumber) {
        alert('Please enter a purchase number');
        return;
    }

    // For now, we'll just show a manual entry form
    // In a real implementation, you'd look up the purchase from the database
    document.getElementById('purchaseId').value = purchaseNumber;
    document.getElementById('purchaseSupplier').textContent = document.getElementById('supplierSearch').value || 'Unknown';
    document.getElementById('purchaseDate').textContent = new Date().toLocaleDateString();
    document.getElementById('purchaseInfo').classList.remove('hidden');

    // Show manual item entry
    const container = document.getElementById('returnItems');
    container.innerHTML = `
        <div class="p-4 bg-slate-900 rounded-xl">
            <p class="text-slate-400 mb-4">
                Enter product details manually:
            </p>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block mb-2 text-sm">Product ID</label>
                    <input type="number" id="manualProductId" class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700">
                </div>
                <div>
                    <label class="block mb-2 text-sm">Batch ID</label>
                    <input type="number" id="manualBatchId" class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700">
                </div>
                <div>
                    <label class="block mb-2 text-sm">Quantity</label>
                    <input type="number" id="manualQuantity" min="1" value="1" class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700">
                </div>
                <div>
                    <label class="block mb-2 text-sm">Unit Price</label>
                    <input type="number" step="0.01" id="manualUnitPrice" class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700">
                </div>
            </div>
            <button type="button" id="addManualItem" class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-xl">
                Add Item
            </button>
        </div>
        <div id="manualItemsList" class="mt-4"></div>
    `;

    document.getElementById('addManualItem').addEventListener('click', function() {
        const productId = parseInt(document.getElementById('manualProductId').value);
        const batchId = parseInt(document.getElementById('manualBatchId').value);
        const quantity = parseInt(document.getElementById('manualQuantity').value) || 1;
        const unitPrice = parseFloat(document.getElementById('manualUnitPrice').value) || 0;

        if (!productId || !batchId) {
            alert('Please enter product ID and batch ID');
            return;
        }

        purchaseItems.push({
            product_id: productId,
            batch_id: batchId,
            quantity: quantity,
            unit_price: unitPrice
        });

        renderManualItems();
    });
});

function renderManualItems() {
    const list = document.getElementById('manualItemsList');
    if (!purchaseItems.length) {
        list.innerHTML = '<p class="text-slate-400">No items added yet.</p>';
        return;
    }

    list.innerHTML = purchaseItems.map((item, index) => `
        <div class="p-3 bg-slate-900 rounded-xl mb-2 flex items-center justify-between">
            <div>
                <strong>Product #${item.product_id}</strong>
                <br>
                <small>Batch #${item.batch_id} | Qty: ${item.quantity} | $${item.unit_price.toFixed(2)}</small>
            </div>
            <button type="button" class="text-red-500" onclick="removeManualItem(${index})">
                Remove
            </button>
        </div>
    `).join('');
}

function removeManualItem(index) {
    purchaseItems.splice(index, 1);
    renderManualItems();
}

// Submit return
document.getElementById('supplierReturnForm').addEventListener('submit', async function(event) {
    event.preventDefault();

    if (!selectedSupplierId) {
        alert('Please select a supplier');
        return;
    }

    if (!purchaseItems.length) {
        alert('Please add at least one item');
        return;
    }

    const payload = {
        supplier_id: selectedSupplierId,
        purchase_id: document.getElementById('purchaseId').value,
        reason: document.getElementById('returnReason').value,
        items: purchaseItems
    };

    try {
        const response = await fetch('/returns/supplier', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (data.success) {
            alert('Supplier return processed successfully');
            window.location.href = '/returns';
        } else {
            alert('Return failed: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        alert('Network error');
    }
});

</script>

<?php

$content = ob_get_clean();

$pageTitle = 'Supplier Return';

include dirname(__DIR__) . '/layouts/app.php';
