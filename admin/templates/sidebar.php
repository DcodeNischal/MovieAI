
 

<nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">

          <?php 


            $uri = $_SERVER['REQUEST_URI']; 
            $uriAr = explode("/", $uri);
            $page = end($uriAr);

          ?>


          <li class="nav-item" style="margin-top:45px;
background-color: orange;
width: 200px;
text-align:center;
margin-left:100px;
margin-right:20px;border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);
">
            <a class="nav-link" href="index.php" style="color:white;
">
              <span data-feather="home"></span>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
         <li class="nav-item" style="margin-top:25px;
background-color: orange;
width: 200px;
text-align:center;
margin-left:100px;
margin-right:20px;border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);
">
            <a class="nav-link" href="add-movie.php" style="color:white;
">
              <span data-feather="users"></span>
              Add Movie
            </a>
          </li>
         <li class="nav-item" style="margin-top:25px;
background-color: orange;
width: 200px;
text-align:center;
margin-left:100px;margin-right:20px;border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);
">
            <a class="nav-link" href="Theater_and_show.php" style="color:white;
">
              <span data-feather="users"></span>
              Theater And Show
            </a>
          </li>
          
          <li class="nav-item" style="margin-top:25px;
background-color: orange;
width: 200px;
text-align:center;
margin-left:100px;margin-right:20px;border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);
">
            <a class="nav-link" href="customers.php" style="color:white;
">
              <span data-feather="users"></span>
              Customers
            </a>
          </li>
           <li class="nav-item" style="margin-top:25px;
background-color: orange;
width: 200px;
text-align:center;
margin-left:100px;margin-right:20px;border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);
">
            <a class="nav-link" href="Feedback.php" style="color:white;
">
              <span data-feather="users"></span>
              Feedback
            </a>
          </li>
           <li class="nav-item" style="margin-top:25px;
background-color: orange;
width: 200px;
text-align:center;
margin-left:100px;margin-right:20px;border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);
">
            <a class="nav-link" href="users.php" style="color:white;
">
              <span data-feather="users"></span>
              Users
            </a>
          </li>
           
        </ul>


       
      </div>
    </nav>


    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      