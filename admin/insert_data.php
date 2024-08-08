<?php
include_once("Database.php");

if (isset($_POST['submit'])) {
    $movie_name = mysqli_real_escape_string($conn, $_POST['movie_name']);
    $directer_name = mysqli_real_escape_string($conn, $_POST['directer_name']);
    $release_date = mysqli_real_escape_string($conn, $_POST['release_date']);
    $categroy = mysqli_real_escape_string($conn, $_POST['category']);
    $language = mysqli_real_escape_string($conn, $_POST['language']);
    $tailer = mysqli_real_escape_string($conn, $_POST['tailer']);
    $action = mysqli_real_escape_string($conn, $_POST['action']);
    $decription = mysqli_real_escape_string($conn, $_POST['decription']);
    $show = mysqli_real_escape_string($conn, implode(',', $_POST['show']));
    $filename = $_FILES['img']['name'];

    $location = 'image/' . $filename;

    $file_extension = pathinfo($location, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);
    $image_ext = array('jpg', 'png', 'jpeg', 'gif');

    $response = 0;

    if (in_array($file_extension, $image_ext)) {
        if (move_uploaded_file($_FILES['img']['tmp_name'], $location)) {
            $response = $location;
        }
    }

    if ($response != 0) {
        $status = 1;
        $insert_record = mysqli_query($conn, "INSERT INTO add_movie (`movie_name`,`directer`,`release_date`,`categroy`,`language`,`you_tube_link`,`action`,`decription`,`show`,`image`,`status`) VALUES ('$movie_name', '$directer_name', '$release_date', '$categroy', '$language', '$tailer', '$action', '$decription', '$show', '$filename', '$status')");

        if (!$insert_record) {
            echo "unsuccessful";
        } else {
            echo "<script> window.location.href='Add-movie.php' </script>";
        }
    } else {
        echo "Image upload failed";
    }
}
?>
