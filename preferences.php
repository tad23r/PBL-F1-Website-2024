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
