<?php
    include 'config/database.php';
    
    $errors = [];
    if (isset($_POST['update'])) {
        $username = $_POST['username'];
        if ($username == '') {
            $errors['username'] = 'Please type username.';
        }

        $currentPassword = $_POST['currentPassword'];
        if ($currentPassword == '') {
            $errors['currentPassword'] = 'Please type current password.';
        }

        if (empty(trim($_POST['newPassword']))) {
            $errors['newPassword'] = 'Please type new password.';
        } elseif (preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $_POST['newPassword'])) {
            $newPassword = $_POST['newPassword'];
        } else {
            $errors['newPassword'] = 'Invalid password.';
        }

        $confirmPassword = $_POST['confirmPassword'];

        if (empty($errors)) {
            $sql = "SELECT * FROM users WHERE `username` = '$username' AND `password` = '$currentPassword' ";
            $row = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($row);

            if ($count > 0) {
                if ($newPassword === $confirmPassword){
                    $sqlUpdate = mysqli_query($conn, "UPDATE users SET `password` = '$newPassword' WHERE `username` = '$username'");
                    if ($sqlUpdate) {
                        header('location: login.php');
                    }
                } else {
                    $errors['change'] = 'password incorrect.';
                }
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

                <a class="brand" href="index.html">
                    Change password:
                </a>

                <div class="nav-collapse">
                    <ul class="nav pull-right">
                        <li class="">
                            <a href="index.php" class="">
                                <i class="icon-chevron-left"></i>
                                Back to Homepage
                            </a>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div> <!-- /container -->
        </div> <!-- /navbar-inner -->
    </div> <!-- /navbar -->

    <div class="account-container register">
        <div class="content clearfix">
            <form action="#" method="post">
                <h1>Change password:</h1>

                <div class="login-fields">

                    <div class="field">
                        <label for="firstname">Username:</label>
                        <input type="text" id="firstname" name="username" value="" placeholder="Username" class="login" />
                        <span style="color: red;"><?php echo (!empty($errors['username'])) ? $errors['username'] : ''; ?></span>
                    </div> <!-- /field -->

                    <div class="field">
                        <label for="lastname">Current password:</label>
                        <input type="text" id="lastname" name="currentPassword" value="" placeholder="Current Password" class="login" />
                        <span style="color: red;"><?php echo (!empty($errors['currentPassword'])) ? $errors['currentPassword'] : ''; ?></span>
                    </div> <!-- /field -->

                    <div class="field">
                        <label for="email">New password:</label>
                        <input type="text" id="email" name="newPassword" value="" placeholder="New Password" class="login" />
                        <span style="color: red;"><?php echo (!empty($errors['newPassword'])) ? $errors['newPassword'] : ''; ?></span>
                    </div> <!-- /field -->

                    <div class="field">
                        <label for="confirm_password">Confirm password:</label>
                        <input type="text" id="confirmPassword" name="confirmPassword" value="" placeholder="Confirm Password" class="login" />
                        <span style="color: red;"><?php echo (!empty($errors['change'])) ? $errors['change'] : ''; ?></span>
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