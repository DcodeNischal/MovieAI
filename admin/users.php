<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Manage User Page</title>
    
    <?php
    session_start();
    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
        exit();
    }
    ?>
    
    <?php include_once("./templates/top.php"); ?>
    <?php include_once("./templates/navbar.php"); ?>
    
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "./templates/sidebar.php"; ?>

        <div class="col-10">
            <h2>Users</h2>
        </div>
        <div class="col-2">
            <a href="#" data-toggle="modal" data-target="#add_users_modal" class="btn btn-primary btn-sm">Add User</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>City</th>
                    <th>Password</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="product_list">
                <?php
                include_once 'Database.php'; // Ensure this file initializes $conn

                $result = mysqli_query($conn, "SELECT * FROM user");

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $id = $row['id'];
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                            <td><?php echo htmlspecialchars($row['city']); ?></td>
                            <td><?php echo htmlspecialchars($row['password']); ?></td>
                            <td><img src="image/<?php echo htmlspecialchars($row['image']); ?>" alt="" class="resize" style="width: 50px;"></td>
                            <td>
                                <button data-toggle="modal" data-target="#edit_users_modal<?php echo $id; ?>" class="btn btn-primary btn-sm">Edit User</button>
                                <button data-toggle="modal" data-target="#delete_users_modal<?php echo $id; ?>" class="btn btn-danger btn-sm">Delete User</button>
                            </td>
                        </tr>

                        <!-- Delete User Modal -->
                        <div class="modal fade" id="delete_users_modal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteUserLabel<?php echo $row['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteUserLabel<?php echo $row['id']; ?>">Delete User</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="insert_data.php" method="post">
                                            <p>Are you sure you want to delete user ID "<?php echo htmlspecialchars($row['id']); ?>"?</p>
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                            <input type="hidden" name="deleteuser" value="1">
                                            <button type="submit" class="btn btn-primary">OK</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit User Modal -->
                        <div class="modal fade" id="edit_users_modal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editUserLabel<?php echo $row['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editUserLabel<?php echo $row['id']; ?>">Edit User</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="insert_data.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="e_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                            <div class="form-group">
                                                <label for="edit_username<?php echo $row['id']; ?>">Name</label>
                                                <input type="text" class="form-control" name="edit_username" id="edit_username<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['username']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_email<?php echo $row['id']; ?>">Email</label>
                                                <input type="email" class="form-control" name="edit_email" id="edit_email<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['email']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_mobile<?php echo $row['id']; ?>">Mobile</label>
                                                <input type="number" class="form-control" name="edit_mobile" id="edit_mobile<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['mobile']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_city<?php echo $row['id']; ?>">City</label>
                                                <input type="text" class="form-control" name="edit_city" id="edit_city<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['city']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_password<?php echo $row['id']; ?>">Password</label>
                                                <input type="text" class="form-control" name="edit_password" id="edit_password<?php echo $row['id']; ?>" value="<?php echo htmlspecialchars($row['password']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_img<?php echo $row['id']; ?>">Image</label>
                                                <img src="image/<?php echo htmlspecialchars($row['image']); ?>" width="50%" alt="Current Image">
                                                <input type="file" class="form-control-file" name="edit_img" id="edit_img<?php echo $row['id']; ?>">
                                                <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($row['image']); ?>">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update</button>
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

<!-- Add User Modal -->
<div class="modal fade" id="add_users_modal" tabindex="-1" role="dialog" aria-labelledby="addUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserLabel">Enter Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="insert_user_form" action="insert_data.php" method="post" enctype="multipart/form-data" onsubmit="return validateform()">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="User name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile No</label>
                        <input type="number" class="form-control" name="mobile" id="mobile" placeholder="Mobile No">
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" name="city" id="city" placeholder="Enter City Name">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" name="password" id="password" placeholder="Enter Password">
                    </div>
                    <div class="form-group">
                        <label for="img">Image</label>
                        <input type="file" class="form-control-file" name="img" id="img">
                    </div>
                    <input type="hidden" name="add_user" value="1">
                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
                <div id="preview"></div>
            </div>
        </div>
    </div>
</div>

<?php include_once("./templates/footer.php"); ?>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
function validateform() {
    var User_name = document.getElementById("username").value;
    var Email = document.getElementById("email").value;
    var Mobileno = document.getElementById("mobile").value;
    var City = document.getElementById("city").value;
    var Password = document.getElementById("password").value;

    if (User_name === "") {
        alert("Required: User name");
        return false;
    }
    if (Email === "") {
        alert("Required: Enter Email");
        return false;
    }
    if (Mobileno === "") {
        alert("Required: Enter Mobile No");
        return false;
    }
    if (City === "") {
        alert("Required: Enter City");
        return false;
    }
    if (Password === "") {
        alert("Required: Enter Password");
        return false;
    }

    return true;
}
</script>
</body>
</html>
