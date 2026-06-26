/**
 * ==========================================================
 * MARKEL PHARMA POS V4
 * ==========================================================
 */

class POS
{
    constructor()
    {
        this.cart = [];

        this.lastSaleId = null;

        this.initialize();
    }

    initialize()
    {
        this.bindSearch();

        this.bindDiscount();

        this.bindCurrency();

        this.bindCheckout();

        this.bindModal();

        this.bindPaymentInputs();

        this.calculateTotals();
    }

    /**
     * ======================================================
     * PRODUCT SEARCH
     * ======================================================
     */

    bindSearch()
    {
        const input =
            document.getElementById(
                'productSearch'
            );

        if (!input) {
            return;
        }

        let timeout;

        input.addEventListener(
            'input',
            () => {

                clearTimeout(timeout);

                timeout =
                    setTimeout(
                        () => {

                            this.searchProducts(
                                input.value
                            );

                        },
                        250
                    );

            }
        );
    }

    async searchProducts(query)
    {
        if (!query.trim()) {

            document.getElementById(
                'searchResults'
            ).innerHTML = `
                <div class="empty-state">
                    Start typing...
                </div>
            `;

            return;
        }

        try {

            const response =
                await fetch(
                    `/products/search?q=${encodeURIComponent(query)}`
                );

            const data =
                await response.json();

            if (!data.success) {
                return;
            }

            this.renderProducts(
                data.products
            );

        } catch (error) {

            console.error(error);

            Toast.show(
                'Search failed'
            );
        }
    }

    renderProducts(products)
    {
        const container =
            document.getElementById(
                'searchResults'
            );

        if (!products.length) {

            container.innerHTML = `
                <div class="empty-state">
                    No products found
                </div>
            `;

            return;
        }

        let html = '';

        products.forEach(product => {

            html += `

                <div
                    class="product-result"
                    onclick="pos.addToCart(
                        ${product.id},
                        '${(product.name || '').replace(/'/g,"\\'")}',
                        ${product.selling_price || 0}
                    )"
                >

                    <div>

                        <strong>
                            ${product.name}
                        </strong>

                    </div>

                    <div>

                        $${Number(
                            product.selling_price
                        ).toFixed(2)}

                    </div>

                </div>

            `;
        });

        container.innerHTML =
            html;
    }

    /**
     * ======================================================
     * CART
     * ======================================================
     */

    addToCart(
        id,
        name,
        price
    )
    {
        const existing =
            this.cart.find(
                item => item.id === id
            );

        if (existing) {

            existing.quantity++;

        }
        else {

            this.cart.push({

                id,

                name,

                price:

                    parseFloat(
                        price
                    ),

                quantity: 1
            });
        }

        this.renderCart();

        this.calculateTotals();

        /**
         * CLEAR SEARCH
         */

        document.getElementById(
            'productSearch'
        ).value = '';

        document.getElementById(
            'searchResults'
        ).innerHTML = `
            <div class="empty-state">
                Start typing...
            </div>
        `;

        document.getElementById(
            'productSearch'
        ).focus();
    }
        increaseQty(id)
    {
        const item =
            this.cart.find(
                product =>
                    product.id === id
            );

        if (!item) {
            return;
        }

        item.quantity++;

        this.renderCart();

        this.calculateTotals();
    }

    decreaseQty(id)
    {
        const item =
            this.cart.find(
                product =>
                    product.id === id
            );

        if (!item) {
            return;
        }

        item.quantity--;

        if (
            item.quantity <= 0
        ) {
            this.removeItem(id);
            return;
        }

        this.renderCart();

        this.calculateTotals();
    }

    removeItem(id)
    {
        this.cart =
            this.cart.filter(
                item =>
                    item.id !== id
            );

        this.renderCart();

        this.calculateTotals();
    }

    /**
     * ======================================================
     * CART RENDER
     * ======================================================
     */

