<?php ob_start(); ?>

<div class="flex justify-between items-center mb-6">

    <div>

        <h2 class="text-2xl font-bold">
            Purchase Management
        </h2>

        <p class="text-slate-400">
            Historique des achats et réceptions fournisseurs
        </p>

    </div>

    <a
        href="/purchases/create"
        class="px-6 py-3 bg-blue-600 hover:bg-blue-500 rounded-2xl font-bold"
    >
        Nouvel Achat
    </a>

</div>

<?php if (empty($purchases ?? [])): ?>

<div class="glass rounded-3xl p-12 text-center">

    <i class="fa-solid fa-truck text-5xl text-slate-500 mb-4"></i>

    <h3 class="text-xl font-bold mb-2">
        Aucun achat enregistré
    </h3>

    <p class="text-slate-400 mb-6">
        Commencez par créer votre premier bon de commande.
    </p>

    <a
        href="/purchases/create"
        class="px-6 py-3 bg-blue-600 hover:bg-blue-500 rounded-2xl font-bold"
    >
        Créer un achat
    </a>

</div>

<?php else: ?>

<div class="glass rounded-3xl overflow-hidden">

    <table class="w-full">

        <thead class="bg-slate-900">

            <tr>

                <th class="p-4 text-left">
                    N° Commande
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

            <?php foreach ($purchases as $purchase): ?>

                <tr class="border-t border-slate-800">

                    <td class="p-4">

                        <strong>
                            <?= htmlspecialchars(
                                $purchase['purchase_number']
                                ?? '-'
                            ) ?>
                        </strong>

                    </td>

                    <td class="p-4">

                        <?= htmlspecialchars(
                            $purchase['company_name']
                            ?? '-'
                        ) ?>

                    </td>

                    <td class="p-4">

                        $

                        <?= number_format(
                            (float) ($purchase['total'] ?? 0),
                            2
                        ) ?>

                    </td>

                    <td class="p-4">

                        <?php
                        $status =
                            $purchase['payment_status']
                            ?? 'pending';
                        ?>

                        <?php if ($status === 'paid'): ?>

                            <span class="text-green-500">
                                Payé
                            </span>

                        <?php elseif ($status === 'pending'): ?>

                            <span class="text-yellow-500">
                                En attente
                            </span>

                        <?php else: ?>

                            <span class="text-red-500">
                                <?= htmlspecialchars($status) ?>
                            </span>

                        <?php endif; ?>

                    </td>

                    <td class="p-4">

                        <?= htmlspecialchars(
                            $purchase['created_at']
                            ?? '-'
                        ) ?>

                    </td>

                    <td class="p-4">

                        <?php if (($purchase['order_status'] ?? '') !== 'cancelled'): ?>

                            <button
                                onclick="cancelPurchase(<?= $purchase['id'] ?>)"
                                class="text-red-500 hover:text-red-400"
                            >
                                Annuler
                            </button>

                        <?php else: ?>

                            <span class="text-slate-500">
                                Annulé
                            </span>

                        <?php endif; ?>

                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>

<?php endif; ?>

<script>

async function cancelPurchase(id) {
    if (!confirm('Êtes-vous sûr de vouloir annuler cet achat ? Cette action est irréversible.')) {
        return;
    }

    try {
        const response = await fetch('/purchases/cancel', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        });

        const data = await response.json();

        if (data.success) {
            alert('Achat annulé avec succès');
            location.reload();
        } else {
            alert('Erreur lors de l\'annulation : ' + (data.message || 'Erreur inconnue'));
        }
    } catch (error) {
        alert('Erreur réseau');
    }
}

</script>

<?php

$content = ob_get_clean();

$pageTitle = 'Purchases';

include dirname(__DIR__)
    . '/layouts/app.php';
