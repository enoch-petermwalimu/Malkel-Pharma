<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h1>MARKEL PHARMA LOGIN</h1>

<?php if (!empty($error)): ?>
    <p><?= $error ?></p>
<?php endif; ?>

<form method="POST" action="/login">
    <input
        type="email"
        name="email"
        placeholder="Email"
        required
    >

    <input
        type="password"
        name="password"
        placeholder="Password"
        required
    >

    <button type="submit">
        Login
    </button>
</form>

</body>
</html>