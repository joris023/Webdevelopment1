<?php require __DIR__ . '/../shared/header.php'; ?>
<title>Food Menu</title>
    <div class="container mt-3 mb-3">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success m-0 mb-2" role="alert">
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger m-0 mb-2" role="alert">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
        <h1 class="text-center mb-4">Food Menu</h1>
        <div class="row g-3">
            <?php foreach ($foods as $food): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                    <div class="card h-100">
                        <?php if (!empty($food->getImage())): ?>
                            <div class="image-container m-2">
                                <img src="<?= htmlspecialchars($food->getImage()) ?>" class="card-img-top" alt="<?= htmlspecialchars($food->getName()) ?>">
                            </div>
                        <?php else: ?>
                            <div class="image-container m-2">
                                <img src="/images/default.jpg" class="card-img-top" alt="Default">
                            </div>
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center"><?= htmlspecialchars($food->getName()) ?></h5>
                            <p class="card-text text-muted text-center"><?= htmlspecialchars($food->getDescription()) ?></p>
                            <p class="card-text text-center"><strong>Price: $<?= htmlspecialchars($food->getPrice()) ?></strong></p>
                            <div class="mt-auto text-center">
                                <!-- Order Form -->
                                <form method="POST" action="/menu/addFoodToOrder">
                                    <input type="hidden" name="food_id" value="<?= htmlspecialchars($food->getId()) ?>">
                                    <div class="form-group">
                                        <label for="quantity-<?= htmlspecialchars($food->getId()) ?>">Quantity:</label>
                                        <input type="number" id="quantity-<?= htmlspecialchars($food->getId()) ?>" name="quantity" class="form-control form-control-sm text-center" min="1" value="1">
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