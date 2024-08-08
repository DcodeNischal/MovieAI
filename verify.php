<?php
session_start();

// Get values from the URL parameters
$email = $_GET['email'];
$code = $_GET['code'];

include_once "Database.php";

// Sanitize user input to prevent SQL injection
$email = mysqli_real_escape_string($conn, $email);
$code = mysqli_real_escape_string($conn, $code);

// Query to check if the user exists with the provided email and code
$sql = "SELECT * FROM user WHERE email = '$email' AND code = '$code'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Update the user status and clear the code
    $sql = "UPDATE user SET status = 1, code = '' WHERE email = '$email'";
    if (mysqli_query($conn, $sql)) {
        // Redirect to login page if the update was successful
        header('Location: login_form.php');
    } else {
        // If the update fails, set an error message and redirect to register page
        $_SESSION['msg'] = "Error verifying your email. Please try again.";
        header('Location: login_form.php');
    }
} else {
    // If no matching user is found, set an error message and redirect to register page
    $_SESSION['msg'] = "Your email has not been verified";
    header('Location: register.php');
}

?>
