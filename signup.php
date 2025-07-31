<?php
session_start();
require 'db.php'; // Include database connection file

// Handle form submission for registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($email) && !empty($password)) {
        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username or email already exists.";
        } else {
            // Hash password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert data into the database
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                echo "<script>alert('Account created successfully! You can now log in.');</script>";
                header("Location: login.php"); // Redirect to login page after successful sign-up
                exit();
            } else {
                $error = "Error creating account. Please try again.";
            }
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
  <title>Sign Up - PeaKing Cinema</title>
  <link rel="stylesheet" href="assets/css/signup.css">
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo">PeaKing Cinema 🍿</div>
    <a href="login.php"><button class="login-btn">Login</button></a>
  </header>

  <!-- Sign Up Form Section -->
  <div class="login-section">
    <div class="login-form">
      <h2>Sign Up</h2>
      <form action="signup.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Sign Up">
      </form>
      <?php
        if (isset($error)) {
            echo "<p style='color: red; font-size: 14px;'>$error</p>";
        }
      ?>
      <p style="font-size: small;">Already have an account? <a href="login.php"> Login here</a></p>
    </div>
  </div>

  <footer>
    <p>&copy; <?php echo date('Y'); ?> PeaKing Cinema. All rights reserved.</p>
  </footer>

  <script src="assets/js/script.js"></script>
</body>
</html>
