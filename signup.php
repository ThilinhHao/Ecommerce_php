<?php
    include 'config/database.php';

    $errors = [];
    if (isset($_POST['register'])) {

        $username = '';
        if (empty(trim($_POST['username']))) {
            $errors['username'] = 'Please type username.';
        } elseif(strlen($_POST['username']) >= 5) {
            $username = $_POST['username'];
        } else {
            $errors['username'] = 'Requires more than 5 characters.';
        }

        $email = '';
        if (empty(trim($_POST['email']))) {
            $errors['email'] = 'Please type email.';
        } elseif (filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) {
            $email = $_POST['email'];
        } else {
            $errors['email'] = 'Invalid email.';
        }

        $password = '';
        if (empty(trim($_POST['password']))) {
            $errors['password'] = 'Please type password.';
        }elseif (preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $_POST['password'])) {
            $password = md5($_POST['password']);
        } else {
            $errors['password'] = 'Invalid password.';
        }

        $confirmPassword = md5($_POST['confirmPassword']);

        if (empty($errors)) {
            if ($password === $confirmPassword) {
                $sql = "SELECT * FROM users WHERE (`username` = '$username' AND `email` = '$email') ";
                $number = mysqli_query($conn, $sql);
                if (mysqli_num_rows($number) == 0) {
                    $sql = "INSERT INTO users (`username`, `email`, `password`) VALUES ('$username','$email', '$password')";
                    $query = mysqli_query($conn, $sql);
                    header('location: login.php');
                } else {
                    $errors['register'] = 'Same username or email.';
                }

            } else {
                $errors['confirmPassword'] = 'password does not match';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Signup</title>

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

                <a class="brand">
                    Signup shop
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
            </div> <!-- /container -->
        </div> <!-- /navbar-inner -->
    </div> <!-- /navbar -->

    <div class="account-container register">
        <div class="content clearfix">
            <form action="" method="POST">
                <h1>Member Login</h1>
                <div class="login-fields">
                    <p>Please provide your details</p>
                    <span style="color: red;"><?php echo (!empty($errors['register'])) ? $errors['register'] : ''; ?></span>
                    <div class="field">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" value="" placeholder="Username" class="login" />
                        <span style="color: red;"><?php echo (!empty($errors['username'])) ? $errors['username'] : ''; ?></span>
                    </div> <!-- /field -->

                    <div class="field">
                        <label for="username">Email:</label>
                        <input type="text" id="email" name="email" value="" placeholder="Email" class="login"  />
                        <span style="color: red;"><?php echo (!empty($errors['email'])) ? $errors['email'] : ''; ?></span>
                    </div> <!-- /field -->

                    <div class="field">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" value="" placeholder="Password" class="login"  />
                        <span style="color: red;"><?php echo (!empty($errors['password'])) ? $errors['password'] : ''; ?></span>
                    </div> <!-- /password -->

                    <div class="field">
                        <label for="username">Confirm password:</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" value="" placeholder="confirmPassword" class="login"  />
                        <span style="color: red;"><?php echo (!empty($errors['confirmPassword'])) ? $errors['confirmPassword'] : ''; ?></span>
                    </div> <!-- /field -->

                </div> <!-- /login-fields -->

                <div class="login-actions">
                    <span class="login-checkbox">
                        <input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
                        <label class="choice" for="Field">Keep me signed in</label>
                    </span>
                    <input type="submit" name="register" class="button btn btn-success btn-large" value="Register" />
                </div> <!-- .actions -->
            </form>
        </div> <!-- /content -->
    </div> <!-- /account-container -->


    <!-- Text Under Box -->
    <div class="login-extra">
        Already have an account? <a href="login.php">Login to your account</a>
    </div> <!-- /login-extra -->

    <script src="public/backend/js/jquery-1.7.2.min.js"></script>
    <script src="public/backend/js/bootstrap.js"></script>
    <script src="public/backend/js/signin.js"></script>

</body>

</html>