<?php ob_start(); ?>

<div class="flex justify-between items-center mb-6">

    <div>

        <h2 class="text-2xl font-bold">
            Suppliers
        </h2>

        <p class="text-slate-400">
            Gestion des fournisseurs
        </p>

        <div class="mt-4">

            <input
                type="text"
                id="supplierFilter"
                placeholder="Rechercher un fournisseur..."
            >

        </div>

    </div>

    <button
        onclick="openCreateModal()"
        class="btn"
    >
        <i class="bi bi-plus-lg"></i>
        Ajouter Fournisseur
    </button>

</div>

<?php if(empty($suppliers)): ?>

<div class="card text-center">

    <i
        class="fa-solid fa-truck text-5xl text-slate-500 mb-4"
    ></i>

    <h3 class="text-xl font-bold mb-2">
        Aucun fournisseur enregistré
    </h3>

    <p class="text-slate-400 mb-4">
        Commencez par ajouter votre premier fournisseur.
    </p>

    <button
        onclick="openCreateModal()"
        class="btn"
    >
        <i class="fa-solid fa-plus"></i>
        Ajouter Fournisseur
    </button>

</div>

<?php endif; ?>

<div class="grid md:grid-cols-2 gap-6">

<?php foreach($suppliers as $supplier): ?>

<div class="card">

    <div class="flex justify-between items-start">

        <div>

            <h3 class="font-bold text-lg flex items-center gap-2">

                <i
                    class="fa-solid fa-truck text-blue-500"
                ></i>

                <?= htmlspecialchars(
                    $supplier['company_name']
                ) ?>

            </h3>

            <p class="text-slate-400">
                <?= htmlspecialchars(
                    $supplier['contact_name']
                    ?? '-'
                ) ?>
            </p>

        </div>

        <div class="flex gap-2">

            <button
                class="btn"
                onclick='openEditModal(
                    <?= json_encode($supplier) ?>
                )'
            >
                <i class="bi bi-pencil"></i>
                Modifier
            </button>

            <button
                class="btn"
                onclick="deleteSupplier(
                    <?= $supplier['id'] ?>
                )"
            >
                <i class="bi bi-trash"></i>
                Supprimer
            </button>

        </div>
    </div>

    <div class="mt-4 space-y-3">

        <p class="flex items-center gap-2">

            <i
                class="fa-solid fa-phone text-blue-400"
            ></i>

            <?= htmlspecialchars(
                $supplier['phone']
                ?? '-'
            ) ?>

        </p>

        <p class="flex items-center gap-2">

            <i
                class="fa-solid fa-envelope text-green-400"
            ></i>

            <?= htmlspecialchars(
                $supplier['email']
                ?? '-'
            ) ?>

        </p>

        <p class="flex items-center gap-2">

            <i
                class="fa-solid fa-location-dot text-red-400"
            ></i>

            <?= htmlspecialchars(
                $supplier['address']
                ?? '-'
            ) ?>

        </p>

    </div>

</div>

<?php endforeach; ?>

</div>

<!-- CREATE MODAL -->

<div
    id="createModal"
    class="fixed inset-0 hidden items-center justify-center bg-black/70 z-50"
>

    <div class="card w-full max-w-2xl">

        <h3 class="text-xl font-bold mb-4">

            <i class="fa-solid fa-plus"></i>

            Ajouter Fournisseur

        </h3>

        <form
            id="createSupplierForm"
            onsubmit="createSupplier(event)"
        >

            <label>Société</label>

            <input
                type="text"
                name="company_name"
                required
            >

            <label>Contact</label>

            <input
                type="text"
                name="contact_name"
            >

            <label>Téléphone</label>

            <input
                type="text"
                name="phone"
            >

            <label>Email</label>

            <input
                type="email"
                name="email"
            >

            <label>Adresse</label>

            <textarea
                name="address"
            ></textarea>

            <label>Notes</label>

            <textarea
                name="notes"
            ></textarea>

            <div class="flex gap-3 mt-5">

                <button
                    type="button"
                    onclick="closeCreateModal()"
                    class="btn"
                >
                    Annuler
                </button>

                <button
                    type="submit"
                    class="btn"
                >
                    Enregistrer
                </button>

            </div>

        </form>

    </div>

</div>

<!-- EDIT MODAL -->

<div
    id="editModal"
    class="fixed inset-0 hidden items-center justify-center bg-black/70 z-50"
