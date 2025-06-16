<?php
include '../config/db.php';
session_start();

// OPTIONAL: Protect dashboard with login check
// if (!isset($_SESSION['admin_logged_in'])) {
//     header('Location: index.php');
//     exit();
//}

// Fetch all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-Store</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .admin-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .admin-header h1 {
            color: #333;
            font-size: 2rem;
            margin: 0;
        }
        
        .admin-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            display: block;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .products-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .table-header {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 1rem;
            font-weight: 600;
            text-align: center;
        }
        
        .table-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }
        
        .product-image-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="admin-container">
    <div class="admin-header">
        <h1>📦 Admin Dashboard</h1>
        <div class="admin-actions">
            <a href="manage_product.php?action=add" class="button">➕ Add New Product</a>
            <a href="logout.php" class="button" style="background: #6c757d;">🚪 Logout</a>
        </div>
    </div>
    
    <?php
    $totalProducts = count($products);
    $inStock = count(array_filter($products, function($p) { return $p['stock_status'] == 'in_stock'; }));
    $outOfStock = $totalProducts - $inStock;
    $totalValue = array_sum(array_map(function($p) { return $p['price']; }, $products));
    ?>
    
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-number"><?= $totalProducts ?></span>
            <span class="stat-label">Total Products</span>
        </div>
        <div class="stat-card">
            <span class="stat-number"><?= $inStock ?></span>
            <span class="stat-label">In Stock</span>
        </div>
        <div class="stat-card">
            <span class="stat-number"><?= $outOfStock ?></span>
            <span class="stat-label">Out of Stock</span>
        </div>
        <div class="stat-card">
            <span class="stat-number">$<?= number_format($totalValue, 2) ?></span>
            <span class="stat-label">Total Inventory Value</span>
        </div>
    </div>

    <div class="products-table">
        <table>
            <thead>
                <tr>
                    <th class="table-header">ID</th>
                    <th class="table-header">Image</th>
                    <th class="table-header">Name</th>
                    <th class="table-header">Size</th>
                    <th class="table-header">Price</th>
                    <th class="table-header">Status</th>
                    <th class="table-header">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem; color: #666;">
                            <p>No products found</p>
                            <a href="manage_product.php?action=add" class="button">Add Your First Product</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td style="text-align: center; font-weight: bold;"><?= $product['id'] ?></td>
                            <td style="text-align: center;">
                                <img src="../assets/images/<?= $product['image'] ?>" 
                                     alt="<?= htmlspecialchars($product['name']) ?>" 
                                     class="product-image-thumb">
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($product['name']) ?></strong>
                                <?php if (!empty($product['description'])): ?>
                                    <br><small style="color: #666;"><?= htmlspecialchars(substr($product['description'], 0, 50)) ?>...</small>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center;">
                                <span class="size-badge"><?= $product['size'] ?></span>
                            </td>
                            <td style="text-align: center; font-weight: bold; color: #667eea;">
                                $<?= number_format($product['price'], 2) ?>
                            </td>
                            <td style="text-align: center;">
                                <?php if ($product['stock_status'] == 'in_stock'): ?>
                                    <span class="status-badge status-in-stock">✅ In Stock</span>
                                <?php else: ?>
                                    <span class="status-badge status-out-of-stock">❌ Out of Stock</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="manage_product.php?action=edit&id=<?= $product['id'] ?>" 
                                       class="button" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                       ✏️ Edit
                                    </a>
                                    <a href="manage_product.php?action=delete&id=<?= $product['id'] ?>" 
                                       class="button delete" 
                                       style="padding: 0.5rem 1rem; font-size: 0.9rem;"
                                       onclick="return confirm('Are you sure you want to delete this product?');">
                                       🗑️ Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>