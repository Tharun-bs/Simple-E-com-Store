<?php
include '../config/db.php';
include '../includes/header.php';
session_start();
$session = session_id();
$sql = "SELECT p.name, p.price, c.quantity, p.image
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.session_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$session]);
$items = $stmt->fetchAll();
$total = 0;

echo "<div class='checkout-container'>
        <h2>💳 Checkout</h2>";

if (empty($items)) {
    echo "<div style='text-align: center; padding: 2rem;'>
            <p style='font-size: 1.2rem; color: #666; margin-bottom: 1rem;'>No items in cart</p>
            <a href='../index.php' class='button'>🛍️ Start Shopping</a>
          </div>";
} else {
    echo "<form method='POST' action='place_order.php'>
            <div class='order-summary'>
                <h3>📋 Order Summary</h3>
                <div class='checkout-items'>";
    
    foreach ($items as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
        echo "<div class='checkout-item'>
                <div class='item-image'>
                    <img src='../assets/images/{$item['image']}' alt='" . htmlspecialchars($item['name']) . "' style='width: 50px; height: 50px; object-fit: cover; border-radius: 8px;'>
                </div>
                <div class='item-info'>
                    <h4>" . htmlspecialchars($item['name']) . "</h4>
                    <p>{$item['quantity']} × \$" . number_format($item['price'], 2) . " = \$" . number_format($subtotal, 2) . "</p>
                </div>
              </div>";
    }
    
    echo "    </div>
                <div class='order-total'>
                    <h3>Total: \$" . number_format($total, 2) . "</h3>
                </div>
            </div>
            
            <div class='checkout-actions'>
                <a href='view_cart.php' class='button' style='background: #6c757d;'>← Back to Cart</a>
                <button type='submit' class='button'>🎉 Place Order (\$" . number_format($total, 2) . ")</button>
            </div>
          </form>";
}

echo "</div>";
include '../includes/footer.php';
?>