<?php require __DIR__ . '/../shared/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Your Order</h1>

        <!-- Drinks Section -->
        <h3>Drinks</h3>
        <?php if (!empty($drinks)): ?>
            <ul class="list-group">
                <?php foreach ($drinks as $drink): ?>
                    <li class="list-group-item">
                        <div class="d-flex flex-column">
                            <!-- Drink Details -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <?= htmlspecialchars($drink->getName()) ?> 
                                    (<?= $drink->quantity ?> x $<?= number_format($drink->getPrice(), 2) ?>)
                                </div>
                                <span><strong>$<?= number_format($drink->quantity * $drink->getPrice(), 2) ?></strong></span>
                            </div>
                            <!-- Buttons -->
                            <div class="d-flex justify-content-start">
                                <form method="POST" action="/order/updateDrink" class="mr-2">
                                    <input type="hidden" name="drink_id" value="<?= htmlspecialchars($drink->getId()) ?>">
                                    <input type="hidden" name="action" value="increment">
                                    <button type="submit" class="btn btn-success btn-sm">+</button>
                                </form>
                                <form method="POST" action="/order/updateDrink" class="mr-2">
                                    <input type="hidden" name="drink_id" value="<?= htmlspecialchars($drink->getId()) ?>">
                                    <input type="hidden" name="action" value="decrement">
                                    <button type="submit" class="btn btn-danger btn-sm">-</button>
                                </form>
                                <form method="POST" action="/order/deleteDrink">
                                    <input type="hidden" name="drink_id" value="<?= htmlspecialchars($drink->getId()) ?>">
                                    <button type="submit" class="btn btn-secondary btn-sm">X</button>
                                </form>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No drinks in your order.</p>
        <?php endif; ?>

        <!-- Foods Section -->
        <h3>Foods</h3>
        <?php if (!empty($foods)): ?>
            <ul class="list-group">
                <?php foreach ($foods as $food): ?>
                    <li class="list-group-item">
                        <div class="d-flex flex-column">
                            <!-- Food Details -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <?= htmlspecialchars($food->getName()) ?> 
                                    (<?= $food->quantity ?> x $<?= number_format($food->getPrice(), 2) ?>)
                                </div>
                                <span><strong>$<?= number_format($food->quantity * $food->getPrice(), 2) ?></strong></span>
                            </div>
                            <!-- Buttons -->
                            <div class="d-flex justify-content-start">
                                <form method="POST" action="/order/updateFood" class="mr-2">
                                    <input type="hidden" name="food_id" value="<?= htmlspecialchars($food->getId()) ?>">
                                    <input type="hidden" name="action" value="increment">
                                    <button type="submit" class="btn btn-success btn-sm">+</button>
                                </form>
                                <form method="POST" action="/order/updateFood" class="mr-2">
                                    <input type="hidden" name="food_id" value="<?= htmlspecialchars($food->getId()) ?>">
                                    <input type="hidden" name="action" value="decrement">
                                    <button type="submit" class="btn btn-danger btn-sm">-</button>
                                </form>
                                <form method="POST" action="/order/deleteFood">
                                    <input type="hidden" name="food_id" value="<?= htmlspecialchars($food->getId()) ?>">
                                    <button type="submit" class="btn btn-secondary btn-sm">X</button>
                                </form>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No foods in your order.</p>
        <?php endif; ?>
        <h3 class="mt-4">Total Amount</h3>
        <p><strong>$<?= number_format($totalAmount, 2) ?></strong></p>

        <form method="POST" action="/order/checkout">
            <button type="submit" class="btn btn-primary mt-4">Pay for Order</button>
        </form>
    </div>
</body>
</html>
<?php require __DIR__ . '/../shared/footer.php'; ?>