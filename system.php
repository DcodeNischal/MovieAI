<?php
session_start();
// Database connection
$host = 'localhost'; // Change if your DB is hosted elsewhere
$db   = 'moviebook';
$user = 'root'; // Change if necessary
$pass = ''; // Change if necessary

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Function to get recommended movies based on user ID
function getRecommendedMovies($userId) {
    global $pdo;

    // Step 1: Get genres of movies booked by the user
    $stmt = $pdo->prepare("
        SELECT DISTINCT m.categroy
        FROM customers c
        JOIN add_movie m ON c.movie = m.movie_name
        WHERE c.uid = ?
    ");
    $stmt->execute([$userId]);
    $genres = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (empty($genres)) {
        return [];
    }

    // Step 2: Get movies of the same genres
    $placeholders = implode(',', array_fill(0, count($genres), '?'));
    $stmt = $pdo->prepare("
        SELECT DISTINCT m.movie_name, m.categroy, m.image, m.language, m.id
        FROM add_movie m
        WHERE m.categroy IN ($placeholders)
    ");
    $stmt->execute($genres);
    $recommendedMovies = $stmt->fetchAll();

    return $recommendedMovies;
}

// Fetch user ID from session (ensure session is started)
$uname = $_SESSION['uname'];
$sql = "SELECT id FROM user WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$uname]);
$userId = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <!-- Your head content here -->
</head>
<body>

<div class="containerText" style="margin-left:240px; margin-top:110px;">
    <h2 class="text" style="margin-bottom:20px;">Recommended Movies</h2>
    <div class="row">
        <?php
        // Display recommended movies
        if ($userId > 0) {
            $recommendedMovies = getRecommendedMovies($userId);

            if (!empty($recommendedMovies)) {
                foreach ($recommendedMovies as $movie) {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="running-movie" style="width: 70%; border-radius:7px; box-shadow: 0 10px 15px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);">
                            <img src="admin/image/<?php echo htmlspecialchars($movie['image']); ?>" alt="" class="image-resize2" style="width: 80%; border-radius:7px; margin-top:35px;">
                            <h5><b><?php echo htmlspecialchars($movie['movie_name']); ?></b></h5>
                            <h6><center><?php echo htmlspecialchars($movie['language']); ?></center></h6>
                            <a href="movie_details.php?pass=<?php echo urlencode($movie['id']); ?>" class="btn btn-primary" style="margin-bottom:30px;background-color:orange; border-radius:10px; border:none">Book Now</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No recommended movies available.</p>";
            }
        } else {
            echo "<p>Please log in to see recommendations.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
