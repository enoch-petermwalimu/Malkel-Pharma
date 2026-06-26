<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'MALKEL PHARMA ERP' ?></title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <style>

        *{
            font-family:'Inter',sans-serif;
        }

        body{
            background:#0f172a;
            color:white;
            margin:0;
        }

        .sidebar{
            position:fixed;
            top:0;
            left:-280px;
            width:280px;
            height:100%;
            background:#111827;
            transition:.3s;
            z-index:1000;
            overflow-y:auto;
            border-right:1px solid #1f2937;
        }

        .sidebar.active{
            left:0;
        }

        .sidebar a{
            display:flex;
            align-items:center;
            gap:12px;
            padding:14px 20px;
            color:white;
            text-decoration:none;
            transition:.2s;
        }

        .sidebar a:hover{
            background:#1e293b;
        }

        .content{
            padding:20px;
        }

        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            background:#111827;
            padding:15px 20px;
            border-radius:16px;
            margin-bottom:20px;
        }

        .card{
            background:#111827;
            border-radius:20px;
            padding:20px;
            border:1px solid #1f2937;
        }

        .menu-btn{
            cursor:pointer;
            font-size:22px;
        }

        .overlay{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,.4);
            display:none;
            z-index:999;
        }

        .overlay.active{
            display:block;
        }

        .logo{
            width:50px;
            height:50px;
            border-radius:50%;
            object-fit:cover;
        }

        .nav-title{
            font-size:11px;
            color:#94a3b8;
            margin:20px;
            text-transform:uppercase;
        }

        .btn{
            background:#2563eb;
            color:white;
            border:none;
            padding:12px 18px;
            border-radius:12px;
            cursor:pointer;
        }

        .btn:hover{
            background:#1d4ed8;

        }

        .hero{
    background:linear-gradient(
        135deg,
        #2563eb,
        #7c3aed
    );

    border-radius:24px;
    padding:30px;
    margin-bottom:20px;
}

.kpi-card{
    background:#111827;
    border:1px solid #1f2937;
    border-radius:20px;
    padding:20px;
    transition:.3s;
}

.kpi-card:hover{
    transform:translateY(-4px);
}

.kpi-number{
    font-size:32px;
    font-weight:800;
}

.quick-btn{
    display:inline-block;
    padding:12px 20px;
    background:white;
    color:black;
    text-decoration:none;
    border-radius:12px;
    margin-right:10px;
    font-weight:600;
}

.card{
    background:#111827;
    border:1px solid #1f2937;
    border-radius:24px;
    padding:24px;
}

input,
select,
textarea{

    width:100%;

    background:#0f172a;

    color:white;

    border:1px solid #334155;

    border-radius:14px;

    padding:14px;

    margin-top:6px;
}

input:focus,
select:focus,
textarea:focus{

    outline:none;

    border-color:#2563eb;
}

label{

    display:block;

    margin-bottom:6px;

    color:#cbd5e1;

    font-size:14px;

    font-weight:600;
}

.section-title{

    font-size:20px;

    font-weight:700;

    margin-bottom:20px;
}

.save-btn{

    background:#2563eb;

    color:white;

    border:none;

    padding:14px 24px;

    border-radius:14px;

    cursor:pointer;

    font-weight:600;
}

.save-btn:hover{

    background:#1d4ed8;
}

    </style>
</head>
<body>

<div id="overlay" class="overlay" onclick="closeSidebar()"></div>

<div id="sidebar" class="sidebar">

    <div style="padding:20px;text-align:center">

        <img
            src="/assets/logo.png"
            class="logo"
            alt="Logo"
        >

        <h2 style="margin-top:10px">
            MALKEL
        </h2>

        <small style="color:#94a3b8">
            Pharma ERP
        </small>

    </div>

    <div class="nav-title">
        Navigation
    </div>

    <a href="/dashboard">
        <i class="fa-solid fa-chart-line"></i>
        Dashboard
    </a>

    <a href="/pos">
        <i class="fa-solid fa-cash-register"></i>
        POS
    </a>

    <a href="/products">
        <i class="fa-solid fa-pills"></i>
        Products
    </a>

    <a href="/customers">
        <i class="fa-solid fa-users"></i>
        Customers
    </a>

    <a href="/inventory">
        <i class="fa-solid fa-boxes-stacked"></i>
        Inventory
    </a>

    <a href="/purchases">
        <i class="fa-solid fa-cart-shopping"></i>
        Purchases
    </a>

    <a href="/returns">
        <i class="fa-solid fa-rotate-left"></i>
        Returns
    </a>

    <a href="/reports">
        <i class="fa-solid fa-chart-column"></i>
        Reports
    </a>

    <a href="/settings">
        <i class="fa-solid fa-gear"></i>
        Settings
    </a>

    <a href="/logout">
        <i class="fa-solid fa-right-from-bracket"></i>
        Logout
    </a>

</div>

<div class="content">

    <div class="topbar">

        <div>

            <span
                class="menu-btn"
                onclick="toggleSidebar()"
            >
                <i class="fa-solid fa-bars"></i>
            </span>

        </div>

        <div>

            <strong>
                <?= $pageTitle ?? 'Dashboard' ?>
            </strong>

        </div>

        <div>

            <img
                src="/assets/user.png"
                class="logo"
                alt="User"
            >

        </div>

    </div>

    <?= $content ?? '' ?>

</div>

<script>

function toggleSidebar(){

    document
        .getElementById('sidebar')
        .classList.toggle('active');

    document
        .getElementById('overlay')
        .classList.toggle('active');
}

function closeSidebar(){

    document
        .getElementById('sidebar')
        .classList.remove('active');

    document
        .getElementById('overlay')
        .classList.remove('active');
}

</script>

</body>
</html>