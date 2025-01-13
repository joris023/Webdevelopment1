<?php require __DIR__ . '/../shared/header.php'; ?>
<title>Login</title>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Login</h1>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Login Form -->
                <form method="POST" action="/login/authenticate">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <hr>
                <!-- Register Button -->
                <p class="text-center">Don't have an account?</p>
                <a href="/login/register" class="btn btn-secondary btn-block">Register</a>
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger m-0 mt-4" role="alert">
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php require __DIR__ . '/../shared/footer.php'; ?>
