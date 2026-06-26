<?php ob_start(); ?>

<div class="card">

    <h1>
        System Information
    </h1>

    <p>

        Version :

        <?= $version['version'] ?>

    </p>

    <p>

        Build :

        <?= $version['build'] ?>

    </p>

    <p>

        Status :

        <?= $version['status'] ?>

    </p>

</div>

<?php

$content =
    ob_get_clean();

include
    dirname(__DIR__)
    . '/layouts/app.php';