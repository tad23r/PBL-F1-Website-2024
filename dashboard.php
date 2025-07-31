<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PeaKing Cinema</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>

<header>
    <div class="logo">PeaKing Cinema 🍿</div>
    <a href="logout.php"><button class="login-btn">Logout</button></a>
</header>

<div class="login-section">
    <div class="login-form">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>!</h2>
    <?php if (!empty($login_success_message)): ?>
            <p style="color: green; text-align: center;"><?php echo $login_success_message; ?></p>
        <?php endif; ?>
        <p>You are now logged in. Enjoy your stay!</p>
        <p style="font-size: small;">Click <a href="index.html">here</a> to Continue</p>
    </div>
</div>

<footer>
    <p>&copy; <?php echo date('Y'); ?> PeaKing Cinema. All rights reserved.</p>
</footer>

</body>
</html>

<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve success message if set
$login_success_message = "";
if (isset($_SESSION['login_success'])) {
    $login_success_message = $_SESSION['login_success'];
    unset($_SESSION['login_success']); // Remove it to avoid re-showing
}
?>
