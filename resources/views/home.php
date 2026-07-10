<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MALKEL PHARMA ERP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            color: #333;
        }
        nav {
            background: #2c3e50;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav .logo {
            color: #ecf0f1;
            font-size: 1.5rem;
            font-weight: bold;
        }
        nav ul {
            list-style: none;
            display: flex;
            gap: 1.5rem;
        }
        nav ul li a {
            color: #ecf0f1;
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.3s;
        }
        nav ul li a:hover {
            color: #3498db;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .welcome {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .welcome h1 {
            margin-bottom: 1rem;
            color: #2c3e50;
        }
        .welcome p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555;
        }
    </style>
</head>
<body>

    <nav>
        <div class="logo">MALKEL PHARMA ERP</div>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Inventory</a></li>
            <li><a href="#">Sales</a></li>
            <li><a href="#">Purchases</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="welcome">
            <h1>Welcome to MALKEL PHARMA ERP</h1>
            <p>Your comprehensive pharmacy management system. Manage inventory, sales, purchases, and more with ease.</p>
        </div>
    </div>

</body>
</html>
