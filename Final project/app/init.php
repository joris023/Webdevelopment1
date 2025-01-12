<?php
// Start the session if it hasn't already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define access control for specific roles
$currentUrl = $_SERVER['REQUEST_URI'];

// Define role-based access rules
$roleBasedAccess = [
    '/admin' => 'admin', 
    '/menu' => 'customer',  
    '/order' => 'customer', 
];

// Exclude certain routes (like `/login`) from role checks
$excludedRoutes = ['/login', '/register'];

// Check if the current URL is excluded
foreach ($excludedRoutes as $excludedRoute) {
    if (strpos($currentUrl, $excludedRoute) === 0) {
        return; // Exit and skip access control for excluded routes
    }
}

// Check if a user is logged in
if (!isset($_SESSION['user_role'])) {
    header('Location: /login');
    exit();
}

// Check role-based access
foreach ($roleBasedAccess as $route => $role) {
    if (strpos($currentUrl, $route) === 0 && $_SESSION['user_role'] !== $role) {
        // Redirect to login page if role doesn't match
        header('Location: /login');
        exit();
    }
}

?>
