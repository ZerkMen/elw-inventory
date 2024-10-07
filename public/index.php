<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('BASE_PATH', __DIR__ . '/..');
require_once BASE_PATH . '/src/autoload.php';
session_start();

use Inventory\Helpers\Auth;
use Inventory\Helpers\Authorization;

$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);
$path = rtrim($path, '/');
if (empty($path)) {
    $path = '/';
}
error_log("Requested path: " . $path);

$routes = [
    '/' => ['HomeController', 'index'],
    '/login' => ['AuthController', 'login'],
    '/logout' => ['AuthController', 'logout'],
    '/dashboard' => ['DashboardController', 'index'],
    '/suppliers' => ['SupplierController', 'index'],
    '/suppliers/create' => ['SupplierController', 'create'],
    '/suppliers/edit/{id}' => ['SupplierController', 'edit'],
    '/suppliers/delete/{id}' => ['SupplierController', 'delete'],
    '/products' => ['ProductController', 'index'],
    '/products/create' => ['ProductController', 'create'],
    '/products/edit/{id}' => ['ProductController', 'edit'],
    '/products/delete/{id}' => ['ProductController', 'delete'],
    '/categories' => ['CategoryController', 'index'],
    '/categories/create' => ['CategoryController', 'create'],
    '/categories/edit/{id}' => ['CategoryController', 'edit'],
    '/categories/delete/{id}' => ['CategoryController', 'delete'],
    '/users' => ['UserController', 'index'],
    '/users/create' => ['UserController', 'create'],
    '/users/edit/{id}' => ['UserController', 'edit'],
    '/users/delete/{id}' => ['UserController', 'delete'],
    '/profile' => ['ProfileController', 'index'],
    '/profile/edit' => ['ProfileController', 'edit'],
    '/customers' => ['CustomerController', 'index'],
    '/customers/create' => ['CustomerController', 'create'],
    '/customers/edit/{id}' => ['CustomerController', 'edit'],
    '/customers/delete/{id}' => ['CustomerController', 'delete'],
    '/orders' => ['OrderController', 'index'],
    '/orders/create' => ['OrderController', 'create'],
    '/orders/delete/{id}' => ['OrderController', 'delete'],
    '/orders/view/{id}' => ['OrderController', 'view'],
    '/orders/updateStatus/{id}' => ['OrderController', 'updateStatus'],
    '/inventory' => ['InventoryController', 'index'],
    '/inventory/update-min-stock/{id}' => ['InventoryController', 'updateMinStockLevel'],
    '/inventory/edit/{id}' => ['InventoryController', 'edit'],
    '/inventory/update/{id}' => ['InventoryController', 'update'],
    '/discounts' => ['DiscountController', 'index'],
    '/discounts/create' => ['DiscountController', 'create'],
    '/discounts/edit/{id}' => ['DiscountController', 'edit'],
    '/discounts/delete/{id}' => ['DiscountController', 'delete'],
];

$matchedRoute = null;
$params = [];

foreach ($routes as $routePattern => $routeInfo) {
    $pattern = preg_replace('/{[^}]+}/', '([^/]+)', $routePattern);
    $pattern = '#^' . $pattern . '$#';
    
    if (preg_match($pattern, $path, $matches)) {
        $matchedRoute = $routeInfo;
        array_shift($matches); // Entfernt den vollen Match
        $params = $matches;
        break;
    }
}

if ($matchedRoute) {
    $controllerName = '\\Inventory\\Controllers\\' . $matchedRoute[0];
    $methodName = $matchedRoute[1];
    $requiredPermission = $matchedRoute[2] ?? null;  // Verwendung des Null Coalescing Operators
    
    error_log("Controller: " . $controllerName . ", Method: " . $methodName . ", Required Permission: " . ($requiredPermission ?? 'None'));
   
    $controller = new $controllerName();
   
    if ($path !== '/login' && !Auth::isLoggedIn()) {
        header('Location: /login');
        exit;
    }
    
    $user = Auth::getUser();
    error_log("User: " . ($user ? json_encode($user) : 'Not logged in'));
    
    if ($requiredPermission === null || $path === '/login' || ($user && Authorization::hasPermission($user['role'], $requiredPermission))) {
        call_user_func_array([$controller, $methodName], $params);
    } else {
        error_log("Permission denied for user: " . ($user ? $user['username'] : 'Not logged in') . " on path: " . $path);
        http_response_code(403);
        echo "Zugriff verweigert. Bitte kontaktieren Sie den Administrator.";
    }
} else {
    error_log("404 Not Found for path: " . $path);
    http_response_code(404);
    echo "404 Not Found";
}