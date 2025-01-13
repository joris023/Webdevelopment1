<?php require __DIR__ . '../../shared/header.php'; ?>
<title>Manage Orders</title>
    <div class="container mt-3 mb-3">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success m-0 mb-3" role="alert">
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger m-0 mb-3" role="alert">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
        <h1 class="text-center mb-4">Food Menu</h1>
        <div class="row g-3">
        <?php foreach ($orders as $order): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-2">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-center">Table: <?= htmlspecialchars($order->getTableNumber()) ?></h5>
                        <p class="card-text text-muted text-center"><?= htmlspecialchars($order->getCreatedAt()) ?></p>
                        <p class="card-text text-center"><strong>Order ID: <?= htmlspecialchars($order->getId()) ?></strong></p>
                        <p class="card-text text-center"><strong>Price: $<?= htmlspecialchars($order->getTotalAmount()) ?></strong></p>
                    </div>
                    <div>
                        <!-- Verwijder Order knop -->
                        <form method="POST" action="/admin/removeorder">
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order->getId()) ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Order done</button>
                        </form>

                        <!-- Toon Details knop -->
                        <form method="GET" action="/admin/orderdetails">
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order->getId()) ?>">
                            <button type="submit" class="btn btn-info btn-sm">Details</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
<?php require __DIR__ . '/../shared/footer.php'; ?>
