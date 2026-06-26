<?php ob_start();

// Ensure $product is defined to avoid "Undefined variable" notices
$product = $product ?? [];
$categories = $categories ?? [];
$dosageForms = $dosageForms ?? [];
$packagingUnits = $packagingUnits ?? [];
?>

<div class="max-w-6xl mx-auto">

    <div class="glass rounded-3xl p-8 border border-slate-800">

        <div class="mb-8">
            <h3 class="text-3xl font-bold">
                Modifier Produit
            </h3>

            <p class="text-slate-400 mt-2">
                Modifiez les informations du produit pharmaceutique.
            </p>
        </div>

        <form method="POST" action="/products/update">

            <input
                type="hidden"
                name="id"
                value="<?= htmlspecialchars($product['id'] ?? '') ?>"
            >

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
                        value="<?= htmlspecialchars($product['name'] ?? '') ?>"
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
                        value="<?= htmlspecialchars($product['barcode'] ?? '') ?>"
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
                        value="<?= htmlspecialchars($product['sku'] ?? '') ?>"
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
                        value="<?= htmlspecialchars($product['strength'] ?? '') ?>"
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

                        <?php foreach ($categories as $category): ?>

                            <option value="<?= $category['id'] ?>"
                                <?= (($product['category_id'] ?? '') == $category['id']) ? 'selected' : '' ?>
                            >
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

                        <?php foreach ($dosageForms as $form): ?>

                            <option value="<?= $form['id'] ?>"
                                <?= (($product['dosage_form_id'] ?? '') == $form['id']) ? 'selected' : '' ?>
                            >
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

                        <?php foreach ($packagingUnits as $unit): ?>

                            <option value="<?= $unit['id'] ?>"
                                <?= (($product['packaging_unit_id'] ?? '') == $unit['id']) ? 'selected' : '' ?>
                            >
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
                        value="<?= htmlspecialchars($product['purchase_price'] ?? 0) ?>"
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
                        value="<?= htmlspecialchars($product['selling_price'] ?? 0) ?>"
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
                        value="<?= htmlspecialchars($product['minimum_stock_level'] ?? 0) ?>"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                </div>

                <!-- Type de produit -->
                <div>
                    <label class="block mb-2 font-medium">
                        Type de produit
                    </label>

                    <select
                        name="product_type"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                        <option value="generic"
                            <?= (($product['product_type'] ?? 'generic') === 'generic') ? 'selected' : '' ?>
                        >
                            Générique
                        </option>
                        <option value="brand"
                            <?= (($product['product_type'] ?? '') === 'brand') ? 'selected' : '' ?>
                        >
                            Marque
                        </option>
                    </select>
                </div>

                <!-- Principe actif -->
                <div>
                    <label class="block mb-2 font-medium">
                        Principe actif
                    </label>

                    <input
                        type="text"
                        name="active_ingredient"
                        value="<?= htmlspecialchars($product['active_ingredient'] ?? '') ?>"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                </div>

                <!-- Fabricant -->
                <div>
                    <label class="block mb-2 font-medium">
                        Fabricant
                    </label>

                    <input
                        type="text"
                        name="manufacturer"
                        value="<?= htmlspecialchars($product['manufacturer'] ?? '') ?>"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                </div>

                <!-- Classe thérapeutique -->
                <div>
                    <label class="block mb-2 font-medium">
                        Classe thérapeutique
                    </label>

                    <input
                        type="text"
                        name="therapeutic_class"
                        value="<?= htmlspecialchars($product['therapeutic_class'] ?? '') ?>"
                        class="w-full p-4 rounded-xl bg-slate-900 border border-slate-700"
                    >
                </div>

                <!-- Température de stockage -->
                <div>
                    <label class="block mb-2 font-medium">
                        Température de stockage
                    </label>

                    <input
                        type="text"
                        name="storage_temperature"
                        placeholder="2°C - 8°C"
                        value="<?= htmlspecialchars($product['storage_temperature'] ?? '') ?>"
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
                ><?= htmlspecialchars($product['description'] ?? '') ?></textarea>

            </div>

            <!-- Checkboxes -->
            <div class="mt-8 flex flex-wrap gap-6">

                <label class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="prescription_required"
                        value="1"
                        <?= ($product['prescription_required'] ?? 0) ? 'checked' : '' ?>
                    >
                    Prescription requise
                </label>

                <label class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="is_temperature_sensitive"
                        value="1"
                        <?= ($product['is_temperature_sensitive'] ?? 0) ? 'checked' : '' ?>
                    >
                    Sensible à la température
                </label>

                <label class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="is_controlled_substance"
                        value="1"
                        <?= ($product['is_controlled_substance'] ?? 0) ? 'checked' : '' ?>
                    >
                    Substance contrôlée
                </label>

            </div>

            <!-- Submit -->
            <div class="mt-10">

                <button
                    type="submit"
                    class="px-8 py-4 bg-blue-600 hover:bg-blue-500 rounded-2xl font-bold"
                >
                    Enregistrer les modifications
                </button>

            </div>

        </form>

    </div>

</div>

<?php

$content = ob_get_clean();

$pageTitle = 'Modifier Produit';

include __DIR__ . '/../layouts/app.php';
