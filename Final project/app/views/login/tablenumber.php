<?php require __DIR__ . '/../shared/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Table Number</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Set Your Table Number</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/login/setTablenumber">
            <div class="form-group">
                <label for="table_number">Table Number</label>
                <input type="number" name="table_number" id="table_number" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
<?php require __DIR__ . '/../shared/footer.php'; ?>
