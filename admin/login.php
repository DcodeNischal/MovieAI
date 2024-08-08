<!DOCTYPE html>
<html>
<head>
  <title>Username and password validation in PHP using AJAX</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/jquery-3.5.1.min.js"></script>
  <script type="text/javascript" src="ajaxValidation.js"></script>
  <style type="text/css">
li{color: red;}
    .container{
      margin-top:300px;
      padding:30px;
      width:500px;
      border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);
    }
    .container p{
      color: orangered;
      font-size:30px;
      font-weight:bolder;
    }
    .mb-3{
      width:350px;
      padding:10px;
    }
    .btn{
      background-color: orange;
      border: none;
      border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);
    }
    .btn:hover{
      background-color:orange;
    }
  </style>  </style>
</head>
<body>
  <div class="container col-md-5" >
    <p>Admin Login</p>
    <div class="mb-3">
      <input type="email" class="form-control" id="userEmail" placeholder="enter username">
    </div>
    <div class="mb-3">
      <input type="password" class="form-control" id="userPassword" placeholder="enter password">
    </div>
    <p id="message"></p>
    <div class="mb-3 col-md-4">
      <button class="form-control btn btn-danger" id="checkValidation">Login</button>
    </div>
  </div>
</body>
</html>