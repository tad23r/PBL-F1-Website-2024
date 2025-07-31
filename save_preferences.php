<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


session_start();
require 'db.php'; // Include database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $favorite_genre = $_POST['favorite_genre'];
    $favorite_author = $_POST['favorite_author'];
    $favorite_language = $_POST['favorite_language'];
    $additional_comments = $_POST['additional_comments'];

    // Optional: Get the logged-in user ID (if available)
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

    // Insert data into the database
    $query = "INSERT INTO user_preferences (user_id, favorite_genre, favorite_author, favorite_language, additional_comments)
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issss", $user_id, $favorite_genre, $favorite_author, $favorite_language, $additional_comments);

    if ($stmt->execute()) {
        // After successful insertion, update session to reflect user preferences
        $_SESSION['preferences_set'] = true; // Mark that preferences have been set

        // Redirect to home page after submission
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preferences - PeaKing Cinema</title>
  <link rel="stylesheet" href="assets/css/preferences.css">
</head>
<body>
  <header>
    <div class="logo">PeaKing Cinema 🍿</div>
    <a href="index.php"><button class="back-btn">Back to Home</button></a>
  </header>

  <main>
    <section class="form-section">
      <h1>User Preferences</h1>
      <p>Please fill in the form below to help us provide better recommendations tailored to your preferences.</p>
      
      <form action="save_preferences.php" method="POST" class="preferences-form">
        <!-- Favorite Genre -->
        <div class="form-group">
          <label for="favorite-genre">Favorite Genre</label>
          <select id="favorite-genre" name="favorite_genre" required>
            <option value="" disabled selected>Select your favorite genre</option>
            <option value="horror">Horror</option>
            <option value="sci-fi">Science Fiction</option>
            <option value="adventure">Adventure</option>
            <option value="action">Action</option>
            <option value="comedy">Comedy</option>
            <option value="documentary">Documentary</option>
          </select>
        </div>

        <!-- Favorite Author -->
        <div class="form-group">
          <label for="favorite-author">Favorite Author</label>
          <input type="text" id="favorite-author" name="favorite_author" placeholder="e.g., J.K. Rowling" required>
        </div>

        <!-- Favorite Language -->
        <div class="form-group">
          <label for="favorite-language">Preferred Language</label>
          <input type="text" id="favorite-language" name="favorite_language" placeholder="e.g., English" required>
        </div>

        <!-- Additional Comments -->
        <div class="form-group">
          <label for="additional-comments">Additional Comments</label>
          <textarea id="additional-comments" name="additional_comments" rows="4" placeholder="Share anything else you'd like us to know."></textarea>
        </div>

        <button type="submit" class="submit-btn">Submit Preferences</button>
      </form>
    </section>
  </main>

  <footer>
    <p>&copy; <?php echo date('Y'); ?> PeaKing Cinema. All rights reserved.</p>
  </footer>
</body>
</html>
