<?php
session_start();
include 'db_connection.php'; // Include your database connection

// Fetch user preferences from the database
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$favorite_genre = '';
if ($user_id) {
    $query = "SELECT * FROM user_preferences WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $favorite_genre = $row['favorite_genre']; // Get the favorite genre
    } else {
        echo "No preferences found for user.";
        exit;
    }
}

// Get movies of the selected genre from the movies table
$recommended_movies = [];
if ($favorite_genre) {
    $movie_query = "SELECT * FROM movies WHERE genre = ?";
    $stmt = $conn->prepare($movie_query);
    if ($stmt === false) {
        die('Error preparing movie query: ' . $conn->error);
    }

    $stmt->bind_param("s", $favorite_genre);
    $stmt->execute();
    $movie_result = $stmt->get_result();

    // Fetch movies of the selected genre
    while ($movie_row = $movie_result->fetch_assoc()) {
        $recommended_movies[] = $movie_row;
    }
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$favorite_genre = '';
$recommended_movies = []; // Array to store recommended movies
if ($user_id) {
    $query = "SELECT * FROM user_preferences WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $favorite_genre = $row['favorite_genre']; // Get the favorite genre
    } else {
        echo "No preferences found for user.";
        exit;
    }

    // Now fetch recommended movies based on the favorite genre
    if ($favorite_genre) {
        $movie_query = "SELECT * FROM movies WHERE genre LIKE ?";
        $movie_stmt = $conn->prepare($movie_query);
        if ($movie_stmt === false) {
            die('Error preparing movie statement: ' . $conn->error);
        }

        // Use the favorite genre in the query
        $genre_search = "%" . $favorite_genre . "%"; // Add wildcards for partial matches
        $movie_stmt->bind_param("s", $genre_search);
        $movie_stmt->execute();
        $movie_result = $movie_stmt->get_result();

        while ($movie_row = $movie_result->fetch_assoc()) {
            $recommended_movies[] = $movie_row; // Add each recommended movie to the array
        }
    }
}

$host = 'localhost'; // Database host
$username = 'root';  // Database username
$password = '';      // Database password
$dbname = 'peaking_cinema'; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db_connection.php'; // Include your database connection

