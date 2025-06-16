<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Store - Premium Online Shopping</title>
    <style>
/* Enhanced E-Store Stylesheet */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

/* Header Styles */
header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 1rem 0;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}

header .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

header h1 a {
    text-decoration: none;
    color: #764ba2;
    font-size: 2rem;
    font-weight: bold;
    background: linear-gradient(45deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

nav a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    transition: all 0.3s ease;
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

nav a:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

/* Main Content */
main {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    min-height: calc(100vh - 140px);
}

/* Product Grid */
.product-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.product {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.product:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.product img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 15px;
    margin-bottom: 1rem;
}

.product h3 {
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
    color: #333;
}

.product p {
    font-size: 1.1rem;
    color: #667eea;
    font-weight: bold;
    margin-bottom: 1rem;
}

.product a {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.product a:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

/* Section Headers */
h2 {
    color: white;
    font-size: 2rem;
    margin: 2rem 0 1rem 0;
    text-align: center;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

/* Cart and Checkout Styles */
.cart-container, .checkout-container {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    margin-bottom: 2rem;
}

.cart-container h2, .checkout-container h2 {
    color: #333;
    text-shadow: none;
    text-align: left;
    margin-bottom: 1.5rem;
}

.cart-container ul, .checkout-container ul {
    list-style: none;
    margin-bottom: 1.5rem;
}

.cart-container li, .checkout-container li {
    padding: 1rem;
    background: rgba(102, 126, 234, 0.1);
    margin-bottom: 0.5rem;
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

.total {
    font-size: 1.3rem;
    font-weight: bold;
    color: #764ba2;
    text-align: right;
    margin: 1rem 0;
}

/* Buttons */
button, .button {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

button:hover, .button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.delete {
    background: linear-gradient(45deg, #ff6b6b, #ee5a52) !important;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3) !important;
}

.delete:hover {
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4) !important;
}

/* Product Detail Page */
.product-detail {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    align-items: start;
}

.product-detail img {
    width: 100%;
    border-radius: 15px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.product-info h2 {
    color: #333;
    text-shadow: none;
    text-align: left;
    margin-bottom: 1rem;
}

.product-info p {
    margin-bottom: 1rem;
    font-size: 1.1rem;
    line-height: 1.6;
}

/* Footer */
footer {
    background: rgba(0, 0, 0, 0.8);
    color: white;
    text-align: center;
    padding: 2rem;
    margin-top: 2rem;
}

/* Admin Dashboard Styles */
.admin-container {
    background: white;
    border-radius: 15px;
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

.admin-actions {
    display: flex;
    gap: 1rem;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

th {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
}

td {
    padding: 1rem;
    border-bottom: 1px solid #f0f0f0;
}

tr:hover {
    background: rgba(102, 126, 234, 0.05);
}

td img {
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Form Styles */
form {
    background: rgba(255, 255, 255, 0.95);
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    max-width: 600px;
    margin: 2rem auto;
}

form input, form textarea, form select {
    width: 100%;
    padding: 0.75rem;
    margin-bottom: 1rem;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

form input:focus, form textarea:focus, form select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        padding: 0 1rem;
    }
    
    header .container {
        flex-direction: column;
        gap: 1rem;
    }
    
    main {
        padding: 1rem;
    }
    
    .product-group {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .product-detail {
        grid-template-columns: 1fr;
    }
    
    .admin-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    table {
        font-size: 0.9rem;
    }
    
    th, td {
        padding: 0.5rem;
    }
}

/* Loading Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product, .cart-container, .checkout-container, .product-detail {
    animation: fadeInUp 0.6s ease;
}

/* Status Badges */
.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
}

.status-in-stock {
    background: #d4edda;
    color: #155724;
}

.status-out-of-stock {
    background: #f8d7da;
    color: #721c24;
}
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="/e-com/pages/home.php">🛍️ E-Store</a></h1>
            <nav>
                <a href="/e-com/cart/view_cart.php">🛒 Cart</a>
            </nav>
        </div>
    </header>
    <main>