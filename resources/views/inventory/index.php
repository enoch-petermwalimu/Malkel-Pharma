<?php ob_start(); ?>

<div class="inventory-header">

    <div>

        <h1 class="inventory-title">

            Inventory Management

        </h1>

        <p class="inventory-subtitle">

            Gestion des lots et du stock

        </p>

    </div>

    <a
        href="/inventory/create-batch"
        class="inventory-add-btn"
    >

        + Add Batch

    </a>

</div>

<!-- =====================================
     KPI CARDS
===================================== -->

<div class="inventory-kpis">

    <div class="inventory-kpi">

        <div class="kpi-label">
            Lots
        </div>

        <div class="kpi-value">

            <?= count($batches) ?>

        </div>

    </div>

    <div class="inventory-kpi">

        <div class="kpi-label">
            Total Stock
        </div>

        <div class="kpi-value">

            <?=
                array_sum(
                    array_column(
                        $batches,
                        'quantity'
                    )
                )
            ?>

        </div>

    </div>

    <div class="inventory-kpi">

        <div class="kpi-label">
            Active Lots
        </div>

        <div class="kpi-value">

            <?= count($batches) ?>

        </div>

    </div>

    <div class="inventory-kpi">

        <div class="kpi-label">
            Expired
        </div>

        <div class="kpi-value">

            <?=
            count(
                array_filter(
                    $batches,
                    fn($b) =>
                    strtotime(
                        $b['expiry_date']
                    ) < time()
                )
            )
            ?>

        </div>

    </div>

</div>

<!-- =====================================
     SEARCH
===================================== -->

<div class="inventory-search-card">

    <input
        type="text"
        id="inventorySearch"
        placeholder="Search product..."
    >

</div>

<!-- =====================================
     LOTS
===================================== -->

<div
    class="inventory-grid"
    id="inventoryGrid"
>

<?php if(empty($batches)): ?>

    <div class="inventory-empty">

        Aucun lot enregistré

    </div>

<?php endif; ?>

<?php foreach($batches as $batch): ?>

<?php

$expired =
    strtotime(
        $batch['expiry_date']
    ) < time();

?>

<div
    class="inventory-card"
    data-name="<?= strtolower(
        htmlspecialchars(
            $batch['product_name']
        )
    ) ?>"
>

    <!-- ==========================
         HEADER
    =========================== -->

    <div class="inventory-card-header">

        <h3>

            <?= htmlspecialchars(
                $batch['product_name']
            ) ?>

        </h3>

        <?php if($expired): ?>

            <span
                class="badge badge-danger"
            >

                Expired

            </span>

        <?php else: ?>

            <span
                class="badge badge-success"
            >

                Active

            </span>

        <?php endif; ?>

    </div>

    <!-- ==========================
         BODY
    =========================== -->

    <div class="inventory-card-body">

        <div class="inventory-info">

            <span>

                Lot Number

            </span>

            <strong>

                <?= htmlspecialchars(
                    $batch['batch_number']
                ) ?>

            </strong>

        </div>

        <div class="inventory-info">

            <span>

                Expiry Date

            </span>

            <strong>

                <?= htmlspecialchars(
                    $batch['expiry_date']
                ) ?>

            </strong>

        </div>

        <div class="inventory-info">

            <span>

                Quantity

            </span>

            <strong>

                <?= (int)
                    $batch['quantity'] ?>

            </strong>

        </div>

        <div class="inventory-info">

            <span>

                Supplier

            </span>

            <strong>

                <?= htmlspecialchars(
                    $batch['supplier']
                    ?? '-'
                ) ?>

            </strong>

        </div>

    </div>

    <!-- ==========================
         ACTIONS
    =========================== -->

    <div
        class="inventory-card-actions"
    >

        <button
            class="inventory-edit-btn"
            onclick="openEditModal(

                '<?= $batch['id'] ?>',

                '<?= htmlspecialchars(
                    $batch['batch_number'],
                    ENT_QUOTES
                ) ?>',

                '<?= $batch['expiry_date'] ?>',

                '<?= $batch['quantity'] ?>',

                '<?= htmlspecialchars(
                    $batch['supplier']
                    ?? '',
                    ENT_QUOTES
                ) ?>',

                '<?= $batch['purchase_price']
                    ?? 0 ?>',

                '<?= $batch['selling_price']
                    ?? 0 ?>'
            )"
        >

            Edit Batch

        </button>

    </div>

