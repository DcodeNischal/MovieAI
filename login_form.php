<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="site.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div>
    <div class="form-container">
        <div class="container" id="container">
            <div class="form-container sign-up-container" id="sign-up-container">
                <form id="form" action="register.php" method="post" enctype="multipart/form-data" onsubmit="return validateSignup()">
                    <center><h1>Sign Up</h1></center>
                    <div class="user-details">
                        <div class="input-box">
                            <input type="text" id="username" class="inputmargin" name="username" placeholder="Enter your name">
                            <p id="nameerror"></p>
                        </div>
                        <div class="input-box">
                            <input type="text" id="email" class="inputmargin" name="email" placeholder="Enter your Email">
                            <p id="emailerror"></p>
                        </div>
                        <div class="input-box">
                            <input type="text" id="number" class="inputmargin" name="number" placeholder="Enter your Phone Number">
                            <p id="numbererror"></p>
                        </div>
                        <div class="input-box">
                            <input type="text" class="inputmargin"  id="city" name="city" placeholder="Enter your City">
                            <p id="cityerror"></p>
                        </div>
                        <div class="input-box">
                            <input type="password" class="inputmargin"  id="password" name="password" placeholder="Enter your password">
                            <p id="passworderror"></p>
                        </div>
                        <div class="input-box">
                            <input type="password" class="inputmargin"  id="cpassword" name="cpassword" placeholder="Confirm your password">
                            <p id="cpassworderror"></p>
                        </div>
                        <div class="input-box">
                            <input type="file" class="inputmargin"  id="image" name="image">
                        </div>
                    </div>
                    <p id="error_para"></p>
                    <div id="err"></div>
                    <div class="button">
                        <input type="submit" value="Register" id="submit" class="signupbth" name="submit">
                    </div>
                </form>
            </div>
            <div class="form-container sign-in-container" id="sign-in-container">
                <form action="login.php" method="POST" onsubmit="return validateSignin()">
                    <img src="/src/images/logo/logo.png" alt="" class="logo mobile margin"/>
                    <h1>Sign in</h1>
                    <input id="signin-username" class="inputmargin"  name="username" type="text" placeholder="Username">
                    <input id="signin-password" class="inputmargin"  name="password" type="password" placeholder="Password">
                    <a href="#">Forgot your password?</a>
                    <button type="submit">Sign In</button>
                    <p class="mobile">
                        New user? Click <a id="signUp-Mobile" href="#">Here</a>.
                    </p>
                    <div id="signin-error" class="error"></div>
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <img src="img/image.png" alt="" class="logo"/>
                        <h1>Welcome Back!</h1>
                        <p>To keep connected with us please login with your personal info</p>
                        <button class="ghost" id="signIn">Sign In</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <img src="img/image.png" alt="" class="logo"/>
                        <h1>Hello, Friend!</h1>
                        <p>Enter your personal details and start journey with us</p>
                        <button class="ghost" id="signUp">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        const signUpButton = document.getElementById("signUp");
        const signInButton = document.getElementById("signIn");
        const container = document.getElementById("container");
        const signUpMobileLink = document.getElementById("signUp-Mobile");
        const signInMobileLink = document.getElementById("signIn-Mobile");

        signUpButton.addEventListener("click", () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener("click", () => {
            container.classList.remove("right-panel-active");
        });

        signUpMobileLink.addEventListener("click", (event) => {
            event.preventDefault();
            document.getElementById("sign-up-container").style.display = "block";
            document.getElementById("sign-in-container").style.display = "none";
        });

        signInMobileLink.addEventListener("click", (event) => {
            event.preventDefault();
            document.getElementById("sign-in-container").style.display = "block";
            document.getElementById("sign-up-container").style.display = "none";
        });
    });

    function validateSignin() {
        var username = $("#signin-username").val().trim();
        var password = $("#signin-password").val().trim();
        var error = "";

        if (username == "") {
            error = "<font color='red'>Username is required.</font>";
            $("#signin-error").html(error);
            return false;
        }
        if (password == "") {
            error = "<font color='red'>Password is required.</font>";
            $("#signin-error").html(error);
            return false;
        }
        return true;
    }

    function validateSignup() {
        var name = $("#username").val().trim();
        var email = $("#email").val().trim();
        var number = $("#number").val().trim();
        var city = $("#city").val().trim();
        var password = $("#password").val().trim();
        var cpassword = $("#cpassword").val().trim();
        var error = "";

        if (name == "") {
            error = "<font color='red'>Name is required.</font>";
            $("#nameerror").html(error);
            return false;
        }
        if (name.length < 3 || name.length > 20) {
            error = "<font color='red'>Name must be between 3 and 20 characters.</font>";
            $("#nameerror").html(error);
            return false;
        }
        if (!isNaN(name)) {
            error = "<font color='red'>Name must be a string.</font>";
            $("#nameerror").html(error);
            return false;
        }
        if (email == "") {
            error = "<font color='red'>Email is required.</font>";
            $("#emailerror").html(error);
            return false;
        }
        if (email.indexOf('@') <= 0 || email.lastIndexOf('.') <= email.indexOf('@') + 1 || email.lastIndexOf('.') >= email.length - 1) {
            error = "<font color='red'>Invalid email format.</font>";
            $("#emailerror").html(error);
            return false;
        }
        if (number == "") {
            error = "<font color='red'>Phone number is required.</font>";
            $("#numbererror").html(error);
            return false;
        }
        if (number.length != 10 || isNaN(number)) {
            error = "<font color='red'>Phone number must be 10 digits and numeric.</font>";
            $("#numbererror").html(error);
            return false;
        }
        if (city == "") {
            error = "<font color='red'>City is required.</font>";
            $("#cityerror").html(error);
            return false;
        }
        if (password == "") {
            error = "<font color='red'>Password is required.</font>";
            $("#passworderror").html(error);
            return false;
        }
        if (password.length < 3 || password.length > 10) {
            error = "<font color='red'>Password must be between 3 and 10 characters.</font>";
            $("#passworderror").html(error);
            return false;
        }
        if (cpassword == "") {
            error = "<font color='red'>Confirm Password is required.</font>";
            $("#cpassworderror").html(error);
            return false;
        }
        if (cpassword != password) {
            error = "<font color='red'>Passwords do not match.</font>";
            $("#cpassworderror").html(error);
            return false;
        }
        return true;
    }
</script>
</body>
</html>
