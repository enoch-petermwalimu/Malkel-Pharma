<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories</title>
</head>
<body>

<h1>Pharma Categories</h1>

<form method="POST" action="/categories/store">
    <input
        type="text"
        name="name"
        placeholder="Category name"
        required
    >

    <textarea
        name="description"
        placeholder="Description"
    ></textarea>

    <button type="submit">
        Save
    </button>
</form>

<hr>

<?php foreach ($categories as $category): ?>
    <p><?= htmlspecialchars($category['name']) ?></p>
<?php endforeach; ?>

</body>
</html>