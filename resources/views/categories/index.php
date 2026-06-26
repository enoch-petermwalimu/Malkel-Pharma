<?php ob_start(); ?>

<div class="hero-v2">

    <div>

        <span class="hero-tag">
            Product Categories
        </span>

        <h1>
            Categories
        </h1>

        <p>
            Manage pharmaceutical product categories.
        </p>

    </div>

</div>

<div class="panel-card">

    <div class="panel-title">
        Add Category
    </div>

    <form method="POST" action="/categories/store">

        <div class="form-grid">

            <div>

                <label>
                    Category Name
                </label>

                <input
                    type="text"
                    name="name"
                    required
                >

            </div>

            <div>

                <label>
                    Description
                </label>

                <textarea
                    name="description"
                ></textarea>

            </div>

        </div>

        <button
            type="submit"
            class="btn-primary"
        >
            Save Category
        </button>

    </form>

</div>

<div class="panel-card mt-2">

    <div class="panel-title">
        Categories List
    </div>

    <?php if (!empty($categories)): ?>

        <div class="table-wrapper">

            <table class="malkel-table">

                <thead>

                    <tr>

                        <th>Name</th>

                        <th>Description</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($categories as $category): ?>

                        <tr>

                            <td>

                                <strong>
                                    <?= htmlspecialchars(
                                        $category['name']
                                    ) ?>
                                </strong>

                            </td>

                            <td>

                                <?= htmlspecialchars(
                                    $category['description']
                                    ?? '-'
                                ) ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php else: ?>

        <p class="empty-state">
            No categories created yet.
        </p>

    <?php endif; ?>

</div>

<?php

$content = ob_get_clean();

$pageTitle = 'Categories';

include dirname(__DIR__) . '/layouts/app.php';
