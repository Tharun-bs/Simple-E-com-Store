<?php
include '../config/db.php';
include '../includes/header.php';
$stmt = $pdo->query("SELECT * FROM products WHERE stock_status='in_stock' ORDER BY created_at DESC LIMIT 9");
$products = $stmt->fetchAll();
foreach ($products as $product) {
    echo "<div class='product'>
            <a href='product.php?id={$product['id']}'>
            <img src='../assets/images/{$product['image']}' alt=''>
            <h3>{$product['name']}</h3>
            <p>\${$product['price']}</p>
            </a>
          </div>";
}
include '../includes/footer.php';
?>