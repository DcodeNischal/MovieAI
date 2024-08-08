<?php

include "Database.php";
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if username and password are set and not empty
if (!isset($_POST['username']) || !isset($_POST['password']) || $_POST['username'] == '' || $_POST['password'] == '') {
    foreach ($_POST as $key => $value) {
        echo "<li>Please enter " . htmlspecialchars($key) . ".</li>";
    }
    exit();
}

$uname = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Debugging: Print input values
echo "Username: $uname<br>";
echo "Password: $password<br>";

// Query to select the user with the provided username, password, and verified status
$sql_query = "SELECT count(*) as cntUser FROM user WHERE username='$uname' AND password='$password' AND status='1'";
$result = mysqli_query($conn, $sql_query);

// Check if the query executed successfully
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $count = $row['cntUser'];

    // Debugging: Print query result count
    echo "Query Result Count: $count<br>";

    if ($count > 0) {
        $_SESSION['uname'] = $uname;
        echo "<script>window.location='index.php';</script>";
    } else {
        echo "<script>window.location='login_form.php?error=Invalid Credentials or Email Not Verified';</script>";
    }
} else {
    // Handle query execution error
    echo "<li>Database query failed: " . mysqli_error($conn) . "</li>";
}
?>
