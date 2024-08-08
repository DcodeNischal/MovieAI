<?php
include_once "Database.php";
session_start();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['number'];
    $city = $_POST['city'];
    $password = $_POST['password'];
    $filename = $_FILES['image']['name'];
    echo $filename;
    $location = 'admin/image/' . $filename;
    $status = 0;

    // generate random code of 6 digit
    $code = rand(100000, 999999);

    $file_extension = pathinfo($location, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);
    $image_ext = array('jpg', 'png', 'jpeg', 'gif');

    $response = 0;

    if (in_array($file_extension, $image_ext)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $location)) {
            $response = $location;
        }
    }
    echo $response;

    $status = 1;
    $insert_record = mysqli_query($conn, "INSERT INTO user (`username`, `email`, `mobile`, `city`, `password`, `image`, `status`, `code`) VALUES ('$username', '$email', '$mobile', '$city', '$password', '$filename', '$status', '$code')");
    
    if (!$insert_record) {
        echo "not inserted";
    } else {
        require_once 'sendemail.php';
    }
}
?>
