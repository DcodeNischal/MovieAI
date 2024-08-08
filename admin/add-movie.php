<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <title>Movies Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <style>
        .container-fluid{
            margin-top:40px;
            margin-left:-350px;
        }
        
        .btn{
            background-color:orange;
            border:none;
            margin-top:40px;
            border-radius:10px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);
            padding:10px;
            margin-left:15px;
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
    <?php 
    session_start();  
    if (!isset($_SESSION['admin'])) {
        header("location:login.php");
        exit();
    }
    ?>
    <?php include_once("./templates/top.php"); ?>
    <?php include_once("./templates/navbar.php"); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "./templates/sidebar.php"; ?>
        <main class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="row">
                <div class="col-10">
                    <h2>Add movie</h2>
                </div>
                <div class="col-2">
                    <button data-toggle="modal" data-target="#add_movie_modal" class="btn btn-primary btn-sm">Add Movie</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Movie Name</th>
                            <th>Director</th>
                            <th>Release Date</th>
                            <th>Category</th>
                            <th>Language</th>
                            <th>Show</th>
                            <th>Image</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="product_list">
                        <?php
                        include_once 'Database.php';
                        $result = mysqli_query($conn, "SELECT * FROM add_movie");
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['id'];
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['movie_name']; ?></td>
                                    <td><?php echo $row['directer']; ?></td>
                                    <td><?php echo $row['release_date']; ?></td>
                                    <td><?php echo $row['categroy']; ?></td>
                                    <td><?php echo $row['language']; ?></td>
                                    <td><?php echo $row['show']; ?></td>
                                    <td><img src="image/<?php echo $row['image']; ?>" alt="" class="resize" width="50"></td>
                                    <td>
                                        <button data-toggle="modal" type="button" data-target="#edit_movie_modal<?php echo $id; ?>" class="btn btn-primary btn-sm">Edit Movie</button>
                                    </td>
                                    <td>
                                        <button data-toggle="modal" type="button" data-target="#delete_movie_modal<?php echo $id; ?>" class="btn btn-danger btn-sm">Delete Movie</button>
                                    </td>
                                </tr>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="delete_movie_modal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Movie</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="post">
                                                    <p>Are you sure you want to delete this movie?</p>
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" name="deletemovie" class="btn btn-danger">Delete</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="edit_movie_modal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Movie</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="e_id" value="<?php echo $row['id']; ?>">
                                                    <div class="form-group">
                                                        <label for="edit_movie_name">Movie Name</label>
                                                        <input type="text" class="form-control" name="edit_movie_name" value="<?php echo $row['movie_name']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="edit_directer_name">Director Name</label>
                                                        <input type="text" class="form-control" name="edit_directer_name" value="<?php echo $row['directer']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="edit_release_date">Release Date</label>
                                                        <input type="date" class="form-control" name="edit_release_date" value="<?php echo $row['release_date']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="edit_category">Category</label>
                                                        <input type="text" class="form-control" name="edit_category" value="<?php echo $row['categroy']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="edit_language">Language</label>
                                                        <input type="text" class="form-control" name="edit_language" value="<?php echo $row['language']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="edit_show">Show</label>
                                                        <?php
                                                        $seats = explode(",", $row['show']);
                                                        $sql = mysqli_query($conn, "SELECT * FROM theater_show");
                                                        if (mysqli_num_rows($sql) > 0) {
                                                            while ($fatch = mysqli_fetch_array($sql)) {
                                                                $checked = $fatch['show'];
                                                                ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="show[]" value="<?php echo $fatch['show']; ?>" <?php echo in_array($checked, $seats) ? 'checked' : ''; ?>>
                                                                    <label class="form-check-label"><?php echo $fatch['show']; ?></label>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="edit_tailer">Trailer</label>
                                                        <input type="text" class="form-control" name="edit_tailer" value="<?php echo $row['you_tube_link']; ?>">
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="edit_action">Action</label>
                                                        <select class="form-control" name="edit_action">
                                                            <option value="<?php echo $row['action']; ?>"><?php echo $row['action']; ?></option>
                                                            <option value="upcoming">Upcoming</option>
                                                            <option value="running">Running</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description">Description</label>
                                                        <textarea class="form-control" name="description"><?php echo $row['decription']; ?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="edit_img">Image</label>
                                                        <img src="image/<?php echo $row['image']; ?>" width="100">
                                                        <input type="file" class="form-control" name="edit_img">
                                                        <input type="hidden" name="old_image" value="<?php echo $row['image']; ?>">
                                                    </div>
                                                    <button type="submit" name="updatemovie" class="btn btn-primary">Update Movie</button>
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
        </main>
    </div>
</div>

<!-- Add Movie Modal -->
<div class="modal fade" id="add_movie_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Movie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="movie_name">Movie Name</label>
                            <input type="text" class="form-control" name="movie_name" required>
                        </div>
                        <div class="form-group">
                            <label for="directer_name">Director Name</label>
                            <input type="text" class="form-control" name="directer_name" required>
                        </div>
                        <div class="form-group">
                            <label for="release_date">Release Date</label>
                            <input type="date" class="form-control" name="release_date" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" name="category" required>
                        </div>
                        <div class="form-group">
                            <label for="language">Language</label>
                            <input type="text" class="form-control" name="language" required>
                        </div>
                        <div class="form-group">
                            <label for="show">Show</label>
                            <?php
                            $sql = mysqli_query($conn, "SELECT * FROM theater_show");
                            if (mysqli_num_rows($sql) > 0) {
                                while ($row = mysqli_fetch_array($sql)) {
                                    ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="show[]" value="<?php echo $row['show']; ?>">
                                        <label class="form-check-label"><?php echo $row['show']; ?></label>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="tailer">Trailer</label>
                            <input type="text" class="form-control" name="tailer" required>
                        </div>
                        <div class="form-group">
                            <label for="action">Action</label>
                            <select class="form-control" name="action" required>
                                <option value="upcoming">Upcoming</option>
                                <option value="running">Running</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="image" required>
                        </div>
                        <button type="submit" name="addmovie" class="btn btn-primary">Add Movie</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php

ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (isset($_POST['addmovie'])) {
        $movie_name = mysqli_real_escape_string($conn, $_POST['movie_name']);
        $directer_name = mysqli_real_escape_string($conn, $_POST['directer_name']);
        $release_date = mysqli_real_escape_string($conn, $_POST['release_date']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $language = mysqli_real_escape_string($conn, $_POST['language']);
        $shows = isset($_POST['show']) ? implode(",", $_POST['show']) : '';
        $tailer = mysqli_real_escape_string($conn, $_POST['tailer']);
        $action = mysqli_real_escape_string($conn, $_POST['action']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $image = $_FILES['image']['name'];
        $target = "image/" . basename($image);

        // generate random number for id
        $id = rand(100000, 999999);
        $status = 1;

        // Debugging statements
        echo "Received Data: <br>";
        echo "Movie Name: $movie_name <br>";
        echo "Director Name: $directer_name <br>";
        echo "Release Date: $release_date <br>";
        echo "Category: $category <br>";
        echo "Language: $language <br>";
        echo "Shows: $shows <br>";
        echo "Tailer: $tailer <br>";
        echo "Action: $action <br>";
        echo "Description: $description <br>";
        echo "Image: $image <br>";

        $sql = "INSERT INTO add_movie (id, movie_name, directer, release_date, categroy, language, you_tube_link, `show`, action, decription, image, status) VALUES ('$id', '$movie_name', '$directer_name', '$release_date', '$category', '$language', '$tailer', '$shows', '$action', '$description', '$image', '$status')";

        if (mysqli_query($conn, $sql)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                echo "<script>alert('Movie added successfully');</script>";
            } else {
                echo "<script>alert('Failed to upload image');</script>";
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }


if (isset($_POST['updatemovie'])) {
    $id = $_POST['e_id'];
    $movie_name = mysqli_real_escape_string($conn, $_POST['edit_movie_name']);
    $directer_name = mysqli_real_escape_string($conn, $_POST['edit_directer_name']);
    $category = mysqli_real_escape_string($conn, $_POST['edit_category']);
    $language = mysqli_real_escape_string($conn, $_POST['edit_language']);
    $shows = isset($_POST['show']) ? implode(",", $_POST['show']) : '';
    $tailer = mysqli_real_escape_string($conn, $_POST['edit_tailer']);
    $action = mysqli_real_escape_string($conn, $_POST['edit_action']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image = $_FILES['edit_img']['name'];

    if (empty($image)) {
        $image = $_POST['old_image'];
    } else {
        $target = "image/" . basename($image);
        move_uploaded_file($_FILES['edit_img']['tmp_name'], $target);
    }

    $sql = "UPDATE add_movie SET movie_name='$movie_name', directer='$directer_name', categroy='$category', language='$language', `show`='$shows', you_tube_link='$tailer', `action`='$action', decription='$description', image='$image' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Movie updated successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

if (isset($_POST['deletemovie'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM add_movie WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Movie deleted successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
</body>
</html>
