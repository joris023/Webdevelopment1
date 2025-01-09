<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand font-weight-bold">Kipperij</a>
            <ul class="navbar-nav flex-row">
                <?php if (isset($_SESSION['user_role'])): ?>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <li class="nav-item mx-3">
                            <a class="nav-link" href="/admin">
                                Admin Panel
                            </a>
                        </li>
                    <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'customer'): ?>
                        <li class="nav-item mx-3">
                            <a class="nav-link" href="/menu">
                                Menu
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($_SESSION['user_role'] !== 'admin'): ?>
                        <li class="nav-item mx-3">
                            <a class="nav-link d-flex align-items-center" href="/order">
                                Basket
                                <span class="badge badge-pill badge-primary ml-2">
                                    <?= isset($_SESSION['order']['foods']) || isset($_SESSION['order']['drinks']) ? 
                                        count($_SESSION['order']['foods'] ?? []) + count($_SESSION['order']['drinks'] ?? []) : 0; ?>
                                </span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <form method="POST" action="/login/logout">
                            <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

