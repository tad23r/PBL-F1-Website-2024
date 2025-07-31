<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - PeaKing Cinema</title>
  <link rel="stylesheet" href="assets/css/contact.css">
</head>
<body>

<header>
    <!-- Hamburger Menu Icon -->
    <div class="hamburger-menu">&#9776;</div>
    <div class="logo">PeaKing Cinema 🍿</div>
    <?php if (!isset($_SESSION['username'])): ?>
      <a href="login.php"><button class="login-btn">Login</button></a>
    <?php else: ?>
      <div class="user-info">
        <form action="logout.php" method="POST" style="display:inline;">
          <button type="submit" class="login-btn">Logout</button>
        </form>
      </div>
    <?php endif; ?>
  </header>

  <!-- Sidebar Navigation -->
  <div id="sidebar" class="sidebar">
    <nav>
      <a href="index.php">Home</a>
      <a href="portfolio.php">Portfolio</a>
      <a href="contact.php">Contact</a>
    </nav>
  </div>

  <section class="contact-section">
    <h2>Contact Us</h2>
    <form action="contact.php" method="POST">
      <input type="text" name="name" placeholder="Your Name" required>
      <input type="email" name="email" placeholder="Your Email" required>
      <textarea name="message" placeholder="Your Message" required></textarea>
      <input type="submit" value="Send Message">
    </form>
  </section>

  <footer>
    <p>&copy; <?php echo date('Y'); ?> PeaKing Cinema. All rights reserved.</p>
  </footer>

  <script src="assets/js/script.js"></script>
</body>
</html>
