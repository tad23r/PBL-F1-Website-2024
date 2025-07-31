<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PeaKing Cinema - Portfolio</title>
  <link rel="stylesheet" href="assets/css/portfolio.css">
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

  <section class="bio-section">
    <div class="bio-container">
        <!-- Person 1 -->
        <div class="bio-card">
            <img src="assets/img/faqih.jpg">
            <h2>Biodata - Developer 1</h2>
            <p><strong>Name:</strong>Muhammad Faqih Hazim</p>
            <p><strong>Age:</strong>13</p>
            <p><strong>Location:</strong>KPPN, Seremban</p>
            <p><strong>Profession:</strong>Developer/Student</p>
            <h3>Education</h3>
            <ul>
                <li>Enrolled in DIP course.</li>
            </ul>
            <h3>Contact Information</h3>
            <p><strong>Email:</strong>faqihazim1305@gmail.com</p>
            <p><strong>Phone:</strong>+60-10267 57293</p>
        </div>

        <!-- Person 2 -->
        <div class="bio-card">
            <img src="assets/img/asyraf.jpg">
            <h2>Biodata - Developer 2</h2>
            <p><strong>Name:</strong>Muhammad Asyraf</p>
            <p><strong>Age:</strong>13</p>
            <p><strong>Location:</strong>KPPN, Seremban</p>
            <p><strong>Profession:</strong>Developer/Student</p>
            <h3>Education</h3>
            <ul>
                <li>Enrolled in DIP course.</li>
            </ul>
            <h3>Contact Information</h3>
            <p><strong>Email:</strong>asyraf.mf21@gmail.com</p>
            <p><strong>Phone:</strong>+60-1417 7953</p>
        </div>
    </div>
  </section>

  <footer>
    <p>&copy; <?php echo date('Y'); ?> PeaKing Cinema. All rights reserved.</p>
  </footer>

  <script src="assets/js/script.js"></script>
</body>
</html>
