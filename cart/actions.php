<?php
session_start();
require '../config/db.php';

$action = $_GET['action'] ?? '';
$productId = $_GET['id'] ?? null;
$quantity = $_POST['quantity'] ?? 1;
$sessionId = session_id();

try {
    switch ($action) {
        case 'add':
            if ($productId) {
                // Validate product exists
                $checkProduct = $pdo->prepare("SELECT id FROM products WHERE id = ?");
                $checkProduct->execute([$productId]);
                if (!$checkProduct->fetch()) {
                    throw new Exception("Product not found");
                }

                // Check if item already in cart
                $stmt = $pdo->prepare("SELECT * FROM cart WHERE product_id = ? AND session_id = ?");
                $stmt->execute([$productId, $sessionId]);
                $item = $stmt->fetch();

                if ($item) {
                    // Update quantity
                    $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE id = ?");
                    $stmt->execute([$item['id']]);
                } else {
                    // Add new item
                    $stmt = $pdo->prepare("INSERT INTO cart (session_id, product_id, quantity) VALUES (?, ?, ?)");
                    $stmt->execute([$sessionId, $productId, 1]);
                }
                
                // Success message
                $_SESSION['cart_message'] = "Item added to cart successfully!";
            }
            break;

        case 'update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'], $_POST['quantity'])) {
                $cartId = $_POST['cart_id'];
                $quantity = max(1, intval($_POST['quantity']));
                
                // Verify cart item belongs to this session
                $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND session_id = ?");
                $result = $stmt->execute([$quantity, $cartId, $sessionId]);
                
                if ($result && $stmt->rowCount() > 0) {
                    $_SESSION['cart_message'] = "Cart updated successfully!";
                } else {
                    $_SESSION['cart_error'] = "Failed to update cart item.";
                }
            }
            break;

        case 'remove':
            if ($productId) {
                $stmt = $pdo->prepare("DELETE FROM cart WHERE product_id = ? AND session_id = ?");
                $result = $stmt->execute([$productId, $sessionId]);
                
                if ($result && $stmt->rowCount() > 0) {
                    $_SESSION['cart_message'] = "Item removed from cart.";
                } else {
                    $_SESSION['cart_error'] = "Failed to remove item from cart.";
                }
            }
            break;

        case 'clear':
            // Clear entire cart for this session
            $stmt = $pdo->prepare("DELETE FROM cart WHERE session_id = ?");
            $result = $stmt->execute([$sessionId]);
            $_SESSION['cart_message'] = "Cart cleared successfully!";
            break;

        default:
            $_SESSION['cart_error'] = "Invalid action.";
            break;
    }
} catch (Exception $e) {
    $_SESSION['cart_error'] = "Error: " . $e->getMessage();
}

// Determine redirect location based on referer or default to cart
$redirect = $_SERVER['HTTP_REFERER'] ?? 'view_cart.php';

// If action was add and we came from a product page, stay on that page
if ($action === 'add' && strpos($redirect, 'product.php') !== false) {
    header("Location: $redirect");
} else {
    // Otherwise, redirect to cart view
    header("Location: view_cart.php");
}
exit;