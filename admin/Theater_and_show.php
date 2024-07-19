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
    session_start();  
    if (!isset($_SESSION['admin'])) {
      header("location:login.php");
    }
    ?>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
    <?php include_once("./templates/top.php"); ?>
    <?php include_once("./templates/navbar.php"); ?>
    <div class="container-fluid">
        <div class="row">
            <?php include "./templates/sidebar.php"; ?>

            <div class="row">
                <div class="col-10">
                    <h2>Feedback</h2>
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
                        </tr>
                    </thead>
                    <tbody id="product_list">
                        <?php
                        include_once 'Database.php';
                        $result = mysqli_query($conn,"SELECT * FROM theater_show");

                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_array($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['id'];?></td>
                                    <td><?php echo $row['show'];?></td>
                                    <td><?php echo $row['theater'];?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#update_show<?php echo $row['id'];?>" class="btn btn-primary btn-sm">Edit Show</button>
                                        <button data-toggle="modal" data-target="#delete_show<?php echo $row['id'];?>" class="btn btn-danger btn-sm">Delete Show</button>
                                    </td>
                                </tr>
                                <!-- Edit Show Modal -->
                                <div class="modal fade" id="update_show<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Show</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="update_show_form_<?php echo $row['id'];?>" action="insert_data.php" method="post">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>Screen</label>
                                                                <input type="hidden" name="e_id" value="<?php echo $row['id'];?>">
                                                                <select class="form-control" name="edit_screen" id="edit_screen">
                                                                    <option value="<?php echo $row['theater'];?>"><?php echo $row['theater'];?></option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>Show</label>
                                                                <input type="time" class="form-control" name="edit_time" id="edit_time" value="<?php echo $row['show'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <input type="submit" name="updatetime" id="updatetime_<?php echo $row['id'];?>" value="update" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <!-- Delete Show Modal -->
                                <div class="modal fade" id="delete_show<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Show</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="delete_show_form_<?php echo $row['id'];?>" action="insert_data.php" method="post">
                                                    <h4>Are you sure you want to delete the show with ID "<?php echo $row['id'];?>"?</h4>
                                                    <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                                                    <input type="submit" name="deletetime" id="deletetime_<?php echo $row['id'];?>" value="OK" class="btn btn-primary">
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
                    <form name="myform" id="add_show_form" action="insert_data.php" method="post" onsubmit="return validateform()">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Theater Name</label>
                                <select class="form-control" name="theater_name" id="theater_name">
                                    <option value="">Select Theater</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>                    
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Show Time</label>
                                <input type="time" name="show" id="show" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="hidden" name="add_product" value="1">
                            <input type="submit" name="addshow" id="addshow" value="submit" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include_once("./templates/footer.php"); ?>

    <script>
    function validateform() {
        var theater_name = document.myform.theater_name.value;
        var show = document.myform.show.value;

        if (theater_name == "") {
            alert("Theater name is required");
            return false;
        }
        if (show == "") {
            alert("Show time is required");
            return false;
        }
    }

    $(document).ready(function() {
        $('[id^=updatetime]').on('click', function(e) {
            e.preventDefault();

            var formId = $(this).attr('id').replace('updatetime_', 'update_show_form_');
            var form = $('#' + formId)[0];
            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: 'insert_data.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function(error) {
                    alert('Error: ' + error);
                }
            });
        });

        $('[id^=deletetime]').on('click', function(e) {
            e.preventDefault();

            var formId = $(this).attr('id').replace('deletetime_', 'delete_show_form_');
            var form = $('#' + formId)[0];
            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: 'insert_data.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function(error) {
                    alert('Error: ' + error);
                }
            });
        });
    });
    </script>
</body>
</html>
