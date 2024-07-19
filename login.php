<?php
include "Database.php";
session_start();

if (!isset($_POST['username']) || !isset($_POST['password']) || $_POST['username'] == '' || $_POST['password'] == '') {
    foreach ($_POST as $key => $value) {
        echo "<li>Please enter " . htmlspecialchars($key) . ".</li>";
    }
    exit();
}

$uname = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$sql_query = "SELECT count(*) as cntUser FROM user WHERE username='$uname' AND password='$password'";
$result = mysqli_query($conn, $sql_query);
$row = mysqli_fetch_array($result);
$count = $row['cntUser'];

if ($count > 0) {
    $_SESSION['uname'] = $uname;
    echo "<script>window.location='index.php';</script>";
} else {
    echo "<li>Invalid Username or Password.</li>";
}
?>