    renderCart()
    {
        const container =
            document.getElementById(
                'cartItems'
            );

        if (
            this.cart.length === 0
        ) {

            container.innerHTML = `

                <div class="empty-state">

                    No products selected

                </div>

            `;

            return;
        }

        let html = '';

        this.cart.forEach(item => {

            const total =
                item.price
                * item.quantity;

            html += `

            <div class="cart-item">

                <div
                    style="
                        display:flex;
                        justify-content:space-between;
                        align-items:center;
                        margin-bottom:15px;
                    "
                >

                    <div>

                        <strong>

                            ${item.name}

                        </strong>

                    </div>

                    <button
                        onclick="
                            pos.removeItem(
                                ${item.id}
                            )
                        "
                        class="remove-btn"
                    >

                        ✕

                    </button>

                </div>

                <div
                    style="
                        display:flex;
                        justify-content:space-between;
                        align-items:center;
                        gap:20px;
                    "
                >

                    <div
                        class="qty-controls"
                    >

                        <button
                            class="qty-btn"
                            onclick="
                                pos.decreaseQty(
                                    ${item.id}
                                )
                            "
                        >

                            -

                        </button>

                        <span
                            class="qty-value"
                        >

                            ${item.quantity}

                        </span>

                        <button
                            class="qty-btn"
                            onclick="
                                pos.increaseQty(
                                    ${item.id}
                                )
                            "
                        >

                            +

                        </button>

                    </div>

                    <div>

                        <small>

                            Unit Price

                        </small>

                        <br>

                        <strong>

                            $
                            ${item.price.toFixed(2)}

                        </strong>

                    </div>

                    <div>

                        <small>

                            Line Total

                        </small>

                        <br>

                        <strong>

                            $
                            ${total.toFixed(2)}

                        </strong>

                    </div>

                </div>

            </div>

            `;
        });

        container.innerHTML =
            html;
    }

        /**
     * ======================================================
     * DISCOUNT
     * ======================================================
     */

    bindDiscount()
    {
        const discount =
            document.getElementById(
                'discountInput'
            );

        if (!discount) {
            return;
        }

        discount.addEventListener(
            'input',
            () => {

                this.calculateTotals();

            }
        );
    }

    /**
     * ======================================================
     * PAYMENT INPUTS
     * ======================================================
     */

    bindPaymentInputs()
    {
        const usd =
            document.getElementById(
                'usdReceived'
            );

        const cdf =
            document.getElementById(
                'cdfReceived'
            );

        const rate =
            document.getElementById(
                'exchangeRate'
            );

        [usd, cdf, rate]
        .forEach(input => {

            if (!input) {
                return;
            }

            input.addEventListener(
                'input',
                () => {

                    this.calculateTotals();

                }
            );

        });
    }

    /**
     * ======================================================
     * CURRENCY MODE
     * ======================================================
     */

    bindCurrency()
    {
        const currency =
            document.getElementById(
                'currencyMode'
            );

        if (!currency) {
            return;
        }

        currency.addEventListener(
            'change',
            () => {

                const usdBlock =
                    document.getElementById(
                        'usdPaymentBlock'
                    );

                const cdfBlock =
                    document.getElementById(
                        'cdfPaymentBlock'
                    );

                switch (
                    currency.value
                ) {

                    case 'USD':

                        usdBlock.style.display =
                            'block';

                        cdfBlock.style.display =
                            'none';

                        break;

                    case 'CDF':

                        usdBlock.style.display =
                            'none';

                        cdfBlock.style.display =
                            'block';

                        break;

                    case 'MIXED':

                        usdBlock.style.display =
                            'block';

                        cdfBlock.style.display =
                            'block';

                        break;
                }

                this.calculateTotals();

            }
        );
    }

    /**
     * ======================================================
     * TOTALS
     * ======================================================
     */

