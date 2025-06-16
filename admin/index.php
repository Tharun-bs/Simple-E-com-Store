<?php
include 'config/db.php';
include 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM products WHERE stock_status = 'in_stock'");
$products = $stmt->fetchAll();

foreach (["S", "M", "L"] as $size) {
    $sizeLabel = $size == 'S' ? 'Small' : ($size == 'M' ? 'Medium' : 'Large');
    echo "<h2>Size $sizeLabel Collection</h2><div class='product-group'>";
    $count = 0;
    foreach ($products as $product) {
        if ($product['size'] == $size && $count < 3) {
            echo "<div class='product'>
                    <img src='assets/images/{$product['image']}' alt='{$product['name']}' loading='lazy'>
                    <h3>" . htmlspecialchars($product['name']) . "</h3>
                    <p>\$" . number_format($product['price'], 2) . "</p>
                    <div class='product-actions'>
                        <a href='cart/add.php?id={$product['id']}'>🛒 Add to Cart</a>
                        <a href='pages/checkout.php?buy_now={$product['id']}'>⚡ Buy Now</a>
                    </div>
                  </div>";
            $count++;
        }
    }
    if ($count == 0) {
        echo "<p style='text-align: center; color: rgba(255,255,255,0.8); font-style: italic;'>No products available in size $sizeLabel</p>";
    }
    echo "</div>";
}

include 'includes/footer.php';
?>