// Fetch user preferences from the database
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$favorite_genre = '';
if ($user_id) {
    $query = "SELECT * FROM user_preferences WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $favorite_genre = $row['favorite_genre']; // Get the favorite genre
    } else {
        echo "No preferences found for user.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PeaKing Cinema</title>
  <link rel="stylesheet" href="assets/css/index.css">
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

  <main>
    <section class="featured-movie">
      <div class="movie-content">
        <img src="assets/img/pixel.jpg" alt="Pixels Movie Poster" class="movie-poster">
        <div class="movie-details">
          <h1>PIXELS</h1>
          <p class="tagline">#1 Recommended</p>
          <p class="description">
            When aliens misinterpret video feeds of classic arcade games as a declaration of war, they attack the Earth in the form of video games. The main protagonists, former World Champion Gamers, have to defend Earth from the video game monsters.
            </p>
          <div class="movie-info">
            <p><strong>Rating:</strong> M</p>
            <p><strong>Suitability:</strong> 95%</p>
            <p><strong>Genre:</strong> Sci-fi, Action, Comedy</p>
          </div>
          <button class="book-btn">Book Now</button>
        </div>
      </div>
    </section>


    <section class="movie-suggestions">
      <h2>For You</h2>
      <div class="movies">
        <!-- Dynamic Genre-based Suggestions -->
        <?php if ($favorite_genre && count($recommended_movies) > 0): ?>
          <h3>Suggested for you based on your favorite genre: <?= htmlspecialchars($favorite_genre) ?></h3>
          <?php foreach ($recommended_movies as $movie): ?>
            <a href="booking.php?id=<?= urlencode($movie['id']) ?>">
              <img src="<?= htmlspecialchars($movie['description']) ?>" alt="<?= htmlspecialchars($movie['name']) ?>" />
            </a>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No recommendations available for this genre. Try another genre!</p>
        <?php endif; ?>
      </div>
    </section>

    <section class="movie-genres">
    <h2>Action Movies</h2>
    <div class="movies">
        <a href="booking.php?id=1"><img src="assets/img/action/batman.jpeg" alt="Action Movie 1"></a>
        <a href="booking.php?id=2"><img src="assets/img/action/civilwar.jpeg" alt="Action Movie 2"></a>
        <a href="booking.php?id=3"><img src="assets/img/action/fallguy.jpg" alt="Action Movie 3"></a>
        <a href="booking.php?id=4"><img src="assets/img/action/gladiator.jpeg" alt="Action Movie 4"></a>
        <a href="booking.php?id=5"><img src="assets/img/action/inception.jpeg" alt="Action Movie 5"></a>
        <a href="booking.php?id=6"><img src="assets/img/action/johnwick.jpeg" alt="Action Movie 6"></a>
        <a href="booking.php?id=7"><img src="assets/img/action/kingsman.jpeg" alt="Action Movie 7"></a>
        <a href="booking.php?id=8"><img src="assets/img/action/LOTR.jpeg" alt="Action Movie 8"></a>
        <a href="booking.php?id=9"><img src="assets/img/action/matrix.jpeg" alt="Action Movie 9"></a>
        <a href="booking.php?id=10"><img src="assets/img/action/rebelridge.jpeg" alt="Action Movie 10"></a>
        <a href="booking.php?id=11"><img src="assets/img/action/thedarkknight.jpeg" alt="Action Movie 11"></a>
        <a href="booking.php?id=12"><img src="assets/img/action/transformersone.jpeg" alt="Action Movie 12"></a>
        <a href="booking.php?id=13"><img src="assets/img/action/twisters.jpg" alt="Action Movie 13"></a>
        <a href="booking.php?id=14"><img src="assets/img/action/wonderwoman.jpg" alt="Action Movie 14"></a>
    </div>

    <h2>Comedy Movies</h2>
    <div class="movies">
        <a href="booking.php?id=15"><img src="assets/img/comedy/bean.jpeg" alt="Comedy Movie 1"></a>
        <a href="booking.php?id=16"><img src="assets/img/comedy/3idiots.jpeg" alt="Comedy Movie 2"></a>
        <a href="booking.php?id=17"><img src="assets/img/comedy/brothers.jpeg" alt="Comedy Movie 3"></a>
        <a href="booking.php?id=18"><img src="assets/img/comedy/dearsanta.jpeg" alt="Comedy Movie 4"></a>
        <a href="booking.php?id=19"><img src="assets/img/comedy/flymetothemoon.jpeg" alt="Comedy Movie 5"></a>
        <a href="booking.php?id=20"><img src="assets/img/comedy/freelance.jpeg" alt="Comedy Movie 6"></a>
        <a href="booking.php?id=21"><img src="assets/img/comedy/gamenight.jpg" alt="Comedy Movie 7"></a>
        <a href="booking.php?id=22"><img src="assets/img/comedy/jackpot.jpeg" alt="Comedy Movie 8"></a>
        <a href="booking.php?id=23"><img src="assets/img/comedy/myoldass.jpeg" alt="Comedy Movie 9"></a>
        <a href="booking.php?id=24"><img src="assets/img/comedy/operationfortune.jpeg" alt="Comedy Movie 10"></a>
        <a href="booking.php?id=25"><img src="assets/img/comedy/rcikystanicky.jpeg" alt="Comedy Movie 11"></a>
        <a href="booking.php?id=26"><img src="assets/img/comedy/thefamilyplan.jpeg" alt="Comedy Movie 12"></a>
        <a href="booking.php?id=27"><img src="assets/img/comedy/unfrosted.jpeg" alt="Comedy Movie 13"></a>
        <a href="booking.php?id=28"><img src="assets/img/comedy/sweethearts.jpeg" alt="Comedy Movie 14"></a>
    </div>

    <h2>Sci-Fi Movies</h2>
    <div class="movies">
        <a href="booking.php?id=29"><img src="assets/img/sci-fi/arrival.jpeg" alt="Sci-Fi Movie 1"></a>
        <a href="booking.php?id=30"><img src="assets/img/sci-fi/attaca.jpeg" alt="Sci-Fi Movie 2"></a>
        <a href="booking.php?id=31"><img src="assets/img/sci-fi/bladerunner.jpeg" alt="Sci-Fi Movie 3"></a>
        <a href="booking.php?id=32"><img src="assets/img/sci-fi/contact.jpeg" alt="Sci-Fi Movie 4"></a>
        <a href="booking.php?id=33"><img src="assets/img/sci-fi/et.jpeg" alt="Sci-Fi Movie 5"></a>
        <a href="booking.php?id=34"><img src="assets/img/sci-fi/exmachina.jpeg" alt="Sci-Fi Movie 6"></a>
        <a href="booking.php?id=35"><img src="assets/img/sci-fi/jurassic.jpeg" alt="Sci-Fi Movie 7"></a>
        <a href="booking.php?id=36"><img src="assets/img/sci-fi/pacificrim.jpeg" alt="Sci-Fi Movie 8"></a>
        <a href="booking.php?id=37"><img src="assets/img/sci-fi/platform.jpeg" alt="Sci-Fi Movie 9"></a>
        <a href="booking.php?id=38"><img src="assets/img/sci-fi/playerone.jpg" alt="Sci-Fi Movie 10"></a>
        <a href="booking.php?id=39"><img src="assets/img/sci-fi/primer.jpeg" alt="Sci-Fi Movie 11"></a>
        <a href="booking.php?id=40"><img src="assets/img/sci-fi/spaceodyssey.jpeg" alt="Sci-Fi Movie 12"></a>
        <a href="booking.php?id=41"><img src="assets/img/sci-fi/terminator.jpeg" alt="Sci-Fi Movie 13"></a>
        <a href="booking.php?id=42"><img src="assets/img/sci-fi/warofworlds.jpeg" alt="Sci-Fi Movie 14"></a>
    </div>

    <h2>Adventure Movies</h2>
    <div class="movies">
        <a href="booking.php?id=43"><img src="assets/img/adventure/whitebird.jpeg" alt="Adventure Movie 1"></a>
        <a href="booking.php?id=44"><img src="assets/img/adventure/adventure.jpeg" alt="Adventure Movie 2"></a>
        <a href="booking.php?id=45"><img src="assets/img/adventure/alpha.jpeg" alt="Adventure Movie 3"></a>
        <a href="booking.php?id=46"><img src="assets/img/adventure/dnd.jpeg" alt="Adventure Movie 4"></a>
        <a href="booking.php?id=47"><img src="assets/img/adventure/interstellar.jpeg" alt="Adventure Movie 5"></a>
        <a href="booking.php?id=48"><img src="assets/img/adventure/dune.jpeg" alt="Adventure Movie 6"></a>
        <a href="booking.php?id=49"><img src="assets/img/adventure/jumanji.jpeg" alt="Adventure Movie 7"></a>
        <a href="booking.php?id=50"><img src="assets/img/adventure/kingkong.jpeg" alt="Adventure Movie 8"></a>
        <a href="booking.php?id=51"><img src="assets/img/adventure/raidersofthelostark.jpeg" alt="Adventure Movie 9"></a>
        <a href="booking.php?id=52"><img src="assets/img/adventure/spiritedaway.jpeg" alt="Adventure Movie 10"></a>
        <a href="booking.php?id=53"><img src="assets/img/adventure/thecovenant.jpeg" alt="Adventure Movie 11"></a>
        <a href="booking.php?id=54"><img src="assets/img/adventure/thelostcityofz.jpeg" alt="Adventure Movie 12"></a>
        <a href="booking.php?id=55"><img src="assets/img/adventure/themummy.jpeg" alt="Adventure Movie 13"></a>
        <a href="booking.php?id=56"><img src="assets/img/adventure/thewizardofoz.jpeg" alt="Adventure Movie 14"></a>
    </div>

    <h2>Horror Movies</h2>
    <div class="movies">
        <a href="booking.php?id=57"><img src="assets/img/horror/annabelle.jpeg" alt="Horror Movie 1"></a>
        <a href="booking.php?id=58"><img src="assets/img/horror/conjuring.jpeg" alt="Horror Movie 2"></a>
        <a href="booking.php?id=59"><img src="assets/img/horror/evildead.jpeg" alt="Horror Movie 3"></a>
        <a href="booking.php?id=60"><img src="assets/img/horror/halloween.jpeg" alt="Horror Movie 1"></a>
        <a href="booking.php?id=61"><img src="assets/img/horror/jaws.jpeg" alt="Horror Movie 2"></a>
        <a href="booking.php?id=62"><img src="assets/img/horror/ma.jpeg" alt="Horror Movie 3"></a>
        <a href="booking.php?id=63"><img src="assets/img/horror/mother.jpeg" alt="Horror Movie 1"></a>
        <a href="booking.php?id=84"><img src="assets/img/horror/rap.jpeg" alt="Horror Movie 2"></a>
        <a href="booking.php?id=64"><img src="assets/img/horror/ready.jpeg" alt="Horror Movie 3"></a>
        <a href="booking.php?id=65"><img src="assets/img/horror/ring.jpeg" alt="Horror Movie 1"></a>
        <a href="booking.php?id=66"><img src="assets/img/horror/salemslot.jpeg" alt="Horror Movie 2"></a>
        <a href="booking.php?id=67"><img src="assets/img/horror/scream.jpeg" alt="Horror Movie 3"></a>
        <a href="booking.php?id=68"><img src="assets/img/horror/theblairwitchproject.jpeg" alt="Horror Movie 1"></a>
        <a href="booking.php?id=69"><img src="assets/img/horror/thewitch.jpeg" alt="Horror Movie 1"></a>
    </div>

    <h2>Documentary Movies</h2>
    <div class="movies">
        <a href="booking.php?id=70"><img src="assets/img/documentary/14peaks.jpeg" alt="Documentary Movie 1"></a>
        <a href="booking.php?id=71"><img src="assets/img/documentary/22july.jpeg" alt="Documentary Movie 2"></a>
        <a href="booking.php?id=72"><img src="assets/img/documentary/curry.jpeg" alt="Documentary Movie 3"></a>
        <a href="booking.php?id=73"><img src="assets/img/documentary/deviltrail.jpg" alt="Documentary Movie 1"></a>
        <a href="booking.php?id=74"><img src="assets/img/documentary/dogmind.jpeg" alt="Documentary Movie 2"></a>
        <a href="booking.php?id=75"><img src="assets/img/documentary/invisible.jpeg" alt="Documentary Movie 3"></a>
        <a href="booking.php?id=76"><img src="assets/img/documentary/jennifer.jpg" alt="Documentary Movie 1"></a>
        <a href="booking.php?id=77"><img src="assets/img/documentary/killtiger.jpeg" alt="Documentary Movie 2"></a>
        <a href="booking.php?id=78"><img src="assets/img/documentary/menendez.jpeg" alt="Documentary Movie 3"></a>
        <a href="booking.php?id=79"><img src="assets/img/documentary/murder.jpg" alt="Documentary Movie 1"></a>
        <a href="booking.php?id=80"><img src="assets/img/documentary/ronaldo.jpeg" alt="Documentary Movie 2"></a>
        <a href="booking.php?id=81"><img src="assets/img/documentary/seawomen.jpeg" alt="Documentary Movie 3"></a>
        <a href="booking.php?id=82"><img src="assets/img/documentary/still.jpeg" alt="Documentary Movie 1"></a>
        <a href="booking.php?id=83"><img src="assets/img/documentary/willharper.jpeg" alt="Documentary Movie 1"></a>
    </div>
</section>
</main>

  <footer>
    <p>&copy; <?php echo date('Y'); ?> PeaKing Cinema. All rights reserved.</p>
  </footer>

  <script src="assets/js/script.js"></script>
</body>
</html>
