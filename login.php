<?php
session_start();
require 'db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Retrieve user data from the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id']; // Store user ID for preferences
                header("Location: preferences.php"); // Redirect to preferences page
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "User not found.";
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - PeaKing Cinema</title>
  <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo">PeaKing Cinema 🍿</div>
    <a href="signup.php"><button class="signup-btn">Sign Up</button></a>
  </header>

  <!-- Login Form Section -->
  <main class="login-section">
    <div class="login-form">
      <h2>Login</h2>
      <form action="login.php" method="POST">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="submit-btn">Login</button>
      </form>
      <?php
        if (isset($error)) {
            echo "<p class='error-message'>$error</p>";
        }
      ?>
      <p class="signup-link">Don't have an account? <a href="signup.php">Sign up here</a></p>
    </div>
  </main>

  <!-- Footer -->
  <footer>
    <p>&copy; <?php echo date('Y'); ?> PeaKing Cinema. All rights reserved.</p>
  </footer>

</body>
</html>
