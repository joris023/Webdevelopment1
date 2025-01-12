<?php require __DIR__ . '/../shared/header.php'; ?>
<title>Register</title>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Register</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="/login/registerUser">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger m-0 mt-4" role="alert">
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="text-center mt-4">
            <!-- Basket Link -->
            <a href="/login" class="btn btn-outline-dark">Go back to login</a>
        </div>
    </div>
<?php require __DIR__ . '/../shared/footer.php'; ?>
