<?php 
session_start();  
if (!isset($_SESSION['uname'])) {
    header("location:index.php");
    exit();
}
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Payment Page">
    <meta name="keywords" content="Payment, booking">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">
    <style>
        .front {
            margin: 5px 4px 45px 0;
            background-color: #EDF979;
            color: #000000;
            padding: 9px 0;
            border-radius: 3px;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-6">BOOKING SUMMARY</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="tab-content">
                        <div class="row">
                            <?php
                            include_once 'Database.php'; 

                            $username = $_SESSION['uname'];
                            $price = 0; // Initialize price variable
                            if (isset($_POST['submit'])) {
                                $show = $_POST['show'];
                                $result = mysqli_query($conn, "SELECT u.username, u.email, u.mobile, u.city, t.theater, t.show_date FROM user u INNER JOIN theater_show t ON u.username = '".$username."' WHERE t.show = '".$show."'");
                                
                                // Get seats from POST request
                                $seats = isset($_POST["seat"]) && is_array($_POST["seat"]) ? $_POST["seat"] : [];
                                $seats1 = implode(",", $seats);
                                $totalSeats = count($seats);

                                // Calculate price
                                for ($i = 1; $i <= 12; $i++) {
                                    $I = "I" . $i;
                                    $H = "H" . $i;
                                    $G = "G" . $i;
                                    $F = "F" . $i;
                                    $E = "E" . $i;
                                    $D = "D" . $i;
                                    $C = "C" . $i;
                                    $B = "B" . $i;
                                    $A = "A" . $i;

                                    if (in_array($I, $seats)) $price += 150;
                                    if (in_array($H, $seats)) $price += 150;
                                    if (in_array($G, $seats)) $price += 150;
                                    if (in_array($F, $seats)) $price += 250;
                                    if (in_array($E, $seats)) $price += 250;
                                    if (in_array($D, $seats)) $price += 250;
                                    if (in_array($C, $seats)) $price += 250;
                                    if (in_array($B, $seats)) $price += 250;
                                    if (in_array($A, $seats)) $price += 550;
                                }

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo '<div class="col-lg-6">
                                            Your Username: ' . htmlspecialchars($row['username']) . '<br>
                                            Phone no.: ' . htmlspecialchars($row['mobile']) . '<br>
                                            Movie Name: ' . htmlspecialchars($_POST['movie']) . '<br>
                                            Seats: ' . htmlspecialchars($seats1) . '<br>
                                            Payment Date: ' . date("D-m-y", strtotime('today')) . '
                                            </div>
                                            <div class="col-lg-6">
                                            Email: ' . htmlspecialchars($row['email']) . '<br>
                                            City: ' . htmlspecialchars($row['city']) . '<br>
                                            Theater: ' . htmlspecialchars($row['theater']) . '<br>  
                                            Total Seats: ' . htmlspecialchars($totalSeats) . '<br>
                                            Time: ' . htmlspecialchars($_POST['show']) . '<br>
                                            Booking Date: ' . htmlspecialchars($row['show_date']) . '
                                            </div>';
                                    }
                                } else {
                                    echo "No booking details found.";
                                }
                            }  
                            ?>  
                            <input type="hidden" id="movie" value="<?php echo htmlspecialchars($_POST['movie']); ?>">
                            <input type="hidden" id="time" value="<?php echo htmlspecialchars($_POST['show']); ?>">
                            <input type="hidden" id="seat" value="<?php echo htmlspecialchars($seats1); ?>">
                            <input type="hidden" id="totalseat" value="<?php echo htmlspecialchars($totalSeats); ?>">
                            <input type="hidden" id="price" value="<?php echo htmlspecialchars($price); ?>">
                        </div>
                        
                            <div class="col-lg-6">
                                <div class="seatCharts-container">
                                    <div class="front">
                                        <font text-align="left">&nbsp;&nbsp;&nbsp;Amount Payable: </font>
                                        <font text-align="right">Rs.<?php echo htmlspecialchars($price); ?>/-</font>
                                    </div>
                                </div>
                            </div>
                            <div id="msg"></div>
                            
                            <div class="card-footer">
                                <button type="button" id="payment" class="subscribe btn btn-primary btn-block shadow-sm"> Confirm Payment </button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for payment -->
<form id="paymentForm" method="POST" action="esewa/demo.php" style="display:none;">
    <input type="hidden" name="amount" id="hiddenAmount">
    <input type="hidden" name="deliveryCharge" value="0">
    <input type="hidden" name="serviceCharge" value="0">
    <input type="hidden" name="taxAmount" value="0">
    <input type="hidden" name="totalAmount" id="hiddenTotalAmount">
    <input type="hidden" name="productCode" value="ESEWAPAY">
    <input type="hidden" name="returnUrl" id="hiddenReturnUrl">
    <input type="hidden" name="failedUrl" value="http://localhost.com/MovieAI/">
</form>

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
<script type="text/javascript">
$(document).ready(function() {
    $("#payment").click(function() {
        var movie = $("#movie").val().trim();
        var time = $("#time").val().trim();
        var seat = $("#seat").val().trim();
        var totalseat = $("#totalseat").val().trim();
        var price = $("#price").val().trim();

        // Populate hidden form
        $("#hiddenAmount").val(price);
        $("#hiddenTotalAmount").val(price);
        $("#hiddenReturnUrl").val('http://localhost.com/MovieAI/ticket_show.php?id=<?php echo $_SESSION['uname']; ?>');

        

        $.ajax({
      url:'payment_form.php',
      type:'post',
      data:{
            movie:movie,
            time:time,
            seat:seat,
            totalseat:totalseat,
            price:price
            },
      success:function(response){
          if(response == 1){
            // Submit hidden form
        $("#paymentForm").submit();
          }
      }
    });
    });
});
</script>
</body>
</html>
