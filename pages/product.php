<?php
session_start();
include '../config/db.php';
include '../includes/header.php';

// Validate and sanitize the ID parameter
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    echo "<div class='product-detail'>
            <div class='product-info'>
                <h2>❌ Invalid Product</h2>
                <p>Invalid product ID provided.</p>
                <a href='/e-com/index.php' class='button'>🏠 Back to Home</a>
            </div>
          </div>";
    include '../includes/footer.php';
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    
    if ($product) {
        // Display success/error messages if any
        if (isset($_SESSION['cart_message'])) {
            echo "<div class='alert alert-success'>" . htmlspecialchars($_SESSION['cart_message']) . "</div>";
            unset($_SESSION['cart_message']);
        }
        if (isset($_SESSION['cart_error'])) {
            echo "<div class='alert alert-error'>" . htmlspecialchars($_SESSION['cart_error']) . "</div>";
            unset($_SESSION['cart_error']);
        }
        
        $sizeLabel = $product['size'] == 'S' ? 'Small' : ($product['size'] == 'M' ? 'Medium' : 'Large');
        $statusClass = $product['stock_status'] == 'in_stock' ? 'status-in-stock' : 'status-out-of-stock';
        $statusText = $product['stock_status'] == 'in_stock' ? '✅ In Stock' : '❌ Out of Stock';
        
        echo "<div class='product-detail'>
                <div class='product-image'>
                    <img src='/e-com/assets/images/" . htmlspecialchars($product['image']) . "' alt='" . htmlspecialchars($product['name']) . "' onerror='this.src=\"/e-com/assets/images/placeholder.jpg\"'>
                </div>
                <div class='product-info'>
                    <h2>" . htmlspecialchars($product['name']) . "</h2>
                    <p class='product-description'>" . htmlspecialchars($product['description']) . "</p>
                    <div class='product-specs'>
                        <p><strong>📏 Size:</strong> " . htmlspecialchars($sizeLabel) . "</p>
                        <p><strong>💰 Price:</strong> $" . number_format($product['price'], 2) . "</p>
                        <p><strong>📦 Status:</strong> <span class='status-badge " . htmlspecialchars($statusClass) . "'>" . htmlspecialchars($statusText) . "</span></p>
                    </div>";

        if ($product['stock_status'] == 'in_stock') {
            echo "<div class='product-actions'>
                    <a href='/e-com/cart/actions.php?action=add&id=" . urlencode($product['id']) . "' class='button'>🛒 Add to Cart</a>
                    <a href='/e-com/pages/checkout.php?buy_now=" . urlencode($product['id']) . "' class='button'>⚡ Buy Now</a>
                  </div>";
        } else {
            echo "<div class='product-actions'>
                    <button disabled class='button' style='opacity: 0.6; cursor: not-allowed;'>Out of Stock</button>
                  </div>";
        }

        echo "    </div>
              </div>";
    } else {
        echo "<div class='product-detail'>
                <div class='product-info'>
                    <h2>❌ Product Not Found</h2>
                    <p>Sorry, the product you're looking for doesn't exist or has been removed.</p>
                    <a href='/e-com/index.php' class='button'>🏠 Back to Home</a>
                </div>
              </div>";
    }
} catch (Exception $e) {
    echo "<div class='product-detail'>
            <div class='product-info'>
                <h2>❌ Error</h2>
                <p>Sorry, there was an error loading the product. Please try again later.</p>
                <a href='/e-com/index.php' class='button'>🏠 Back to Home</a>
            </div>
          </div>";
}

include '../includes/footer.php';
?>
