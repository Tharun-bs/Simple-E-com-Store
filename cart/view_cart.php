<?php
session_start();
require '../config/db.php';
include '../includes/header.php';

$sessionId = session_id();
$sql = "SELECT c.id AS cart_id, p.name, p.price, c.quantity, p.id AS product_id
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.session_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$sessionId]);
$items = $stmt->fetchAll();

$total = 0;
?>

<div class="cart-container">
    <h2>Your Cart</h2>
    
    <?php if (empty($items)): ?>
        <p>Your cart is empty.</p>
        <a href="../pages/home.php" class="button">Continue Shopping</a>
    <?php else: ?>
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($items as $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td>$<?= number_format($item['price'], 2) ?></td>
                <td>
                    <form action="actions.php?action=update" method="POST" style="display:inline;">
                        <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" style="width: 60px;">
                        <button type="submit">Update</button>
                    </form>
                </td>
                <td>$<?= number_format($subtotal, 2) ?></td>
                <td>
                    <a href="actions.php?action=remove&id=<?= $item['product_id'] ?>" class="delete" 
                       onclick="return confirm('Are you sure you want to remove this item?')">Remove</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="total">
            <strong>Total: $<?= number_format($total, 2) ?></strong>
        </div>
        
        <div style="margin-top: 2rem;">
            <a href="../pages/home.php" class="button">Continue Shopping</a>
            <a href="../pages/checkout.php" class="button" style="margin-left: 1rem;">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>