<?php require __DIR__ . '../../shared/header.php'; ?>
<title>Order Details</title>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Order Details</h1>
        <h3>Foods:</h3>
        <ul>
            <?php foreach ($orderDetails['foods'] as $food): ?>
                <li><?= htmlspecialchars($food['name']) ?> x <?= htmlspecialchars($food['quantity']) ?></li>
            <?php endforeach; ?>
        </ul>

        <h3>Drinks:</h3>
        <ul>
            <?php foreach ($orderDetails['drinks'] as $drink): ?>
                <li><?= htmlspecialchars($drink['name']) ?> x <?= htmlspecialchars($drink['quantity']) ?></li>
            <?php endforeach; ?>
        </ul>

        <a href="/admin/manageorders" class="btn btn-primary mt-3">Back to Orders</a>
    </div>
<?php require __DIR__ . '/../shared/footer.php'; ?>
