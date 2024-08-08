<?php
session_start();
include "Database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $code = mysqli_real_escape_string($conn, $_POST['code']);
    $newpassword = mysqli_real_escape_string($conn, $_POST['newpassword']);

    // Validate reset code
    $sql = "SELECT * FROM user WHERE email = '$email' AND code = '$code'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Update password and clear the reset code
        $sql = "UPDATE user SET password = '$newpassword', code = '' WHERE email = '$email'";
        if (mysqli_query($conn, $sql)) {
            echo "Password has been reset successfully. <a href='login_form.php'>Login now</a>";
        } else {
            echo "Failed to reset password. Please try again.";
        }
    } else {
        echo "Invalid reset code.";
    }
}
?>
