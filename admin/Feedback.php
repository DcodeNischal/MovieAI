<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Feedback Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  </head>
  <body>
    <?php
    session_start();
    if (!isset($_SESSION['admin'])) {
      header("location:login.php");
    }
    ?>
    <?php include_once("./templates/top.php"); ?>
    <?php include_once("./templates/navbar.php"); ?>
    <div class="container-fluid">
      <div class="row">
        <?php include "./templates/sidebar.php"; ?>
        <div class="col-12">
          <div class="row">
            <div class="col-10">
              <h2>Feedback</h2>
            </div>
            <div class="col-2">
              <a href="#" data-toggle="modal" data-target="#add_feedback_modal" class="btn btn-primary btn-sm">Feedback detail</a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Message</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="product_list">
                <?php
                include_once 'Database.php';
                $result = mysqli_query($conn, "SELECT * FROM feedback");
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_array($result)) {
                    $id = $row['id'];
                ?>
                    <tr>
                      <td><?php echo $row['id']; ?></td>
                      <td><?php echo $row['name']; ?></td>
                      <td><?php echo $row['email']; ?></td>
                      <td><?php echo $row['massage']; ?></td>
                      <td>
                        <button data-toggle="modal" type="button" data-target="#edit_feedback_modal<?php echo $id; ?>" class="btn btn-primary btn-sm">Edit</button>
                        <button data-toggle="modal" type="button" data-target="#delete_feedback_modal<?php echo $id; ?>" class="btn btn-danger btn-sm">Delete</button>
                      </td>
                    </tr>
                    <!-- Delete Feedback Modal -->
                    <div class="modal fade" id="delete_feedback_modal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Feedback</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="delete_feedback" action="insert_data.php" method="post">
                              <h4>Are you sure you want to delete feedback with ID "<?php echo $row['id']; ?>"?</h4>
                              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                              <input type="submit" name="deletefeedback" id="deletefeedback" value="OK" class="btn btn-primary">
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Edit Feedback Modal -->
                    <div class="modal fade" id="edit_feedback_modal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Feedback</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="edit_feedback" action="insert_data.php" method="post" enctype="multipart/form-data">
                              <div class="row">
                                <div class="col-12">
                                  <div class="form-group">
                                    <label>Name</label>
                                    <input type="hidden" name="e_id" value="<?php echo $row['id']; ?>">
                                    <input class="form-control" name="edit_feedback_name" id="edit_name" value="<?php echo $row['name']; ?>">
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" name="edit_feedback_email" id="edit_email" value="<?php echo $row['email']; ?>">
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-group">
                                    <label>Message</label>
                                    <input class="form-control" name="edit_feedback_message" id="edit_message" value="<?php echo $row['message']; ?>">
                                  </div>
                                </div>
                                <div class="col-12">
                                  <input type="submit" name="updatefeedback" id="updatefeedback" value="Update" class="btn btn-primary">
                                </div>
                              </div>
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
    </div>
    <!-- Add Feedback Modal -->
    <div class="modal fade" id="add_feedback_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Feedback</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form name="myform" id="insert_feedback" action="insert_data.php" method="post" enctype="multipart/form-data" onsubmit="return validateform()">
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label>Enter Your Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Enter Email</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Enter Email">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Message</label>
                    <textarea class="form-control" name="message" id="message" placeholder="Enter Your Message"></textarea>
                  </div>
                </div>
                <div class="col-12">
                  <input type="submit" name="add_feedback" class="btn btn-primary add-product" value="Add Feedback">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php include_once("./templates/footer.php"); ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
      function validateform() {
        var name = document.myform.name.value;
        var email = document.myform.email.value;
        var message = document.myform.message.value;
        if (name == "") {
          alert("Name is required");
          return false;
        } else if (email == "") {
          alert("Email is required");
          return false;
        } else if (message == "") {
          alert("Message is required");
          return false;
        }
      }
    </script>
  </body>
</html>
