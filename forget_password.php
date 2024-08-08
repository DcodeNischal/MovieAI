<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="site.css" />
    <style>
        .inputbox {
            border-radius: 15px;
        }
        #login {
            margin-bottom: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);
        }
        table {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>
</head>
<body>
<div class="parent-container">
    <table width="500px;" style="border-radius: 15px; box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);">
        <tr>
            <td align="center" valign="middle">
                <div class="loginholder">
                    <table style="background-color: white; margin-top: 30px;" class="table-condensed">
                        <tr>
                            <a href="./index.html"><img src="img/image.png" alt="" width="200px"></a>
                        </tr>
                        <tr>
                            <td><b>Email Id:</b></td>
                        </tr>
                        <tr>
                            <td><input type="text" class="inputbox" id="email" />
                                <br><p id="emailerror"></p></td>
                        </tr>
                        <tr>
                            <td><button type="button" id="getcode">Get Code</button></td>
                        </tr>
                        <tr>
                            <td><b>Reset Code:</b></td>
                        </tr>
                        <tr>
                            <td><input type="text" class="inputbox" id="code" />
                                <br><p id="codeerror"></p></td>
                        </tr>
                        <tr>
                            <td><b>New Password:</b></td>
                        </tr>
                        <tr>
                            <td><input type="password" class="inputbox" id="newpassword" />
                                <br><p id="newpassworderror"></p></td>
                        </tr>
                        <tr>
                            <td><b>Confirm Password:</b></td>
                        </tr>
                        <tr>
                            <td><input type="password" class="inputbox" id="cpassword"/>
                                <br><p id="cpassworderror"></p><div id="msg"></div></td>
                        </tr>
                        <tr>
                            <td align="center"><br />
                                <button class="btn-normal" id="login">Submit</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#login").click(function() {
            var email = $("#email").val().trim();
            var code = $("#code").val().trim();
            var newpassword = $("#newpassword").val().trim();
            var cpassword = $("#cpassword").val().trim();

            if (email == "") {
                var error = "<font color='red'>!Require Email.</font>";
                document.getElementById("emailerror").innerHTML = error;
                return false;
            }
            if (code == "") {
                var error = "<font color='red'>!Require Reset Code.</font>";
                document.getElementById("codeerror").innerHTML = error;
                return false;
            }
            if (newpassword == "") {
                var error = "<font color='red'>!Require New Password.</font>";
                document.getElementById("newpassworderror").innerHTML = error;
                return false;
            }
            if (cpassword == "") {
                var error = "<font color='red'>!Require Confirm Password.</font>";
                document.getElementById("cpassworderror").innerHTML = error;
                return false;
            }
            if (cpassword != newpassword) {
                var error = "<font color='red'>!Passwords do not match.</font>";
                document.getElementById("cpassworderror").innerHTML = error;
                return false;
            }
            $.ajax({
                url: 'forget.php',
                type: 'post',
                data: { email: email, code: code, newpassword: newpassword },
                success: function(response) {
                    $("#msg").html(response);
                }
            });

        });

        $("#getcode").click(function(){
            var email = $("#email").val().trim();
            if (email == "") {
                var error = "<font color='red'>!Require Email.</font>";
                document.getElementById("emailerror").innerHTML = error;
                return false;
            }
            $.ajax({
                url: 'request_reset.php',
                type: 'post',
                data: { email: email },
                success: function(response) {
                    $("#msg").html(response);
                }
            });
        });
    });
</script>
</body>
</html>