>

    <div class="card w-full max-w-2xl">

        <h3 class="text-xl font-bold mb-4">

            <i class="fa-solid fa-pen"></i>

            Modifier Fournisseur

        </h3>

        <form
            id="editSupplierForm"  onsubmit="updateSupplier(event)">

            <input
                type="hidden"
                name="id"
                id="edit_id"
            >

            <label>Société</label>

            <input
                type="text"
                name="company_name"
                id="edit_company_name"
            >

            <label>Contact</label>

            <input
                type="text"
                name="contact_name"
                id="edit_contact_name"
            >

            <label>Téléphone</label>

            <input
                type="text"
                name="phone"
                id="edit_phone"
            >

            <label>Email</label>

            <input
                type="email"
                name="email"
                id="edit_email"
            >

            <label>Adresse</label>

            <textarea
                name="address"
                id="edit_address"
            ></textarea>

            <label>Notes</label>

            <textarea
                name="notes"
                id="edit_notes"
            ></textarea>

            <div class="flex gap-3 mt-5">

                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="btn"
                >
                    Annuler
                </button>

                <button
                    type="submit"
                    class="btn"
                >
                    Sauvegarder
                </button>

            </div>

        </form>

    </div>

</div>

<script>

function openCreateModal()
{
    document
        .getElementById('createModal')
        .classList.remove('hidden');

    document
        .getElementById('createModal')
        .classList.add('flex');
}

function closeCreateModal()
{
    document
        .getElementById('createModal')
        .classList.add('hidden');
}

function openEditModal(supplier)
{
    document.getElementById('edit_id').value =
        supplier.id;

    document.getElementById(
        'edit_company_name'
    ).value =
        supplier.company_name ?? '';

    document.getElementById(
        'edit_contact_name'
    ).value =
        supplier.contact_name ?? '';

    document.getElementById(
        'edit_phone'
    ).value =
        supplier.phone ?? '';

    document.getElementById(
        'edit_email'
    ).value =
        supplier.email ?? '';

    document.getElementById(
        'edit_address'
    ).value =
        supplier.address ?? '';

    document.getElementById(
        'edit_notes'
    ).value =
        supplier.notes ?? '';

    document
        .getElementById('editModal')
        .classList.remove('hidden');

    document
        .getElementById('editModal')
        .classList.add('flex');
}

function closeEditModal()
{
    document
        .getElementById('editModal')
        .classList.add('hidden');
}

async function createSupplier(event)
{
    event.preventDefault();

    const form =
        document.getElementById(
            'createSupplierForm'
        );

    const formData =
        new FormData(form);

    const response =
        await fetch(
            '/suppliers/store',
            {
                method: 'POST',
                body: formData
            }
        );

    const result =
        await response.json();

    if(result.success)
    {
        location.reload();
    }
    else
    {
        alert(
            'Erreur création fournisseur'
        );
    }
}

async function updateSupplier(event)
{
    event.preventDefault();

    const form =
        document.getElementById(
            'editSupplierForm'
        );

    const formData =
        new FormData(form);

    const response =
        await fetch(
            '/suppliers/update',
            {
                method: 'POST',
                body: formData
            }
        );

    const result =
        await response.json();

    if(result.success)
    {
        location.reload();
    }
    else
    {
        alert(
            'Erreur modification fournisseur'
        );
    }
}

async function deleteSupplier(id)
{
    const confirmed =
        confirm(
            'Supprimer ce fournisseur ?'
        );

    if(!confirmed)
    {
        return;
    }

    const formData =
        new FormData();

    formData.append(
        'id',
        id
    );

    const response =
        await fetch(
            '/suppliers/delete',
            {
                method:'POST',
                body:formData
            }
        );

    const result =
        await response.json();

    if(result.success)
    {
        location.reload();
    }
    else
    {
        alert(
            'Erreur suppression'
        );
    }
}

const supplierFilter =
    document.getElementById(
        'supplierFilter'
    );

if(supplierFilter)
{
    supplierFilter
    .addEventListener(
        'keyup',
        function()
        {
            const search =
                this.value.toLowerCase();

            document
            .querySelectorAll(
                '.card'
            )
            .forEach(card =>
            {
                const name =
                    card.innerText.toLowerCase();

                card.style.display =
                    name.includes(search)
                    ? 'block'
                    : 'none';
            });
        }
    );
}
</script>

<?php

$content = ob_get_clean();

$pageTitle = 'Suppliers';

include dirname(__DIR__)
    . '/layouts/app.php';
