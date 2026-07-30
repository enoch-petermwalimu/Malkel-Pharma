<?php

use App\Core\Database;

/* =====================================================
   SETTINGS
===================================================== */

$settings = [];

try {

    $db = Database::connect();

    $stmt = $db->query(
        "SELECT setting_key, setting_value
         FROM settings"
    );

    foreach (
        $stmt->fetchAll()
        as $row
    ) {

        $settings[
            $row['setting_key']
        ] = $row['setting_value'];
    }

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

$logo =
'/assets/images/logo.png';

$logoIcon =
'/assets/images/logo-icon.svg';
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

<!--  AJOUT : Liaison avec le fichier manifest.json pour Microsoft Edge -->
<link rel="manifest" href="/manifest.json">

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
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

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
<i class="fa-solid fa-chart-line"></i>
<span class="nav-text">Dashboard</span>
</a>

<a
href="/pos"
class="<?= str_starts_with($currentRoute,'/pos') ? 'active' : '' ?>"
>
<i class="fa-solid fa-cash-register"></i>
<span class="nav-text">POS</span>
</a>

<a
href="/sales/history"
class="<?= str_starts_with($currentRoute,'/sales') ? 'active' : '' ?>"
>
<i class="fa-solid fa-receipt"></i>
<span class="nav-text">Sales</span>
</a>

<a
href="/products"
class="<?= str_starts_with($currentRoute,'/products') ? 'active' : '' ?>"
>
<i class="fa-solid fa-capsules"></i>
<span class="nav-text">Products</span>
</a>

<a
href="/customers"
class="<?= str_starts_with($currentRoute,'/customers') ? 'active' : '' ?>"
>
<i class="fa-solid fa-users"></i>
<span class="nav-text">Customers</span>
</a>

<a
href="/inventory"
class="<?= str_starts_with($currentRoute,'/inventory') ? 'active' : '' ?>"
>
<i class="fa-solid fa-boxes-stacked"></i>
<span class="nav-text">Inventory</span>
</a>

<a
href="/suppliers"
class="<?= str_starts_with($currentRoute,'/suppliers') ? 'active' : '' ?>"
>
<i class="fa-solid fa-truck"></i>
<span class="nav-text">Suppliers</span>
</a>

<a
href="/returns"
class="<?= str_starts_with($currentRoute,'/returns') ? 'active' : '' ?>"
>
<i class="fa-solid fa-rotate-left"></i>
<span class="nav-text">Returns</span>
</a>

<a
href="/reports"
class="<?= str_starts_with($currentRoute,'/reports') ? 'active' : '' ?>"
>
<i class="fa-solid fa-chart-column"></i>
<span class="nav-text">Reports</span>
</a>

<a
href="/settings"
class="<?= str_starts_with($currentRoute,'/settings') ? 'active' : '' ?>"
>
<i class="fa-solid fa-gear"></i>
<span class="nav-text">Settings</span>
</a>

<a 
href="/system"
class="<?= str_starts_with($currentRoute,'/system') ? 'active' : '' ?>"
>
<i class="fas fa-server"></i>
<span class="nav-text">Système</span>
</a>

<a href="/logout">

<i class="fa-solid fa-right-from-bracket"></i>

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

<i class="fa-solid fa-bars"></i>

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

<!--  AJOUT : Script d'enregistrement du Service Worker pour la gestion Hors-ligne -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then(reg => console.log('MALKEL ERP : Service Worker actif !'))
                .catch(err => console.log('MALKEL ERP : Erreur de Service Worker :', err));
        });
    }
</script>

</body>

</html>
