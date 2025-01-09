<?php require __DIR__ . '/../shared/header.php'; ?>
<title>Drink Menu</title>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Drink Menu</h1>
        <div class="row g-3">
            <?php foreach ($drinks as $drink): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center"><?= htmlspecialchars($drink->getName()) ?></h5>
                            <p class="card-text text-muted text-center"><?= htmlspecialchars($drink->getDescription()) ?></p>
                            <p class="card-text text-center"><strong>Price: $<?= htmlspecialchars($drink->getPrice()) ?></strong></p>
                            <div class="mt-auto text-center">
                                <!-- Order Form -->
                                <form method="POST" action="/menu/addDrinkToOrder">
                                    <input type="hidden" name="drink_id" value="<?= htmlspecialchars($drink->getId()) ?>">
                                    <div class="form-group">
                                        <label for="quantity-<?= htmlspecialchars($drink->getId()) ?>">Quantity:</label>
                                        <input type="number" id="quantity-<?= htmlspecialchars($drink->getId()) ?>" name="quantity" class="form-control form-control-sm text-center" min="1" value="1">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Order Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php require __DIR__ . '/../shared/footer.php'; ?>
