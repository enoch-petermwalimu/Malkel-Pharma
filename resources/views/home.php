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
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
        }
        .welcome {
            background: #fff;
            padding: 3rem 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 480px;
            width: 100%;
        }
        .welcome h1 {
            margin-bottom: 1rem;
            color: #2c3e50;
            font-size: 1.8rem;
        }
        .welcome p {
            font-size: 1rem;
            line-height: 1.6;
            color: #555;
            margin-bottom: 2rem;
        }
        .btn-dashboard {
            display: inline-block;
            background: #2c3e50;
            color: #ecf0f1;
            padding: 0.8rem 2.5rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 600;
            transition: background 0.3s, transform 0.2s;
            border: none;
            cursor: pointer;
        }
        .btn-dashboard:hover {
            background: #3498db;
            transform: translateY(-2px);
        }
        .btn-dashboard:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="welcome">
            <h1>MALKEL PHARMA ERP</h1>
            <p>Your comprehensive pharmacy management system. Manage inventory, sales, purchases, and more with ease.</p>
            <a href="/dashboard" class="btn-dashboard">Go to Dashboard</a>
        </div>
    </div>

</body>
</html>
