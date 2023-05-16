<?php
    include 'config/database.php';
    session_start();

    $errors = [];
    if (isset($_POST['signIn'])) {
        $username = '';
        if (empty(trim($_POST['username']))) {
            $errors['username'] = 'Please type username';
        } else {
            $username = trim($_POST['username']);
        }

        $password = '';
        if (empty(trim($_POST['password']))) {
            $errors['password'] = 'Please type password';
        } else {
            $password = trim(md5($_POST['password']));
        }

        if (empty($errors)) {
            $sql = "SELECT * FROM users WHERE `username` = '$username' AND `password` = '$password' ";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $count = mysqli_num_rows($result);

            if ($count > 0) {
                if ($row['active'] == 0 || $row['active'] == 1) {
                    $_SESSION['username'] = $row['username'];
                    header('location: index.php');
                } elseif ($row['active'] == 3) {
                    $_SESSION['active'] = 3;
                    $_SESSION['username'] = $row['username'];
                    header('location: admin/index.php');
                }

            } else {
                $errors['login'] = 'Username or password incorrent.';
            }

        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login</title>

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

                <a class="brand" href="">
                    Login
                </a>

                <div class="nav-collapse">
                    <ul class="nav pull-right">

                        <li class="">
                            <a href="signup.php" class="">
                                Don't have an account?
                            </a>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div> <!-- /container -->
        </div> <!-- /navbar-inner -->
    </div> <!-- /navbar -->

    <div class="account-container">
        <div class="content clearfix">
            <form action="#" method="post">
                <h1>Member Login</h1>
                <div class="login-fields">
                    <p>Please provide your details</p>
                    <span style="color: red;"><?php echo (!empty($errors['login'])) ? $errors['login'] : ''; ?></span>
                    <div class="field">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" value="" placeholder="Username" class="login username-field" />
                        <span style="color: red;"><?php echo (!empty($errors['username'])) ? $errors['username'] : ''; ?></span>
                    </div> <!-- /field -->

                    <div class="field">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field" />
                        <span style="color: red;"><?php echo (!empty($errors['password'])) ? $errors['password'] : ''; ?></span>
                    </div> <!-- /password -->

                </div> <!-- /login-fields -->

                <div class="login-actions">
                    <span class="login-checkbox">
                        <div class="field login-checkbox">
                            <a href="forgot.php">Forgot password?</a>
                        </div>
                    </span>
                    <input type="submit" name="signIn" class="button btn btn-success btn-large" value="Sign In"/>
                </div> <!-- .actions -->
            </form>
        </div> <!-- /content -->
    </div> <!-- /account-container -->

    <script src="public/js/jquery-1.7.2.min.js"></script>
    <script src="public/js/bootstrap.js"></script>
    <script src="public/js/signin.js"></script>

</body>

</html>