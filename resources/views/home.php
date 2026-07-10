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
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            color: #333;
            overflow: hidden; /* prevent scrollbars from rain */
        }
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        /* rain container */
        #rain-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        /* pill shape */
        .pill {
            position: fixed;
            top: -10%;
            border-radius: 50%;
            opacity: 0.7;
            box-shadow: 0 0 6px rgba(0,0,0,0.3);
            animation: fall linear infinite;
        }
        @keyframes fall {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.7;
            }
            100% {
                transform: translateY(110vh) rotate(720deg);
                opacity: 0.2;
            }
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
            position: relative;
            z-index: 1;
        }
        .welcome {
            background: #fff;
            padding: 3rem 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1), 0 0 30px rgba(255,255,255,0.4);
            text-align: center;
            max-width: 480px;
            width: 100%;
            border: 1px solid rgba(255,255,255,0.3);
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
    <div id="rain-container"></div>

    <div class="container">
        <div class="welcome">
            <h1>MALKEL PHARMA ERP</h1>
            <p>Your comprehensive pharmacy management system. Manage inventory, sales, purchases, and more with ease.</p>
            <a href="/dashboard" class="btn-dashboard">Go to Dashboard</a>
        </div>
    </div>

    <script>
        (function() {
            const container = document.getElementById('rain-container');
            const count = 30;
            for (let i = 0; i < count; i++) {
                const pill = document.createElement('span');
                pill.className = 'pill';
                const size = Math.random() * 20 + 10; // 10‑30px
                pill.style.width = size + 'px';
                pill.style.height = (size * 0.4) + 'px';
                pill.style.left = Math.random() * 100 + '%';
                pill.style.animationDuration = (Math.random() * 3 + 2) + 's'; // 2‑5s
                pill.style.animationDelay = Math.random() * 5 + 's';
                const hue = Math.random() * 360;
                pill.style.background = `linear-gradient(90deg, hsl(${hue}, 70%, 50%), hsl(${hue + 30}, 70%, 50%))`;
                container.appendChild(pill);
            }
        })();
    </script>
</body>
</html>
