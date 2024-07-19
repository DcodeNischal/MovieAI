<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="site.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div>
    <div class="form-container">
        <div class="container" id="container">
            <div class="form-container sign-up-container" id="sign-up-container">
                <form action="signup.php" method="POST" onsubmit="return validateSignup()">
                    <img src="/src/images/logo/logo.png" alt="" class="logo mobile margin"/>
                    <h1>Create Account</h1>
                    <input type="text" id="signup-name" name="name" placeholder="Name" />
                    <input type="email" id="signup-email" name="email" placeholder="Email" />
                    <input type="password" id="signup-password" name="password" placeholder="Password" />

					<input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" />

					

                    <button type="submit">Sign Up</button>
                    <p class="mobile">
                        Have an account? Click <a id="signIn-Mobile" href="#">Here</a>.
                    </p>
                    <div id="signup-error" class="error"></div>
                </form>
            </div>
            <div class="form-container sign-in-container" id="sign-in-container">
                <form action="login.php" method="POST" onsubmit="return validateSignin()">
                    <img src="/src/images/logo/logo.png" alt="" class="logo mobile margin"/>
                    <h1>Sign in</h1>
                    <input id="signin-username" name="username" type="text" placeholder="Username" />
                    <input id="signin-password" name="password" type="password" placeholder="Password" />
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
        var name = $("#signup-name").val().trim();
        var email = $("#signup-email").val().trim();
        var password = $("#signup-password").val().trim();
        var error = "";

        if (name == "") {
            error = "<font color='red'>Name is required.</font>";
            $("#signup-error").html(error);
            return false;
        }
        if (name.length < 3 || name.length > 20) {
            error = "<font color='red'>Name must be between 3 and 20 characters.</font>";
            $("#signup-error").html(error);
            return false;
        }
        if (!isNaN(name)) {
            error = "<font color='red'>Name must be a string.</font>";
            $("#signup-error").html(error);
            return false;
        }
        if (email == "") {
            error = "<font color='red'>Email is required.</font>";
            $("#signup-error").html(error);
            return false;
        }
        if (email.indexOf('@') <= 0 || email.lastIndexOf('.') <= email.indexOf('@') + 1 || email.lastIndexOf('.') >= email.length - 1) {
            error = "<font color='red'>Invalid email format.</font>";
            $("#signup-error").html(error);
            return false;
        }
        if (password == "") {
            error = "<font color='red'>Password is required.</font>";
            $("#signup-error").html(error);
            return false;
        }
        if (password.length < 3 || password.length > 10) {
            error = "<font color='red'>Password must be between 3 and 10 characters.</font>";
            $("#signup-error").html(error);
            return false;
        }
        return true;
    }
</script>
</body>
</html>
