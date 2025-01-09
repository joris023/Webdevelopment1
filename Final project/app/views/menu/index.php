<?php require __DIR__ . '/../shared/header.php'; ?>
<title>Menu Overview</title>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Menu Overview</h1>
        <p class="text-center">Choose what you'd like to see:</p>

        <div class="row justify-content-center">
            <!-- Food Button -->
            <div class="col-md-4 text-center mb-3">
                <a href="/menu/food" class="btn btn-primary btn-lg btn-block">Food Menu</a>
            </div>

            <!-- Drink Button -->
            <div class="col-md-4 text-center mb-3">
                <a href="/menu/drink" class="btn btn-secondary btn-lg btn-block">Drink Menu</a>
            </div>
        </div>
        <div class="text-center mt-5">
            <!-- Basket Link -->
            <a href="/order" class="btn btn-outline-dark">View Basket</a>
        </div>
    </div>
<?php require __DIR__ . '/../shared/footer.php'; ?>
