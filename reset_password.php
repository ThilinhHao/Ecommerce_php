<?php
    include 'config/database.php';
    session_start();

    $errors = [];
    if (isset($_POST['update'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $newPassword = mysqli_real_escape_string($conn, $_POST['newPassword']);
        $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
        $token = mysqli_real_escape_string($conn, $_POST['token']);

        if (!empty($token)) {
            if (!empty($email) && !empty($newPassword) && !empty($confirmPassword)) {
                $check = "SELECT * FROM users WHERE token = '$token' LIMIT 1";
                $checkToken = mysqli_query($conn, $check);

                if (mysqli_num_rows($checkToken)) {
                    if ($newPassword === $confirmPassword && strlen($newPassword) >= 6) {
                        $updatePassword = "UPDATE users SET `password` = '$newPassword' WHERE token = '$token' LIMIT 1";
                        $query = mysqli_query($conn, $updatePassword);

                        if ($query) {
                            $_SESSION['status'] = 'New Password successfully updated.';
                            header("location: login.php");
                        } else {
                            $_SESSION['status'] = 'Did not update password.';
                            header("location: reset_password.php?token=$token&$email=$email");
                        }
                    } elseif(strlen($newPassword) < 6) {
                        $_SESSION['status'] = 'Password is not strong enough.';
                        header("location: reset_password.php?token=$token&$email=$email");
                    } else {
                        $_SESSION['status'] = 'Password and Confirm password not match.';
                        header("location: reset_password.php?token=$token&$email=$email");
                    }

                } else {
                    $_SESSION['status'] = 'Invalid Token.';
                    header("location: reset_password.php?token=$token&$email=$email");
                }

            } else {
                $_SESSION['status'] = 'Require all fields to be entered.';
                header("location: reset_password.php?token=$token&$email=$email");
            }

        }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Change password </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="public/backend/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="public/backend/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
    <link href="public/backend/css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="public/backend/css/style.css" rel="stylesheet" type="text/css">
    <link href="public/backend/css/pages/signin.css" rel="stylesheet" type="text/css">

</head>

<body>

    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="nav-collapse">
                    <ul class="nav pull-right">
                        <li class="">
                            <a href="login.php" class="">
                                Already have an account? Login now
                            </a>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
                <a class="brand" href="index.html">
                    Reset password:
                </a>

            </div> <!-- /container -->
        </div> <!-- /navbar-inner -->
    </div> <!-- /navbar -->

    <div class="account-container register">
        <div class="content clearfix">
            <form action="" method="post">
                <h1>Change password:</h1>
                <span style="color: green;"><?php echo (!empty($_SESSION['status'])) ? $_SESSION['status'] : ''; ?></span>
                <div class="login-fields">

                    <div class="field">
                        <label for="firstname">Email Address:</label>
                        <input type="text" id="firstname" name="email" value="<?php echo (isset($_GET['email'])) ? $_GET['email'] : ''; ?>" placeholder="Username" class="login" />
                    </div> <!-- /field -->

                    <div class="field">
                        <label for="firstname">Token:</label>
                        <input type="text" id="firstname" name="token" value="<?php echo (isset($_GET['token'])) ? $_GET['token'] : ''; ?>" placeholder="Username" class="login" />
                    </div> <!-- /field -->
                    <div class="field">
                        <label for="email">New password:</label>
                        <input type="text" id="email" name="newPassword" value="" placeholder="New Password" class="login" />
                        <span style="color: red;"><?php echo (!empty($errors['newPassword'])) ? $errors['newPassword'] : ''; ?></span>
                    </div> <!-- /field -->

                    <div class="field">
                        <label for="confirm_password">Confirm password:</label>
                        <input type="text" id="confirmPassword" name="confirmPassword" value="" placeholder="Confirm Password" class="login" />
                    </div> <!-- /field -->

                </div> <!-- /login-fields -->
                <div class="login-actions">
                    <input type="submit" name="update" class="button btn btn-primary btn-large" value="Update"/>
                </div> <!-- .actions -->

            </form>

        </div> <!-- /content -->

    </div> <!-- /account-container -->

    <script src="public/backend/js/jquery-1.7.2.min.js"></script>
    <script src="public/backend/js/bootstrap.js"></script>
    <script src="public/backend/js/signin.js"></script>

</body>

</html>
