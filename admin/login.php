<?php
session_start();
require '../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Fetch admin from DB
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin) {
        // Plain-text password (not secure, use password_hash() in real use)
        if ($password === $admin['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Incorrect password.';
        }
    } else {
        $error = 'Admin not found.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <style>
    body { font-family: Arial; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; }
    form { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; }
    button { padding: 10px 15px; background: #28a745; color: #fff; border: none; border-radius: 4px; }
    .error { color: red; }
  </style>
</head>
<body>

<form method="POST">
  <h2>Admin Login</h2>
  <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
  <input type="text" name="username" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Login</button>
</form>

</body>
</html>
