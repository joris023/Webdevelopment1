<?php require __DIR__ . '/../shared/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
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
            </div>
        </div>
    </div>
</body>
</html>
<?php require __DIR__ . '/../shared/footer.php'; ?>
