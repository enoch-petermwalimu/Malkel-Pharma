<?php ob_start(); ?>

<div class="hero-v2">

    <div>

        <span class="hero-tag">
            Point Of Sale
        </span>

        <h1>
            MARKEL PHARMA POS
        </h1>

        <p>
            Smart Pharmacy Checkout System
        </p>

    </div>

</div>

<div class="pos-v4">

    <!-- =====================================================
         LEFT PANEL
    ====================================================== -->

    <div class="pos-left">

        <div class="panel-card">

            <div class="panel-title">

                Search Product

            </div>

            <input
                type="text"
                id="productSearch"
                placeholder="Search medicine..."
                autocomplete="off"
            >

            <div
                id="searchResults"
                class="search-results"
            >

                <div class="empty-state">

                    Start typing...

                </div>

            </div>

        </div>

    </div>

    <!-- =====================================================
         RIGHT PANEL
    ====================================================== -->

    <div class="pos-right">

        <!-- =============================================
             CART
        ============================================== -->

        <div class="panel-card">

            <div class="panel-title">

                Shopping Cart

            </div>

            <div
                id="cartItems"
                class="cart-items"
            >

                <div class="empty-state">

                    No products selected

                </div>

            </div>

        </div>

<!-- =============================================
     PAYMENT
============================================= -->

<div class="panel-card">

    <div class="panel-title">

        Payment

    </div>

    <div class="form-grid">

        <div>

            <label>
                Payment Method
            </label>

            <select id="paymentMethod">

                <option value="cash">
                    Cash
                </option>

                <option value="mobile_money">
                    Mobile Money
                </option>

                <option value="card">
                    Card
                </option>

                <option value="bank_transfer">
                    Bank Transfer
                </option>

            </select>

        </div>

        <div>

            <label>
                Currency Mode
            </label>

            <select id="currencyMode">

                <option value="USD">
                    USD
                </option>

                <option value="CDF">
                    CDF
                </option>

                <option value="MIXED">
                    MIXED
                </option>

            </select>

        </div>

    </div>

    <div
        class="payment-block"
        style="margin-top:15px;"
    >

        <label>
            Exchange Rate
        </label>

        <input
            type="number"
            id="exchangeRate"
            value="2350"
        >

    </div>

    <!-- USD -->

    <div
        id="usdPaymentBlock"
        class="payment-block"
    >

        <label>
            USD Received
        </label>

        <input
            type="number"
            id="usdReceived"
            value="0"
            step="0.01"
        >

    </div>

    <!-- CDF -->

    <div
        id="cdfPaymentBlock"
        class="payment-block"
        style="display:none;"
    >

        <label>
            CDF Received
        </label>

        <input
            type="number"
            id="cdfReceived"
            value="0"
            step="0.01"
        >

    </div>

</div>

<div class="panel-card">

    <div class="panel-title">

        Payment Summary

    </div>

    <div class="summary-row">

        <span>
            Amount Due
        </span>

        <strong id="amountDue">

            $ 0.00

        </strong>

    </div>

    <div class="summary-row">

        <span>
            Amount Received
        </span>

        <strong id="amountReceivedDisplay">

            $ 0.00

        </strong>

    </div>

    <div class="summary-row total-row-big">

        <span>
            Change
        </span>

        <strong id="changeAmount">

            $ 0.00

        </strong>

    </div>

<div class="panel-card">

    <div class="panel-title">
        Customer
    </div>

    <div class="form-grid">

        <div>
            <label>Full Name</label>

            <input
                type="text"
                id="customerName"
                placeholder="Customer name"
            >
        </div>

        <div>
            <label>Phone Number</label>

            <input
                type="text"
                id="customerPhone"
                placeholder="Phone number"
            >
        </div>

    </div>

</div>
<!-- =============================================
     TOTALS
============================================= -->

<div class="panel-card">

    <div class="panel-title">

        Sale Summary

    </div>

    <div class="summary-row">

        <span>

            Discount

        </span>

        <input
            type="number"
            id="discountInput"
            value="0"
            min="0"
            step="0.01"
            style="
                width:120px;
                text-align:right;
            "
        >

    </div>

    <div class="summary-row">

        <span>

            Subtotal (USD)

        </span>

        <strong>

            $
            <span id="subtotalValue">

                0.00

            </span>

        </strong>

    </div>

    <div class="summary-row">

        <span>

            Discount

        </span>

        <strong>

            $
            <span id="discountValue">

                0.00

            </span>

        </strong>

    </div>

    <div class="summary-row">

        <span>

            Tax

        </span>

        <strong>

            $
            <span id="taxValue">

                0.00

            </span>

        </strong>

    </div>

    <div class="summary-row total-row-big">

        <span>

            TOTAL USD

        </span>

        <strong>

            $
            <span id="totalValue">

                0.00

            </span>

        </strong>

    </div>

    <div class="summary-row">

        <span>

            TOTAL CDF

        </span>

        <strong>

            FC
            <span id="totalCDF">

                0

            </span>

        </strong>

    </div>

</div>


</div>
<!-- =============================================
     CHECKOUT
============================================= -->

<div class="checkout-wrapper">

    <button
        id="checkoutBtn"
        class="checkout-btn"
    >

        COMPLETE SALE

    </button>

</div>

    </div>

</div>

<!-- =====================================================
     SUCCESS MODAL
====================================================== -->

<div
    id="saleModal"
    class="sale-modal hidden"
>

    <div class="sale-modal-card">

        <div class="sale-success-icon">

            ✓

        </div>

        <h2>

            Sale Completed

        </h2>

        <p>

            Select document to generate

        </p>

        <div class="sale-modal-actions">

            <button
                id="receiptBtn"
                class="modal-action-btn"
            >

                Receipt

            </button>

            <button
                id="pdfBtn"
                class="modal-action-btn"
            >

                PDF Invoice

            </button>

            <button
                id="printBtn"
                class="modal-action-btn"
            >

                Print

            </button>

        </div>

        <button
            id="closeModalBtn"
            class="modal-close-btn"
        >

            Close

        </button>

    </div>

</div>

<script src="/assets/js/toast.js"></script>

<script src="/assets/js/pos.js"></script>

<?php

$content =
    ob_get_clean();

$pageTitle =
    'Point Of Sale';

include dirname(__DIR__)
    . '/layouts/app.php';
?>
