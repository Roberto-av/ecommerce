<?php
require_once 'config/database.php';
require_once 'database/seeders/ProductSeeder.php';
require_once 'controllers/ProductController.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

$database = new Database();
$db = $database->getConnection();
$database->createTable('products');

$productSeeder = new ProductSeeder(dbConnection: $db);
$productSeeder->seed();

$productController = new ProductController($db);

$endpoint = $_GET['endpoint'] ?? null;
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($endpoint === 'products' && !$id) {
        $products = $productController->getAllProducts();
        echo json_encode($products);
    } elseif ($endpoint === 'product' && $id) {
        $product = $productController->getProductById($id);
        echo json_encode($product);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Ruta no encontrada"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Método no permitido"]);
}
