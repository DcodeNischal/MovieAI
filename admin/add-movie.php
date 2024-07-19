<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Movies Page</title>

    <?php 
    session_start();  
    if (!isset($_SESSION['admin'])) {
      header("location:login.php");
    }
    ?>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
              <th>id</th>
              <th>Movie name</th>
              <th>Directer</th>
              <th>categroy</th>
              <th>language</th>
              <th>Show</th>
              <th>Image</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="product_list">
            <?php
            include_once 'Database.php';
            $result = mysqli_query($conn,"SELECT * FROM add_movie");

            if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_array($result)) {
                $id=$row['id'];?>
                <tr>
                  <td><?php echo $row['id'];?></td>
                  <td><?php echo $row['movie_name'];?></td>
                  <td><?php echo $row['directer'];?></td>
                  <td><?php echo $row['categroy'];?></td>
                  <td><?php echo $row['language'];?></td>
                  <td><?php echo $row['show'];?></td>
                  <td><img src="image/<?php echo $row['image']; ?>" alt="" class="resize"></td>
                  <td><button data-toggle="modal" type="button" data-target="#edit_movie_modal<?php echo $id;?>" class="btn btn-primary btn-sm">Edit Movie</button></td>
                  <td><button data-toggle="modal" type="button" data-target="#delete_movie_modal<?php echo $id;?>" class="btn btn-danger btn-sm">Delete Movie</button></td>
                </tr>

                <div class="modal fade" id="delete_movie_modal<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Movie</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form id="delete_movie" action="insert_data.php" method="post">
                          <h4>Are you sure you want to delete the movie with ID "<?php echo $row['id'];?>"?</h4>
                          <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                          <input type="submit" name="deletemovie" id="deletemovie" value="OK" class="btn btn-primary">
                        </form>
                      </div>
                    </div>
                  </div>
                </div> 

                <div class="modal fade" id="edit_movie_modal<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Movie</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form id="edit_movie" action="insert_data.php" method="post" enctype="multipart/form-data">
                          <div class="row">
                            <div class="col-12">
                              <div class="form-group">
                                <label>Movie Name</label>
                                <input type="hidden" name="e_id" value="<?php echo $row['id'];?>">
                                <input class="form-control" name="edit_movie_name" id="edit_movie_name" value="<?php echo $row['movie_name'];?>">
                                <small></small>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group">
                                <label>Directer Name</label>
                                <input class="form-control" name="edit_directer_name" id="edit_directer_name" value="<?php echo $row['directer'];?>">
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group">
                                <label>Category</label>
                                <input class="form-control" name="edit_category" id="edit_category" value="<?php echo $row['categroy']; ?>">
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group">
                                <label>Language</label>
                                <input type="text" name="edit_language" id="edit_language" class="form-control" value="<?php echo $row['language'];?>">
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group">
                                <label>Time</label>
                                <?php
                                $seats = explode(",", $row['show']);
                                $sql = mysqli_query($conn,"SELECT * FROM theater_show");
                                if (mysqli_num_rows($sql) > 0) {
                                  while($fatch = mysqli_fetch_array($sql)) {
                                    $checked = $fatch['show'];
                                    ?>
                                    <font size="2"> <?php echo $fatch['show'];?></font><input type="checkbox" name="show[]" id="show" value="<?php echo $fatch['show'];?>" <?php
                                      if(in_array($checked,$seats)){
                                        echo "checked";
                                      }
                                    ?>>
                                    <?php
                                  }
                                }
                                ?>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group">
                                <label>Trailer</label>
                                <input type="text" name="edit_tailer" id="edit_tailer" class="form-control" value="<?php echo $row['you_tube_link'];?>">
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group">
                                <label>Action</label>
                                <select class="form-control" name="edit_action">
                                  <option value="<?php echo $row['action'];?>"><?php echo $row['action'];?></option>
                                  <option value="upcoming">upcoming</option>
                                  <option value="running">running</option>                    
                                </select>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" name="description" id="description" class="form-control"><?php echo $row['description'];?></textarea>
                              </div>
                            </div>       
                            <div class="col-12">
                              <div class="form-group">
                                <label>Set of Time</label>
                                <input type="text" name="time" id="time" class="form-control" value="<?php echo $row['time'];?>">
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group">
                                <label>Movie Image</label>
                                <input type="file" name="edit_image" class="form-control">
                                <img src="image/<?php echo $row['image'];?>" width="50px" height="50px">
                              </div>
                            </div>     
                            <input type="submit" name="editmovie" id="editmovie" value="Submit" class="btn btn-primary">
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
            <form id="add_movie_form" action="insert_data.php" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label>Movie Name</label>
                    <input type="text" name="movie_name" id="movie_name" class="form-control" placeholder="Enter movie name">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Director Name</label>
                    <input type="text" name="director_name" id="director_name" class="form-control" placeholder="Enter director name">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Category</label>
                    <input type="text" name="category" id="category" class="form-control" placeholder="Enter category">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Language</label>
                    <input type="text" name="language" id="language" class="form-control" placeholder="Enter language">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Show Time</label>
                    <?php
                    $sql = mysqli_query($conn,"SELECT * FROM theater_show");
                    if (mysqli_num_rows($sql) > 0) {
                      while($row = mysqli_fetch_array($sql)) {
                        ?>
                        <font size="2"> <?php echo $row['show'];?></font><input type="checkbox" name="show[]" id="show" value="<?php echo $row['show'];?>">
                        <?php
                      }
                    }
                    ?>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Trailer</label>
                    <input type="text" name="trailer" id="trailer" class="form-control" placeholder="Enter YouTube trailer link">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Action</label>
                    <select class="form-control" name="action">
                      <option value="upcoming">Upcoming</option>
                      <option value="running">Running</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="description" class="form-control" placeholder="Enter description"></textarea>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Set of Time</label>
                    <input type="text" name="time" id="time" class="form-control" placeholder="Enter set of time">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Movie Image</label>
                    <input type="file" name="image" class="form-control">
                  </div>
                </div>
                <input type="submit" name="addmovie" id="addmovie" value="Submit" class="btn btn-primary">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      $(document).ready(function(){
        $('#addmovie').on('click', function(e) {
          e.preventDefault();

          var form = $('#add_movie_form')[0];
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

        $('[id^=editmovie]').on('click', function(e) {
          e.preventDefault();

          var form = $(this).closest('form')[0];
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

        $('[id^=deletemovie]').on('click', function(e) {
          e.preventDefault();

          var form = $(this).closest('form')[0];
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
