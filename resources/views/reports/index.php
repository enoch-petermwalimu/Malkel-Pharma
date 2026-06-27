<?php ob_start(); ?>

<h1>Reports Index</h1>
<p>This is the reports index page.</p>

<?php

$content = ob_get_clean();

$pageTitle = $pageTitle ?? 'Reports';

include dirname(__DIR__) . '/layouts/app.php';
