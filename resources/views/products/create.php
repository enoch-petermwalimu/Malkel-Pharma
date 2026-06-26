<?php ob_start(); ?>

<div class="max-w-6xl mx-auto">

    <div class="glass rounded-3xl p-8 border border-slate-800">

        <div class="mb-8">
            <h3 class="text-3xl font-bold">
                Ajouter un produit
            </h3>

            <p class="text-slate-400 mt-2">
                Créez un nouveau produit pharmaceutique.
            </p>
        </div>

        <form method="POST" action="/products/store">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Nom -->
                <div>
                    <label class="block mb-2 font-medium">
                        Nom du produit *
                    </label>

                    <input
                        type="text"
                        name="name"
                        required
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                </div>

                <!-- Barcode -->
                <div>
                    <label class="block mb-2 font-medium">
                        Code barre
                    </label>

                    <input
                        type="text"
                        name="barcode"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                </div>

                <!-- SKU -->
                <div>
                    <label class="block mb-2 font-medium">
                        SKU / Référence
                    </label>

                    <input
                        type="text"
                        name="sku"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                </div>

                <!-- Dosage -->
                <div>
                    <label class="block mb-2 font-medium">
                        Dosage
                    </label>

                    <input
                        type="text"
                        name="strength"
                        placeholder="500 mg"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                </div>

                <!-- Catégorie -->
                <div>
                    <label class="block mb-2 font-medium">
                        Catégorie
                    </label>

                    <select
                        name="category_id"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                        <option value="">
                            Sélectionner
                        </option>

                        <?php foreach (($categories ?? []) as $category): ?>

                            <option value="<?= $category['id'] ?>">
                                <?= htmlspecialchars($category['name']) ?>
                            </option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Forme -->
                <div>
                    <label class="block mb-2 font-medium">
                        Forme pharmaceutique
                    </label>

                    <select
                        name="dosage_form_id"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                        <option value="">
                            Sélectionner
                        </option>

                        <?php foreach (($dosageForms ?? []) as $form): ?>

                            <option value="<?= $form['id'] ?>">
                                <?= htmlspecialchars($form['name']) ?>
                            </option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Conditionnement -->
                <div>
                    <label class="block mb-2 font-medium">
                        Conditionnement
                    </label>

                    <select
                        name="packaging_unit_id"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                        <option value="">
                            Sélectionner
                        </option>

                        <?php foreach (($packagingUnits ?? []) as $unit): ?>

                            <option value="<?= $unit['id'] ?>">
                                <?= htmlspecialchars($unit['name']) ?>
                            </option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Prix achat -->
                <div>
                    <label class="block mb-2 font-medium">
                        Prix d'achat
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="purchase_price"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                </div>

                <!-- Prix vente -->
                <div>
                    <label class="block mb-2 font-medium">
                        Prix de vente
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="price"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                </div>

                <!-- Stock -->
                <div>
                    <label class="block mb-2 font-medium">
                        Stock initial
                    </label>

                    <input
                        type="number"
                        name="stock_quantity"
                        value="0"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                </div>

                <!-- Stock minimum -->
                <div>
                    <label class="block mb-2 font-medium">
                        Stock minimum
                    </label>

                    <input
                        type="number"
                        name="minimum_stock_level"
                        value="5"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                </div>

                <!-- Lot -->
                <div>
                    <label class="block mb-2 font-medium">
                        Numéro de lot
                    </label>

                    <input
                        type="text"
                        name="batch_number"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                </div>

                <!-- Expiration -->
                <div>
                    <label class="block mb-2 font-medium">
                        Date d'expiration
                    </label>

                    <input
                        type="date"
                        name="expiry_date"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                </div>

            </div>

            <!-- Description -->
            <div class="mt-6">

                <label class="block mb-2 font-medium">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                ></textarea>

            </div>

            <!-- Checkboxes -->
            <div class="mt-8 flex flex-wrap gap-6">

                <label class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="prescription_required"
                        value="1"
                    >
                    Prescription requise
                </label>

                <label class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="is_temperature_sensitive"
                        value="1"
                    >
                    Sensible à la température
                </label>

            </div>

            <!-- Température -->
            <div class="mt-6">

                <label class="block mb-2 font-medium">
                    Température de stockage
                </label>

                <input
                    type="text"
                    name="storage_temperature"
                    placeholder="2°C - 8°C"
                    class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                >

            </div>

            <!-- Submit -->
            <div class="mt-10">

                <button
                    type="submit"
                    class="px-8 py-4 bg-blue-600 hover:bg-blue-500 rounded-2xl font-bold"
                >
                    Enregistrer le produit
                </button>

            </div>

        </form>

    </div>

</div>

<?php
$content = ob_get_clean();

$pageTitle = 'Ajouter un produit';

include dirname(__DIR__) . '/layouts/app.php';