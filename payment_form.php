<?php
session_start();
include "Database.php";
	$movie = mysqli_real_escape_string($conn,$_POST['movie']);
	$time = mysqli_real_escape_string($conn,$_POST['time']);
	$seat = mysqli_real_escape_string($conn,$_POST['seat']);
	$totalseat = mysqli_real_escape_string($conn,$_POST['totalseat']);
	$price = mysqli_real_escape_string($conn,$_POST['price']);

	$result = mysqli_query($conn,"SELECT * FROM user WHERE username = '".$_SESSION['uname']."'");
	 if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_array($result)) {
      	$uid=$row['id'];
      	}
      }
      $custemer_id= mt_rand();
      $payment = date("D-m-y ",strtotime('today'));
      $booking = date("D-m-y ",strtotime('tomorrow'));
      
      $_SESSION['custemer_id'] = $custemer_id;
	$insert_record=mysqli_query($conn,"INSERT INTO customers (`uid`,`movie`,`show_time`,`seat`,`totalseat`,`price`,`payment_date`,`booking_date`,`custemer_id`)VALUES('".$uid."','".$movie."','".$time."','".$seat."','".$totalseat."','".$price."','".$payment."','".$booking."','".$custemer_id."')");

	if(!$insert_record)
	{
		echo 2;
	}else{
		echo 1;
	}	
?>