<?php ob_start(); ?>

<div class="hero-v2">

    <div>

        <span class="hero-tag">
            Returns Management
        </span>

        <h1>
            Returns Center
        </h1>

        <p>
            Process customer product returns safely.
        </p>

    </div>

</div>

<div class="panel-card">

    <div class="panel-title">
        Invoice Lookup
    </div>

    <div class="filter-bar">

        <input
            type="text"
            id="invoiceNumber"
            placeholder="Invoice Number"
        >

        <button
            class="btn-primary"
            onclick="lookupInvoice()"
        >
            Search Invoice
        </button>

    </div>

</div>

<div
    id="saleInfo"
    class="panel-card mt-2"
    style="display:none;"
></div>

<div
    id="saleItems"
    class="panel-card mt-2"
    style="display:none;"
></div>

<script>

let selectedSale = null;

async function lookupInvoice()
{
    const invoice =
        document.getElementById(
            'invoiceNumber'
        ).value.trim();

    if(!invoice)
    {
        alert(
            'Enter invoice number'
        );
        return;
    }

    const response =
        await fetch(
            `/pos/invoice-lookup?invoice=${invoice}`
        );

    const data =
        await response.json();

    if(!data.success)
    {
        alert(
            'Invoice not found'
        );
        return;
    }

    selectedSale =
        data.sale;

    document
        .getElementById(
            'saleInfo'
        )
        .style.display =
            'block';

    document
        .getElementById(
            'saleInfo'
        )
        .innerHTML = `

        <div class="panel-title">
            Invoice Information
        </div>

        <div class="dashboard-grid">

            <div class="metric-card">

                <span>Invoice</span>

                <h3>
                    ${data.sale.invoice_number}
                </h3>

            </div>

            <div class="metric-card">

                <span>Total</span>

                <h3>
                    $${data.sale.total}
                </h3>

            </div>

            <div class="metric-card">

                <span>Customer</span>

                <h3>
                    ${
                        data.sale.customer_id
                        ?? 'Walk-in'
                    }
                </h3>

            </div>

        </div>
    `;

    renderItems(
        data.items
    );
}

function renderItems(items)
{
    let html = `

    <div class="panel-title">
        Returned Products
    </div>

    <table class="malkel-table">

        <thead>

            <tr>

                <th>
                    Product
                </th>

                <th>
                    Sold Qty
                </th>

                <th>
                    Return Qty
                </th>

                <th>
                    Restock
                </th>

            </tr>

        </thead>

        <tbody>
    `;

    items.forEach(item => {

        html += `

        <tr>

            <td>

                ${item.product_name}

            </td>

            <td>

                ${item.quantity}

            </td>

            <td>

                <input
                    type="number"
                    min="0"
                    max="${item.quantity}"
                    id="qty_${item.id}"
                >

            </td>

            <td>

                <input
                    type="checkbox"
                    id="restock_${item.id}"
                >

            </td>

        </tr>
        `;
    });

    html += `

        </tbody>

    </table>

    <div style="margin-top:20px;">

        <label>
            Reason
        </label>

        <textarea
            id="returnReason"
            rows="4"
        ></textarea>

    </div>

    <div style="margin-top:20px;">

        <label>
            Refund Type
        </label>

        <select id="refundType">

            <option value="cash">
                Cash
            </option>

            <option value="credit">
                Store Credit
            </option>

        </select>

    </div>

    <div style="margin-top:25px;">

        <button
            class="btn-primary"
            onclick="submitReturn()"
        >
            Process Return
        </button>

    </div>
    `;

    document
        .getElementById(
            'saleItems'
        )
        .style.display =
            'block';

    document
        .getElementById(
            'saleItems'
        )
        .innerHTML = html;

    window.saleItems =
        items;
}

async function submitReturn()
{
    const items = [];

    window.saleItems.forEach(
        item => {

            const qty =
                document
                .getElementById(
                    `qty_${item.id}`
                )
                .value;

            if(!qty || qty <= 0)
            {
                return;
            }

            items.push({

                product_id:
                    item.product_id,

                quantity:
                    qty,

                unit_price:
                    item.unit_price,

                restock:

                    document
                    .getElementById(
                        `restock_${item.id}`
                    )

                    ?

                    document
                    .getElementById(
                        `restock_${item.id}`
                    ).checked

                    :

                    false
            });
        }
    );

    if(items.length === 0)
    {
        alert(
            'Select products'
        );
        return;
    }

    const response =
        await fetch(
            '/returns/store',
            {
                method:'POST',

                headers:{
                    'Content-Type':
                    'application/json'
                },

                body:JSON.stringify({

                    sale_id:
                        selectedSale.id,

                    customer_id:
                        selectedSale.customer_id,

                    total_amount:
                        selectedSale.total,

                    refund_type:

                        document
                        .getElementById(
                            'refundType'
                        )
                        .value,

                    reason:

                        document
                        .getElementById(
                            'returnReason'
                        )
                        .value,

                    items
                })
            }
        );

    const data =
        await response.json();

    if(data.success)
    {
        alert(
            'Return processed successfully'
        );

        location.reload();
    }
    else
    {
        alert(
            'Return failed'
        );
    }
}

</script>

<?php

$content =
    ob_get_clean();

$pageTitle =
    'Returns Center';

include dirname(__DIR__)
    . '/layouts/app.php';
