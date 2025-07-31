<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "peaking_cinema"; // Updated to your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $movie_id = $_GET['id'];
} else {
    // If 'id' is not set, redirect or show an error
    echo "Movie ID is missing!";
    exit; // Stop the script from executing further
}

// Query to fetch movie details by id
$sql = "SELECT * FROM movies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $movie_id); // 'i' for integer
$stmt->execute();
$result = $stmt->get_result();

// Fetch the movie details
$movie = $result->fetch_assoc();

if (!$movie) {
    // Handle case where movie was not found
    echo "Movie not found!";
    exit;
}

// Close the database connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Movie - <?php echo htmlspecialchars($movie['name']); ?></title>
    <link rel="stylesheet" href="assets/css/booking.css">
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
  <!-- Booking Section -->
  <div class="booking-container">
    <!-- Seating Section -->
    <div class="booking-left">
      <h2>Select Your Seats</h2>
      <div class="seating">
        <!-- Front Rows -->
        <?php for ($row = 1; $row <= 8; $row++): ?>
          <div class="row">
            <?php for ($seat = 1; $seat <= 10; $seat++): ?>
              <div class="seat"><?php echo $row . '-' . $seat; ?></div>
            <?php endfor; ?>
          </div>
        <?php endfor; ?>

        <!-- Family Seats (Back Row) -->
        <div class="row">
          <?php for ($seat = 1; $seat <= 4; $seat++): ?>
            <div class="seat family"><?php echo 'Fam ' . $seat; ?></div>
          <?php endfor; ?>
        </div>
      </div>
    </div>

      <!-- Movie Description Section -->
      <div class="booking-right">
        <h2>Show Details</h2>
        <div class="movie-info">
          <div class="movie-text">
            <p><strong>Movie:</strong> <?php echo htmlspecialchars($movie['name']); ?></p>
            <p><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></p>
            <p><strong>Rating:</strong> <?php echo htmlspecialchars($movie['rating']); ?></p>
            <p><strong>Duration:</strong> <?php echo htmlspecialchars($movie['duration']) . ' minutes'; ?></p>
            <p><strong>Time:</strong> 6:00 PM</p>
            <p><strong>Price:</strong> $15.00</p>
            <button class="book-btn">Book Now</button>
          </div>
          <div class="movie-image">
            <img src="<?php echo htmlspecialchars($movie['description']); ?>" alt="Movie Image" style="height: 300px">
          </div>
        </div>
      </div>

  </div>

  <!-- Footer -->
  <footer>
    <p>&copy; <?php echo date('Y'); ?> PeaKing Cinema. All rights reserved.</p>
  </footer>

  <script src="assets/js/script.js"></script>
</body>
</html>
