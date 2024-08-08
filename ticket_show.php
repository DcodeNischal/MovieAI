<?php
session_start();
if (!isset($_SESSION['uname'])) {
    header("location:index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Summary</title>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

</head>
<body>
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-6"><b> YOUR TICKET</h1>
        </div>
    </div>
    <div class="row" style="margin-left:60px;">
         <div class="col-lg-6 mx-auto">
            <div class="card" style="width:550px; border:none; border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25); ">
                <div class="card-header" style="background-color:white; ">
                    <center>
                        <img src="img/image.png" width="20%">
                        <h3>Kuber <span style="color:red; font-size:20px;">cinemas</span></h3>
                    </center>
                    <?php
                    include "Database.php";
                    // Ensure the custemer_id is set in the session
                    if (!isset($_SESSION['custemer_id'])) {
                        echo "Customer ID not set.";
                        exit();
                    }

                    $result = mysqli_query($conn, "SELECT c.movie, c.booking_date, c.show_time, c.seat, c.totalseat, c.price, c.payment_date, c.custemer_id, u.username, u.email, u.mobile, u.city, t.theater 
                                                  FROM customers c 
                                                  INNER JOIN user u ON c.uid = u.id 
                                                  INNER JOIN theater_show t ON c.show_time = t.show 
                                                  WHERE c.custemer_id = '".$_SESSION['custemer_id']."'");
                    $row = mysqli_fetch_array($result);

                    // Format the dates
                    $payment_date = date("D, d M Y", strtotime($row['payment_date']));
                    $booking_date = date("D, d M Y", strtotime($row['booking_date']));
                    ?>
                    <table>
                        <tr>
                            <td>NCIT,Balkumari,Lalitpur</td>
                            <td style="padding: 12px 2px 12px 155px;">Customer Id: <?php echo htmlspecialchars($row['custemer_id']); ?></td>
                        </tr>
                        <tr>
                            <td>+977-9823192305</td>
                            <td style="padding: 1px 2px 1px 155px; ">Date: <?php echo htmlspecialchars($payment_date); ?></td>
                        </tr>
                    </table>
                    <hr>
                    <center><h3>Movie Name: <?php echo htmlspecialchars($row['movie']); ?></h3></center>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th style="padding: 1px 105px;">City</th>
                        </tr>
                        <tr>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td style="padding: 12px 105px;"><?php echo htmlspecialchars($row['city']); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th style="padding: 1px 105px;">Phone</th>
                        </tr>
                        <tr>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td style="padding: 12px 105px;"><?php echo htmlspecialchars($row['mobile']); ?></td>
                        </tr>
                        <tr>
                            <th>Payment Date</th>
                            <th style="padding: 1px 105px;">Payment Amount</th>
                        </tr>
                        <tr>
                            <td><?php echo htmlspecialchars($payment_date); ?></td>
                            <td style="padding: 12px 105px;">RS. <?php echo htmlspecialchars($row['price']); ?>/-</td>
                        </tr>
                    </table>
                    <hr>
                    <h4>BOOKING DETAILS:</h4>
                    <table>
                        <tr>
                            <th>Theater</th>
                            <th style="padding: 0px 2px 0px 60px">Date</th>
                            <th style="padding-left: 30px;">Time</th>
                        </tr>
                        <tr>
                            <td>No. <?php echo htmlspecialchars($row['theater']); ?></td>
                            <td style="padding: 12px 2px 12px 60px"><?php echo htmlspecialchars($booking_date); ?></td>
                            <td style="padding-left: 30px;"><?php echo htmlspecialchars($row['show_time']); ?></td>
                        </tr>
                        <tr>
                            <th>Seats</th>
                            <th style="padding: 0px 2px 0px 60px;">Total Seats</th>
                        </tr>
                        <tr>
                            <td style="padding-right: 150px;"><?php echo htmlspecialchars($row['seat']); ?></td>
                            <td style="padding: 12px 2px 12px 60px"><?php echo htmlspecialchars($row['totalseat']); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <button id="downloadPdf" class="btn btn-primary" style="width:200px; background-color:orange; color:white; margin-top:20px; margin-left:550px; border-radius:15px; height:40px; border:none;">
    Download Ticket
</button>

</div>

<script>
document.getElementById('downloadPdf').addEventListener('click', function() {
    // Select the element to be converted to PDF
    html2canvas(document.querySelector('.card')).then(function(canvas) {
        // Create a new jsPDF instance
        var pdf = new jsPDF('p', 'pt', 'a4');
        
        // Convert the canvas to an image
        var imgData = canvas.toDataURL('image/png');
        
        // Add the image to the PDF
        pdf.addImage(imgData, 'PNG', 10, 10);
        
        // Save the PDF
        pdf.save('ticket.pdf');
    });
});
</script>
</body>
</html>
