<?php ob_start(); ?>

<div class="max-w-6xl mx-auto">

    <div class="card mb-6">

        <h1 style="font-size:28px;font-weight:800;">
            Paramètres
        </h1>

        <p style="color:#94a3b8;margin-top:10px;">
            Configurez votre pharmacie, votre devise et l'apparence de la plateforme.
        </p>

    </div>

   <form
    method="POST"
    action="/settings/update"
    enctype="multipart/form-data"
   >
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Informations pharmacie -->

            <div class="card">

                <div class="section-title">
                    Informations Pharmacie
                </div>

                <div class="mb-4">

                    <label>
                        Nom de la pharmacie
                    </label>

                    <input
                        type="text"
                        name="pharmacy_name"
                        value="<?= htmlspecialchars($settings['pharmacy_name'] ?? '') ?>"
                    >

                </div>

                <div class="mb-4">

                    <label>
                        Téléphone
                    </label>

                    <input
                        type="text"
                        name="phone"
                        value="<?= htmlspecialchars($settings['phone'] ?? '') ?>"
                    >

                </div>

                <div class="mb-4">

                    <label>
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="<?= htmlspecialchars($settings['email'] ?? '') ?>"
                    >

                </div>

                <div>

                    <label>
                        Adresse
                    </label>

                    <textarea
                        rows="4"
                        name="address"
                    ><?= htmlspecialchars($settings['address'] ?? '') ?></textarea>

                </div>

            </div>

            <!-- Monnaie -->

            <div class="card">

                <div class="section-title">
                    Monnaie & Taux
                </div>

                <div class="mb-4">

                    <label>
                        Devise principale
                    </label>

                    <select name="primary_currency">

                        <option
                            value="USD"
                            <?= (($settings['primary_currency'] ?? '') === 'USD') ? 'selected' : '' ?>
                        >
                            USD
                        </option>

                        <option
                            value="CDF"
                            <?= (($settings['primary_currency'] ?? '') === 'CDF') ? 'selected' : '' ?>
                        >
                            CDF
                        </option>

                    </select>

                </div>

                <div class="mb-4">

                    <label>
                        Taux USD / CDF
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="exchange_rate"
                        value="<?= htmlspecialchars($settings['exchange_rate'] ?? '3000') ?>"
                    >

                </div>

                <div class="card" style="background:#0f172a;margin-top:20px;">

                    <strong>
                        Exemple
                    </strong>

                    <p style="color:#94a3b8;margin-top:10px;">
                        1 USD = <?= htmlspecialchars($settings['exchange_rate'] ?? '3000') ?> CDF
                    </p>

                </div>

            </div>

        </div>

        <!-- Facturation -->

        <div class="card mt-6">

            <div class="section-title">
                Facturation
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="mb-4">

                    <label>
                        Préfixe de facture
                    </label>

                    <input
                        type="text"
                        name="invoice_prefix"
                        value="<?= htmlspecialchars($settings['invoice_prefix'] ?? 'INV-') ?>"
                    >

                </div>

                <div class="mb-4">

                    <label>
                        Taux de taxe (%)
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="tax_rate"
                        value="<?= htmlspecialchars($settings['tax_rate'] ?? '0') ?>"
                    >

                </div>

                <div class="mb-4">

                    <label>
                        TVA (%)
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="vat_rate"
                        value="<?= htmlspecialchars($settings['vat_rate'] ?? '0') ?>"
                    >

                </div>

                <div class="mb-4">

                    <label>
                        Pied de reçu
                    </label>

                    <input
                        type="text"
                        name="receipt_footer"
                        value="<?= htmlspecialchars($settings['receipt_footer'] ?? 'Thank you for your purchase!') ?>"
                    >

                </div>

            </div>

        </div>

        <!-- Apparence -->

        <div class="card mt-6">

            <div class="section-title">
                Apparence
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>

                    <label>
                        Palette de couleurs
                    </label>

                    <select name="theme_name">

                        <option value="medical-blue">
                            Medical Blue
                        </option>

                        <option value="emerald">
                            Emerald
                        </option>

                        <option value="graphite">
                            Graphite
                        </option>

                        <option value="royal-purple">
                            Royal Purple
                        </option>

                        <option value="midnight">
                            Midnight
                        </option>

                    </select>

                </div>

            </div>

            <div class="card mt-6">

            <div class="section-title">
                Logo de la pharmacie
            </div>

            <input
                type="file"
                name="pharmacy_logo"
                accept="image/*">

            </div>

        </div>

        <!-- Boutons -->

        <div
            style="
                margin-top:30px;
                display:flex;
                justify-content:flex-end;
            "
        >

            <button
                type="submit"
                class="save-btn"
            >
                Enregistrer les paramètres
            </button>

        </div>


        
    </form>

</div>

<?php

$content = ob_get_clean();

$pageTitle = 'Settings';

include dirname(__DIR__) . '/layouts/app.php';
