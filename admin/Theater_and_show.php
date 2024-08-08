<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Theater and Show Page</title>

    <?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['admin'])) {
    header("location:login.php");
    exit();
}

include_once 'Database.php'; // Ensure this file includes the database connection setup

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addshow'])) {
        $theater_name = $_POST['theater_name'];
        $show = $_POST['show'];

        $sql = "INSERT INTO theater_show (`show`, theater) VALUES ('$show', '$theater_name')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Show added successfully');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    if (isset($_POST['deletetime'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM theater_show WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Show deleted successfully');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    if (isset($_POST['updatetime'])) {
        $id = $_POST['e_id'];
        $theater_name = $_POST['edit_screen'];
        $show = $_POST['edit_time'];

        $sql = "UPDATE theater_show SET `show`='$show', theater='$theater_name' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Show updated successfully');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        .container-fluid{
            margin-top:40px;
            
        }
         .btn{
            background-color:orange;
            border:none;
            margin-top:40px;
            border-radius:10px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);
            padding:10px;
            margin:15px;
        }
        .btn:hover{
            background-color:orange;

        }
        .table-responsive{
        margin-top:25px;
        
      }
      .table-responsive .table-striped td{
        background-color: white;
        font-size:17px;
      }
      .table-responsive .table-striped th{
        border:none;
        font-size:20px;


      }
    </style>

</head>
<body>
    <?php include_once("./templates/top.php"); ?>
    <?php include_once("./templates/navbar.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <?php include "./templates/sidebar.php"; ?>

            <div class="row">
                <div class="col-10">
                    <h2>Show Details</h2>
                </div>
                <div class="col-2">
                    <button data-toggle="modal" data-target="#add_show" class="btn btn-primary btn-sm">Add Show</button>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Show</th>
                            <th>Theater</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="product_list">
                     <?php
                      $result = mysqli_query($conn, "SELECT * FROM theater_show");

                      if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                          ?>
                          <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['show']; ?></td>
                            <td><?php echo $row['theater']; ?></td>
                            <td>
                                <button data-toggle="modal" data-target="#update_show_<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit Show</button>
                                <button data-toggle="modal" data-target="#delete_show_<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete Show</button>
                             </td>
                          </tr>

                          <!-- Update Show Modal -->
                          <div class="modal fade" id="update_show_<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Edit Show</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form id="update_show_form_<?php echo $row['id']; ?>" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="e_id" value="<?php echo $row['id']; ?>">
                                    <div class="row">
                                      <div class="col-12">
                                        <div class="form-group">
                                          <label>Screen</label>
                                          <select class="form-control" name="edit_screen">
                                            <option value="<?php echo $row['theater']; ?>"><?php echo $row['theater']; ?></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>                    
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-12">
                                        <div class="form-group">
                                          <label>Show</label>
                                          <input type="time" class="form-control" name="edit_time" value="<?php echo $row['show']; ?>">
                                        </div>
                                      </div>
                                      <div class="col-12">
                                        <input type="submit" name="updatetime" value="Update" class="btn btn-primary">
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- Delete Show Modal -->
                          <div class="modal fade" id="delete_show_<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Delete Show</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    <h4>Are you sure you want to delete the show with id "<?php echo $row['id']; ?>"?</h4>
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <input type="submit" name="deletetime" value="OK" class="btn btn-primary">
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                        <?php
                        }
                      }
                      ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Show Modal -->
    <div class="modal fade" id="add_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Show</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form name="myform" id="add_show_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" onsubmit="return validateform()">
              <div class="col-12">
                <div class="form-group">
                  <label>Theater Name</label>
                  <select class="form-control" name="theater_name">
                    <option value="">Select Theater</option>
                    <option value="1">1</option>
                    <option value="2">2</option>                    
                  </select>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Enter Show</label>
                  <input type="time" name="show" id="show">
                </div>
              </div>
              <input type="hidden" name="add_product" value="1">
              <div class="col-12">
                <input type="submit" name="addshow" value="Submit" class="btn btn-primary">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Add Show Modal End -->

    <?php include_once("./templates/footer.php"); ?>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
    <script>
      function validateform() {  
        var theater_name = document.myform.theater_name.value;  
        var show = document.myform.show.value;  

        if (theater_name == "") {  
          alert("Required theater name");  
          return false;  
        } else if (show == "") {  
          alert("Required show time");  
          return false;  
        }  
      }
    </script>
</body>
</html>
