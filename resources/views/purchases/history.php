<?php ob_start(); ?>

<div class="flex justify-between items-center mb-6">

    <div>

        <h2 class="text-2xl font-bold">
            Purchase History
        </h2>

        <p class="text-slate-400">
            Historique des achats
        </p>

    </div>

</div>

<div
    class="glass rounded-3xl overflow-hidden border border-slate-800"
>

    <table class="w-full">

        <thead class="bg-slate-900">

            <tr>

                <th class="p-4 text-left">
                    N° Achat
                </th>

                <th class="p-4 text-left">
                    Fournisseur
                </th>

                <th class="p-4 text-left">
                    Total
                </th>

                <th class="p-4 text-left">
                    Statut
                </th>

                <th class="p-4 text-left">
                    Date
                </th>

                <th class="p-4 text-left">
                    Actions
                </th>

            </tr>

        </thead>

        <tbody>

        <?php foreach(
            ($purchases ?? [])
            as $purchase
        ): ?>

            <tr
                class="border-t border-slate-800"
            >

                <td class="p-4">
                    <?= htmlspecialchars(
                        $purchase['purchase_number']
                    ) ?>
                </td>

                <td class="p-4">
                    <?= htmlspecialchars(
                        $purchase['company_name']
                        ?? 'N/A'
                    ) ?>
                </td>

                <td class="p-4">
                    <?= number_format(
                        $purchase['total'],
                        2
                    ) ?>
                </td>

                <td class="p-4">

                    <span
                        class="px-2 py-1 rounded-lg bg-green-600"
                    >
                        <?= htmlspecialchars(
                            $purchase['payment_status']
                        ) ?>
                    </span>

                </td>

                <td class="p-4">
                    <?= htmlspecialchars(
                        $purchase['created_at']
                    ) ?>
                </td>

                <td class="p-4">

                    <button
                        class="btn"
                    >
                        Voir
                    </button>

                </td>

            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

</div>

<?php

$content =
    ob_get_clean();

$pageTitle =
    'Purchase History';

include dirname(__DIR__)
    . '/layouts/app.php';