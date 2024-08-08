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

if(isset($_SESSION['uname'])){
    // Fetch user ID from session (ensure session is started)
$uname = $_SESSION['uname'];
$sql = "SELECT id FROM user WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$uname]);
$userId = $stmt->fetchColumn();
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KuBer Cinemas</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">    
</head>

<body>

<?php include("header.php"); ?>

<div class="container2">
   <img src="image/main.gif" alt="" class="image-resize" style="box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);">
</div>

<div class="containerText" style="margin-left:240px; margin-top:110px;">
    <h2>Now Showing</h2>
    <div class="row">
<?php
// Display running movies
$result = mysqli_query($conn, "SELECT * FROM add_movie WHERE action = 'running'");

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_array($result)) {
?>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="running-movie" style="width: 70%; border-radius:7px; box-shadow: 0 10px 15px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);">
                <img src="admin/image/<?php echo $row['image']; ?>" alt="" class="image-resize2" style="width: 80%; border-radius:7px; margin-top:35px;">
                <div class="top-right" style="margin-right:170px; margin-top:455px; cursor:pointer">
                    <a data-toggle="modal" data-target="#tailer_modal<?php echo $row['id'];?>"><img src="img/icon/play.png"></a>
                </div>
                <h5><b><?php echo $row['movie_name'];?></b></h5>
                <h6><center><?php echo $row['language'];?></center></h6>
                <a href="movie_details.php?pass=<?php echo $row['id'];?>" class="btn btn-primary" style="margin-bottom:30px;background-color:orange; border-radius:10px; border:none">Book Now</a>
            </div>
        </div>

        <div class="modal fade" id="tailer_modal<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 1500px; margin-left:-500px;">
                    <embed style="width: 1500px; height: 850px;" src="<?php echo $row['you_tube_link'];?>"></embed>
                </div>
            </div>
        </div>
<?php
  }
}
?>
    </div>
</div>

<div class="containerText" style="margin-left:240px; margin-top:110px;">
    <h2 class="text" style="margin-bottom:20px;">Upcoming Movies</h2>
    <div class="row">
<?php
// Display upcoming movies
$result = mysqli_query($conn, "SELECT * FROM add_movie WHERE action = 'upcoming'");

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_array($result)) {
?>
        <div class="image-box">
            <div class="col-lg-2 col-md-3 col-sm-6">
                <div class="card" style="width: 16rem; height: 400px; margin:40px; box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);">
                    <img class="card-img-top image-resize4" src="admin/image/<?php echo $row['image']; ?>" alt="Card image cap" style="padding:30px; height:330px;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['movie_name'];?></h5>
                        <p class="card-text">Director: <?php echo $row['directer'];?></p>
                    </div>
                </div>
            </div>
        </div>
<?php
  }
}
?>
    </div>
</div>

<div class="containerText" style="margin-left:240px; margin-top:110px;">
    <h2 class="text" style="margin-bottom:20px;">Recommended Movies</h2>
    <div class="row">
        <?php
        // Display recommended movies
        if ($userId > 0 && isset($_SESSION['uname'])) {
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

<?php include("footer.php"); ?>

<!-- Js Plugins -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.nice-select.min.js"></script>
<script src="js/jquery.nicescroll.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/mixitup.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
