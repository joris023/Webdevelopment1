<?php require __DIR__ . '../../shared/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container mt-5">
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
    <script>
        async function getOrderDetails(orderId) {
            try {
                const response = await fetch(`/api/orderapi/${orderId}`);
                if (!response.ok) {
                    throw new Error('Failed to fetch order details');
                }
                const orderDetails = await response.json();

                // Display details in an alert or modal
                alert(
                    `Order Details:\n\nFoods:\n${
                        orderDetails.foods.map(f => `${f.name} x ${f.quantity}`).join('\n')
                    }\n\nDrinks:\n${
                        orderDetails.drinks.map(d => `${d.name} x ${d.quantity}`).join('\n')
                    }`
                );
            } catch (error) {
                alert(error.message);
            }
        }
    </script>
    <!-- Bootstrap JS -->
</body>
</html>
<?php require __DIR__ . '/../shared/footer.php'; ?>