    calculateTotals()
    {
        let subtotal = 0;

        this.cart.forEach(item => {

            subtotal +=
                item.price
                * item.quantity;

        });

        const discount =
            parseFloat(
                document.getElementById(
                    'discountInput'
                )?.value || 0
            );

        const tax = 0;

        const total =
            subtotal
            - discount
            + tax;

        const rate =
            parseFloat(
                document.getElementById(
                    'exchangeRate'
                )?.value || 2850
            );

        const totalCDF =
            total * rate;

        document.getElementById(
            'subtotalValue'
        ).textContent =
            subtotal.toFixed(2);

        document.getElementById(
            'discountValue'
        ).textContent =
            discount.toFixed(2);

        document.getElementById(
            'taxValue'
        ).textContent =
            tax.toFixed(2);

        document.getElementById(
            'totalValue'
        ).textContent =
            total.toFixed(2);

        document.getElementById(
            'totalCDF'
        ).textContent =
            Math.round(
                totalCDF
            ).toLocaleString();

        document.getElementById(
            'amountDue'
        ).textContent =
            '$ ' +
            total.toFixed(2);

        this.calculateChange(
            total,
            totalCDF,
            rate
        );
    }

    /**
     * ======================================================
     * CHANGE
     * ======================================================
     */

    calculateChange(
        totalUSD,
        totalCDF,
        rate
    )
    {
        const currency =
            document.getElementById(
                'currencyMode'
            )?.value || 'USD';

        const usdReceived =
            parseFloat(
                document.getElementById(
                    'usdReceived'
                )?.value || 0
            );

        const cdfReceived =
            parseFloat(
                document.getElementById(
                    'cdfReceived'
                )?.value || 0
            );

        const changeBox =
            document.getElementById(
                'changeAmount'
            );

        if (!changeBox) {
            return;
        }

        this.changeUSD = 0;
        this.changeCDF = 0;

        if (
            currency === 'USD'
        ) {

            this.changeUSD =
                usdReceived
                - totalUSD;

            this.changeCDF =
                this.changeUSD
                * rate;

            changeBox.textContent =
                '$ '
                + this.changeUSD.toFixed(2)
                + ' | '
                + Math.round(
                    this.changeCDF
                ).toLocaleString()
                + ' FC';
        }

        else if (
            currency === 'CDF'
        ) {

            this.changeCDF =
                cdfReceived
                - totalCDF;

            this.changeUSD =
                this.changeCDF
                / rate;

            changeBox.textContent =
                Math.round(
                    this.changeCDF
                ).toLocaleString()
                + ' FC'
                + ' | $ '
                + this.changeUSD.toFixed(2);
        }

        else {

            const receivedUSD =
                usdReceived +
                (
                    cdfReceived
                    / rate
                );

            this.changeUSD =
                receivedUSD
                - totalUSD;

            this.changeCDF =
                this.changeUSD
                * rate;

            changeBox.textContent =
                '$ '
                + this.changeUSD.toFixed(2)
                + ' | '
                + Math.round(
                    this.changeCDF
                ).toLocaleString()
                + ' FC';
        }
    }


        /**
     * ======================================================
     * CHECKOUT
     * ======================================================
     */

    bindCheckout()
    {
        const button =
            document.getElementById(
                'checkoutBtn'
            );

        if (!button) {
            return;
        }

        button.addEventListener(
            'click',
            () => {

                this.checkout();

            }
        );
    }

