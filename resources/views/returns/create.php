<?php ob_start(); ?>

<div class="max-w-6xl mx-auto">

    <div class="glass rounded-3xl p-8 border border-slate-800">

        <div class="mb-8">
            <h3 class="text-3xl font-bold">
                New Return
            </h3>

            <p class="text-slate-400 mt-2">
                Process a product return and refund.
            </p>
        </div>

        <form id="returnForm">

            <!-- Invoice Lookup -->
            <div class="mb-6">

                <label class="block mb-2 font-medium">
                    Invoice Number
                </label>

                <div class="flex gap-4">

                    <input
                        type="text"
                        id="invoiceSearch"
                        placeholder="Enter invoice number..."
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >

                    <button
                        type="button"
                        id="lookupInvoice"
                        class="px-6 py-4 bg-blue-600 hover:bg-blue-500 rounded-xl"
                    >
                        Lookup
                    </button>

                </div>

                <input
                    type="hidden"
                    name="sale_id"
                    id="saleId"
                >

                <div id="invoiceInfo" class="mt-4 hidden">

                    <div class="p-4 bg-slate-900 rounded-xl">

                        <p>
                            <strong>Customer:</strong>
                            <span id="invoiceCustomer"></span>
                        </p>

                        <p>
                            <strong>Date:</strong>
                            <span id="invoiceDate"></span>
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
                        Look up an invoice to see items.
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

let saleItems = [];

document.getElementById('lookupInvoice').addEventListener('click', async function() {
    const invoice = document.getElementById('invoiceSearch').value.trim();

    if (!invoice) {
        alert('Please enter an invoice number');
        return;
    }

    try {
        const response = await fetch('/pos/invoice-lookup?invoice=' + encodeURIComponent(invoice));
        const data = await response.json();

        if (!data.success) {
            alert('Invoice not found');
            return;
        }

        const sale = data.sale;
        const items = data.items;

        document.getElementById('saleId').value = sale.id;
        document.getElementById('invoiceCustomer').textContent = sale.customer_name || 'Walk-in Customer';
        document.getElementById('invoiceDate').textContent = sale.created_at;
        document.getElementById('invoiceInfo').classList.remove('hidden');

        saleItems = items;

        const container = document.getElementById('returnItems');
        container.innerHTML = items.map(item => `
            <div class="p-4 bg-slate-900 rounded-xl flex items-center justify-between">
                <div>
                    <strong>${item.product_name}</strong>
                    <br>
                    <small>Price: $${parseFloat(item.unit_price).toFixed(2)}</small>
                </div>
                <div class="flex items-center gap-4">
                    <label>Qty:</label>
                    <input
                        type="number"
                        class="return-qty w-20 p-2 rounded-lg bg-slate-800 border border-slate-700"
                        data-product-id="${item.product_id}"
                        data-unit-price="${item.unit_price}"
                        max="${item.quantity}"
                        min="0"
                        value="0"
                    >
                </div>
            </div>
        `).join('');

    } catch (error) {
        alert('Error looking up invoice');
    }
});

document.getElementById('returnForm').addEventListener('submit', async function(event) {
    event.preventDefault();

    const qtyInputs = document.querySelectorAll('.return-qty');
    const items = [];

    qtyInputs.forEach(input => {
        const qty = parseInt(input.value) || 0;
        if (qty > 0) {
            items.push({
                product_id: parseInt(input.dataset.productId),
                quantity: qty,
                unit_price: parseFloat(input.dataset.unitPrice)
            });
        }
    });

    if (!items.length) {
        alert('Please select at least one item to return');
        return;
    }

    const payload = {
        sale_id: parseInt(document.getElementById('saleId').value),
        reason: document.getElementById('returnReason').value,
        items: items
    };

    try {
        const response = await fetch('/returns/store', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (data.success) {
            alert('Return processed successfully. Return #: ' + data.return_number);
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

$pageTitle = 'New Return';

include dirname(__DIR__) . '/layouts/app.php';
