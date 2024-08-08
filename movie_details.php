<?php
session_start();
include_once 'Database.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_GET['pass'];
$result = mysqli_query($conn, "SELECT * FROM add_movie WHERE id = '$id'");

// Check if the query executed correctly
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_array($result);

// Check if the row is fetched correctly
if (!$row) {
    die("No data found for the given ID.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Movie Details">
    <meta name="keywords" content="Movie, details">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo htmlspecialchars($row['movie_name']); ?></title>

    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/fonts-googleapis.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
<?php include("header.php"); ?>

<section id="aboutUs">
    <div class="container">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM add_movie WHERE id = '$id'");

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['id'];
                ?>
                <div class="row feature design">
                    <div class="col-lg-5">
                        <img src="admin/image/<?php echo htmlspecialchars($row['image']); ?>" class="resize-detail" alt="" style="padding:30px; object-fit:cover; border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);">
                    </div>
                    <div class="col-lg-7">
                        <table class="content-table" style="border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25); ">
                            <thead>
                            <tr style="border:none;">
                                <th colspan="2" style="background-color:orange;">Movie Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr style="border:none;">
                                <td>Movie Name</td>
                                <td><?php echo htmlspecialchars($row['movie_name']); ?></td>
                            </tr>
                            <tr  style="background-color:white;border:none;">
                                <td>Release Date</td>
                                <td><?php echo htmlspecialchars($row['release_date']); ?></td>
                            </tr>
                            <tr style="border:none;">
                                <td>Director Name</td>
                                <td><?php echo htmlspecialchars($row['directer']); ?></td>
                            </tr>
                            <tr style="background-color:white;border:none;">
                                <td>Category</td>
                                <td><?php echo htmlspecialchars($row['categroy']); ?></td>
                            </tr>
                            <tr style="border:none;">
                                <td>Language</td>
                                <td><?php echo htmlspecialchars($row['language']); ?></td>
                            </tr>
                            <tr style="background-color:white; border:none;">
                                <td>Trailer</td>
                                <td><a data-toggle="modal" style="cursor:pointer; color:orange;" data-target="#trailer_modal<?php echo $row['id']; ?>">View Trailer</a></td>
                                <div class="modal fade" id="trailer_modal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document" >
                                        <div class="modal-content" style="border:none; width: 1300px; margin-left:-350px; margin-top:200px;">
                                            <embed style="width: 100%; height: 850px;" src="<?php echo htmlspecialchars($row['you_tube_link']); ?>"></embed>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            </tbody>
                        </table>
                        <?php if ($row['action'] == "running") { ?>
                            <div class="time-link">
                                <h4 style="margin-top:60px;">Show Book Ticket:</h4><br>
                                <?php
                                $time = $row['show'];
                                $movie = $row['movie_name'];
                                $set_time = explode(",", $time);
                                $res = mysqli_query($conn, "SELECT * FROM theater_show");

                                if (!$res) {
                                    die("Query failed: " . mysqli_error($conn));
                                }

                                if (mysqli_num_rows($res) > 0) {
                                    $show_times = [];
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        if (isset($row['show_date']) && in_array($row['show'], $set_time)) {
                                            $show_times[$row['show_date']][] = $row['show'];
                                        }
                                    }

                                    foreach ($show_times as $date => $times) {
                                        echo "<strong>$date:</strong><br>";?>
                                         <?php foreach ($times as $show) {
                                            echo "<a href='seatbooking.php?movie=$movie&time=$show&date=$date'><button style='background-color:orange;color:white; margin-top:20px; margin-bottom:20px;
                                            border:none; padding:10px;
                                            border-radius:15px;box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);'>$show</button></a> ";
                                        } ?>  <?php
                                        echo "<br>";
                                    }
                                } else {
                                    echo "No shows available.";
                                }
                                ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="description">
                    <h4>Description</h4>
                    <p>
                        Jeff Lang (Tobey Maguire), an OBGYN, and his wife Nealy (Elizabeth Banks), who owns a small shop, live in Seattle with their two-year-old son named Miles. Considering a second child, they decide to enlarge their small home and lay expensive new grass in their backyard. Worms in the grass attract raccoons, who destroy the grass, and Jeff goes to great lengths to get rid of the raccoons, mixing poison with a can of tuna. Their neighbor Lila (Laura Linney) tells Jeff that her cat Matthew is missing, and Jeff does not yet realize he may be responsible.
                    </p>
                </div>
                <?php
            }
        } else {
            echo "No movie found for the given ID.";
        }
        ?>
    </div>
</section>

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