</div>

<?php endforeach; ?>

</div>

<!-- =====================================
     EDIT MODAL V2
===================================== -->

<div
    id="editModal"
    class="inventory-modal hidden"
>

    <div class="inventory-modal-card">

        <div class="modal-header">

            <h2>

                Edit Inventory Batch

            </h2>

        </div>

        <form
            method="POST"
            action="/inventory/update"
        >

            <input
                type="hidden"
                name="id"
                id="edit_id"
            >

            <div class="inventory-form-grid">

                <div>

                    <label>
                        Batch Number
                    </label>

                    <input
                        type="text"
                        name="batch_number"
                        id="edit_batch"
                    >

                </div>

                <div>

                    <label>
                        Expiry Date
                    </label>

                    <input
                        type="date"
                        name="expiry_date"
                        id="edit_expiry"
                    >

                </div>

                <div>

                    <label>
                        Quantity
                    </label>

                    <input
                        type="number"
                        name="quantity"
                        id="edit_quantity"
                    >

                </div>

                <div>

                    <label>
                        Supplier
                    </label>

                    <input
                        type="text"
                        name="supplier"
                        id="edit_supplier"
                    >

                </div>

            </div>

            <!-- ==========================
                 PURCHASE PRICE
            =========================== -->

            <h3 class="section-title">

                Purchase Price

            </h3>

            <div class="inventory-form-grid">

                <div>

                    <label>
                        Purchase CDF
                    </label>

                    <input
                        type="number"
                        id="edit_purchase_cdf"
                    >

                </div>

                <div>

                    <label>
                        Purchase USD
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="purchase_price"
                        id="edit_purchase"
                    >

                </div>

            </div>

            <!-- ==========================
                 SELLING PRICE
            =========================== -->

            <h3 class="section-title">

                Selling Price

            </h3>

            <div class="inventory-form-grid">

                <div>

                    <label>
                        Selling CDF
                    </label>

                    <input
                        type="number"
                        id="edit_selling_cdf"
                    >

                </div>

                <div>

                    <label>
                        Selling USD
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="selling_price"
                        id="edit_selling"
                    >

                </div>

            </div>

            <div
                class="inventory-modal-actions"
            >

                <button
                    type="submit"
                    class="inventory-save-btn"
                >

                    Save Changes

                </button>

                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="inventory-cancel-btn"
                >

                    Cancel

                </button>

            </div>

        </form>

    </div>

</div>

<script>

const inventorySearch =
    document.getElementById(
        'inventorySearch'
    );

inventorySearch?.addEventListener(
    'input',
    function()
{

    const term =
        this.value
            .toLowerCase()
            .trim();

    document
    .querySelectorAll(
        '.inventory-card'
    )
    .forEach(card => {

        const name =
            card.dataset.name;

        if (
            name.includes(term)
        ) {
            card.style.display =
                '';
        }
        else {
            card.style.display =
                'none';
        }

    });

});

function openEditModal(
    id,
    batch,
    expiry,
    quantity,
    supplier,
    purchase,
    selling
)
{
    document.getElementById(
        'edit_id'
    ).value = id;

    document.getElementById(
        'edit_batch'
    ).value = batch;

    document.getElementById(
        'edit_expiry'
    ).value = expiry;

    document.getElementById(
        'edit_quantity'
    ).value = quantity;

    document.getElementById(
        'edit_supplier'
    ).value = supplier;

    document.getElementById(
        'edit_purchase'
    ).value = purchase;

    document.getElementById(
        'edit_selling'
    ).value = selling;

    document.getElementById(
        'editModal'
    ).classList.remove(
        'hidden'
    );
}

function closeEditModal()
{
    document.getElementById(
        'editModal'
    ).classList.add(
        'hidden'
    );
}

</script>

<?php

$content = ob_get_clean();

$pageTitle = 'Inventory';

include dirname(__DIR__)
    . '/layouts/app.php';
