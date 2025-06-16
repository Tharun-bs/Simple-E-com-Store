<?php
include '../config/db.php';

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    $stock = $_POST['stock_status'];

    $image = $_FILES['image']['name'] ?? '';
    if ($image) {
        $target = "../assets/images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    if ($action == 'edit' && $id) {
        $query = $image ?
            "UPDATE products SET name=?, description=?, size=?, image=?, price=?, stock_status=? WHERE id=?" :
            "UPDATE products SET name=?, description=?, size=?, price=?, stock_status=? WHERE id=?";

        $stmt = $pdo->prepare($query);
        $params = $image ? [$name, $desc, $size, $image, $price, $stock, $id] : [$name, $desc, $size, $price, $stock, $id];
        $stmt->execute($params);
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (name, description, size, image, price, stock_status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $desc, $size, $image, $price, $stock]);
    }
    header("Location: dashboard.php");
    exit();
}

if ($action == 'delete' && $id) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: dashboard.php");
    exit();
}

$product = null;
if ($action == 'edit' && $id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $action == 'edit' ? 'Edit' : 'Add' ?> Product - E-Store Admin</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .form-header h2 {
            color: #333;
            margin: 0;
            text-shadow: none;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }
        
        .current-image {
            text-align: center;
            margin: 1rem 0;
        }
        
        .current-image img {
            max-width: 150px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .file-input-wrapper {
            position: relative;
            display: inline-block;
            cursor: pointer;
            width: 100%;
        }
        
        .file-input-wrapper input[type=file] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-input-display {
            padding: 0.75rem;
            border: 2px dashed #e0e0e0;
            border-radius: 10px;
            text-align: center;
            background: #f9f9f9;
            transition: all 0.3s ease;
        }
        
        .file-input-wrapper:hover .file-input-display {
            border-color: #667eea;
            background: #f0f4ff;
        }
        
        .required {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h2><?= $action == 'edit' ? '✏️ Edit Product' : '➕ Add New Product' ?></h2>
            <p style="color: #666; margin: 0.5rem 0 0 0;">
                <?= $action == 'edit' ? 'Update product information' : 'Fill in the details for your new product' ?>
            </p>
        </div>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name <span class="required">*</span></label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="<?= htmlspecialchars($product['name'] ?? '') ?>" 
                       placeholder="Enter product name" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" 
                          name="description" 
                          placeholder="Describe your product..."><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="size">Size <span class="required">*</span></label>
                <select id="size" name="size" required>
                    <option value="">Select size</option>
                    <option value="S" <?= (isset($product) && $product['size'] == 'S') ? 'selected' : '' ?>>Small (S)</option>
                    <option value="M" <?= (isset($product) && $product['size'] == 'M') ? 'selected' : '' ?>>Medium (M)</option>
                    <option value="L" <?= (isset($product) && $product['size'] == 'L') ? 'selected' : '' ?>>Large (L)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="image">Product Image</label>
                <?php if ($action == 'edit' && $product && $product['image']): ?>
                    <div class="current-image">
                        <p><strong>Current Image:</strong></p>
                        <img src="../assets/images/<?= $product['image'] ?>" alt="Current product image">
                        <p style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">
                            Leave empty to keep current image
                        </p>
                    </div>
                <?php endif; ?>
                <div class="file-input-wrapper">
                    <input type="file" id="image" name="image" accept="image/*">
                    <div class="file-input-display">
                        <p>📁 Choose an image file</p>
                        <small>Supported formats: JPG, PNG, GIF</small>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="price">Price <span class="required">*</span></label>
                <input type="number" 
                       id="price" 
                       name="price" 
                       step="0.01" 
                       min="0" 
                       value="<?= $product['price'] ?? '' ?>" 
                       placeholder="0.00" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="stock_status">Stock Status <span class="required">*</span></label>
                <select id="stock_status" name="stock_status" required>
                    <option value="">Select status</option>
                    <option value="in_stock" <?= (isset($product) && $product['stock_status'] == 'in_stock') ? 'selected' : '' ?>>✅ In Stock</option>
                    <option value="out_of_stock" <?= (isset($product) && $product['stock_status'] == 'out_of_stock') ? 'selected' : '' ?>>❌ Out of Stock</option>
                </select>
            </div>
            
            <div class="form-actions">
                <a href="dashboard.php" class="button" style="background: #6c757d;">← Back to Dashboard</a>
                <button type="submit" class="button">
                    <?= $action == 'edit' ? '💾 Update Product' : '➕ Add Product' ?>
                </button>
            </div>
        </form>
    </div>

    <script>
        // File input display update
        document.getElementById('image').addEventListener('change', function(e) {
            const display = document.querySelector('.file-input-display p');
            if (e.target.files.length > 0) {
                display.textContent = '📁 ' + e.target.files[0].name;
            } else {
                display.textContent = '📁 Choose an image file';
            }
        });
    </script>
</body>
</html>