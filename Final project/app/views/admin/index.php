<?php //session_start();
require __DIR__ . '/../shared/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Overview</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Admin Overview</h1>
        <p class="text-center">Choose what you like to see:</p>

        <div class="row justify-content-center">
            <!-- Food Button -->
            <div class="col-md-4 text-center mb-3">
                <a href="/admin/managemenu" class="btn btn-primary btn-lg btn-block">Manage Menu</a>
            </div>

            <!-- Drink Button -->
            <div class="col-md-4 text-center mb-3">
                <a href="/admin/manageorders" class="btn btn-secondary btn-lg btn-block">Manage Orders</a>
            </div>
        </div>
        <div class="text-center mt-5">
            <!-- Basket Link -->
            <a href="/api/menuapi" class="btn btn-outline-dark">View Api-Endpoint</a>
        </div>
    </div>
</body>
</html>
<?php require __DIR__ . '/../shared/footer.php'; ?>
