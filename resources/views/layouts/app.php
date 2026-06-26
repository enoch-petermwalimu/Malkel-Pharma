<?php

use App\Modules\Settings\Services\SettingsService;

/* =====================================================
   SETTINGS
===================================================== */

$settingsService = new SettingsService();
$settings = [];

try {
    $settings = $settingsService->all();
} catch (\Throwable $e) {
    $settings = [];
}

/* =====================================================
   USER
===================================================== */

$fullName =
$_SESSION['full_name']
?? $_SESSION['user_name']
?? 'Employee';

$userRole =
$_SESSION['role']
?? 'User';

$parts =
explode(
    ' ',
    trim($fullName)
);

$initials = '';

foreach($parts as $part){

    $initials .= strtoupper(
        substr($part,0,1)
    );
}

$initials =
substr(
    $initials,
    0,
    2
);

/* =====================================================
   ROUTE
===================================================== */

$currentRoute =
parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
);

$pageTitle =
$pageTitle
?? 'Dashboard';

/* =====================================================
   LOGO
===================================================== */

$logo = $settings['pharmacy_logo'] ?? '/assets/images/logo.png';
$logoIcon = '/assets/images/logo-icon.svg';
?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
<?= htmlspecialchars($pageTitle) ?>
</title>

<link
rel="preconnect"
href="https://fonts.googleapis.com">

<link
rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link
href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link
rel="stylesheet"
href="/assets/css/app.css">

</head>

<body>

<div
class="sidebar-overlay"
id="sidebarOverlay">
</div>

<div class="floating-pill pill-1"></div>
<div class="floating-pill pill-2"></div>
<div class="floating-pill pill-3"></div>

<div class="layout">

<aside
class="sidebar"
id="sidebar">

<div class="logo-box">

<img
src="<?= $logo ?>"
class="sidebar-logo"
alt="MALKEL">

<div class="logo-title">
MALKEL
</div>

<div class="logo-sub">
PHARMA ERP
</div>

</div>

<nav class="nav">

<a
href="/dashboard"
class="<?= $currentRoute === '/dashboard' ? 'active' : '' ?>"
>
<i class="bi bi-graph-up-arrow"></i>
<span class="nav-text">Dashboard</span>
</a>

<a
href="/pos"
class="<?= str_starts_with($currentRoute,'/pos') ? 'active' : '' ?>"
>
<i class="bi bi-cash-coin"></i>
<span class="nav-text">POS</span>
</a>

<a
href="/sales/history"
class="<?= str_starts_with($currentRoute,'/sales') ? 'active' : '' ?>"
>
<i class="bi bi-receipt"></i>
<span class="nav-text">Sales</span>
</a>

<a
href="/products"
class="<?= str_starts_with($currentRoute,'/products') ? 'active' : '' ?>"
>
<i class="bi bi-capsule"></i>
<span class="nav-text">Products</span>
</a>

<a
href="/customers"
class="<?= str_starts_with($currentRoute,'/customers') ? 'active' : '' ?>"
>
<i class="bi bi-people"></i>
<span class="nav-text">Customers</span>
</a>

<a
href="/inventory"
class="<?= str_starts_with($currentRoute,'/inventory') ? 'active' : '' ?>"
>
<i class="bi bi-boxes"></i>
<span class="nav-text">Inventory</span>
</a>

<a
href="/suppliers"
class="<?= str_starts_with($currentRoute,'/suppliers') ? 'active' : '' ?>"
>
<i class="bi bi-truck"></i>
<span class="nav-text">Suppliers</span>
</a>

<a
href="/returns"
class="<?= str_starts_with($currentRoute,'/returns') ? 'active' : '' ?>"
>
<i class="bi bi-arrow-counterclockwise"></i>
<span class="nav-text">Returns</span>
</a>

<a
href="/reports"
class="<?= str_starts_with($currentRoute,'/reports') ? 'active' : '' ?>"
>
<i class="bi bi-bar-chart-line"></i>
<span class="nav-text">Financial Reports</span>
</a>

<a
href="/settings"
class="<?= str_starts_with($currentRoute,'/settings') ? 'active' : '' ?>"
>
<i class="bi bi-gear"></i>
<span class="nav-text">Settings</span>
</a>

<a 
href="/system">
<i class="bi bi-server"></i>
    Système
</a>

<a href="/logout">

<i class="bi bi-box-arrow-right"></i>

<span class="nav-text">
Logout
</span>

</a>

</nav>

</aside>

<main
class="main"
id="main">

<div class="topbar">

<button
class="btn-secondary"
id="menuToggle">

<i class="bi bi-list"></i>

</button>

<div>

<div class="page-title">
<?= htmlspecialchars($pageTitle) ?>
</div>

<div class="page-subtitle">
Business Intelligence Center
</div>

</div>

<div class="user-box">

<div>

<div class="user-name">
<?= htmlspecialchars($fullName) ?>
</div>

<div class="user-role">
<?= htmlspecialchars($userRole) ?>
</div>

</div>

<div class="user-badge">
<?= htmlspecialchars($initials) ?>
</div>

</div>

</div>

<?= $content ?? '' ?>

</main>

</div>

<script
src="/assets/js/app.js">
</script>

</body>

</html>