    async checkout()
    {
        if (
            this.cart.length === 0
        ) {

            Toast.show(
                'Cart is empty'
            );

            return;
        }

        try {

            const subtotal =
                this.cart.reduce(
                    (sum, item) =>
                        sum +
                        (
                            item.price
                            * item.quantity
                        ),
                    0
                );

            const discount =
                parseFloat(
                    document.getElementById(
                        'discountInput'
                    )?.value || 0
                );

            const total =
                subtotal - discount;

            const response =
                await fetch(
                    '/sales/checkout',
                    {
                        method:'POST',

                        headers:{
                            'Content-Type':
                            'application/json'
                        },

                        body:JSON.stringify({


                            payment_method:
                                document.getElementById(
                                    'paymentMethod'
                                )?.value || 'cash',
                            customer_name:
                                document.getElementById(
                                    'customerName'
                                )?.value || '',

                            customer_phone:
                                document.getElementById(
                                    'customerPhone'
                                )?.value || '',

                            currency_mode:
                                currencyMode.value,

                            amount_received_usd:
                                parseFloat(
                                    usdReceived.value
                                ) || 0,

                            amount_received_cdf:
                                parseFloat(
                                    cdfReceived.value
                                ) || 0,

                            exchange_rate:2350,

                            change_usd:
                                this.changeUSD || 0,

                            change_cdf:
                                this.changeCDF || 0,
                            subtotal,
                            discount,

                            total,

                            items:
                                this.cart.map(
                                    item => ({

                                        product_id:
                                            item.id,

                                        quantity:
                                            item.quantity,

                                        unit_price:
                                            item.price

                                    })
                                )
                        })
                    }
                );

            const data =
                await response.json();
            if (!data.success) {

                Toast.show(
                    data.message ||
                    'Checkout failed'
                );

                return;
            }

            this.lastSaleId =
                data.sale_id;

            this.openModal();

        }
        catch(error)
        {
            console.error(
                error
            );

            Toast.show(
                'Checkout failed'
            );
        }
    }

    /**
     * ======================================================
     * MODAL
     * ======================================================
     */

    openModal()
    {
        document
            .getElementById(
                'saleModal'
            )
            ?.classList
            .remove(
                'hidden'
            );
    }

    closeModal()
    {
        document
            .getElementById(
                'saleModal'
            )
            ?.classList
            .add(
                'hidden'
            );
    }

    bindModal()
    {
        const closeBtn =
            document.getElementById(
                'closeModalBtn'
            );

        if (closeBtn) {

            closeBtn.addEventListener(
                'click',
                () => {

                    this.closeModal();

                    this.reset();

                }
            );
        }

        const receiptBtn =
            document.getElementById(
                'receiptBtn'
            );

        if (receiptBtn) {

            receiptBtn.addEventListener(
                'click',
                () => {

                    if (
                        !this.lastSaleId
                    ) {
                        return;
                    }

                    window.open(
                        '/sales/receipt?id=' +
                        this.lastSaleId,
                        '_blank'
                    );
                }
            );
        }

        const pdfBtn =
            document.getElementById(
                'pdfBtn'
            );

        if (pdfBtn) {

            pdfBtn.addEventListener(
                'click',
                () => {

                    if (
                        !this.lastSaleId
                    ) {
                        return;
                    }

                    window.open(
                        '/sales/pdf?id=' +
                        this.lastSaleId,
                        '_blank'
                    );
                }
            );
        }

        const printBtn =
            document.getElementById(
                'printBtn'
            );

        if (printBtn) {

            printBtn.addEventListener(
                'click',
                () => {

                    if (
                        !this.lastSaleId
                    ) {
                        return;
                    }

                    window.open(
                        '/sales/receipt?id=' +
                        this.lastSaleId,
                        '_blank'
                    );
                }
            );
        }
    }

    /**
     * ======================================================
     * RESET
     * ======================================================
     */

    reset()
    {
        this.cart = [];

        this.renderCart();

        document.getElementById(
            'customerName'
        ).value = '';

        document.getElementById(
            'customerPhone'
        ).value = '';

        document.getElementById(
            'discountInput'
        ).value = 0;

        document.getElementById(
            'usdReceived'
        ).value = 0;

        document.getElementById(
            'cdfReceived'
        ).value = 0;

        document.getElementById(
            'productSearch'
        ).value = '';

        document.getElementById(
            'searchResults'
        ).innerHTML = `
            <div class="empty-state">
                Start typing...
            </div>
        `;


        this.calculateTotals();
    }
}

/**
 * ==========================================================
 * START APP
 * ==========================================================
 */

const pos = new POS();

window.pos = pos;