<?php
    include 'config/database.php';
    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    function send_token($getName, $getEmail, $token) {
        $mail = new PHPMailer(true);

        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'thilinhhao2001@gmail.com';                     //SMTP username
        $mail->Password   = 'sifbeqhpxadwtexo';                               //SMTP password
        $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
        $mail->Port       = 465;

        $mail->setFrom('thilinhhao2001@gmail.com', $getName);
        $mail->addAddress($getEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Notification';
        // $fullUrl = $_SERVER['HTTP_REFERER'];
        // $arrUrl = explode('',$fullUrl);
        $emailTemplate = "
            <h2>Hello</h2>
            <h3>Gửi email thành công.</h3>
            <a href='http://localhost:3000/reset_password.php?token=$token&email=$getEmail'>Click me</a>
        ";
        $mail->Body = $emailTemplate;
        $mail->send();
    }

    if (isset($_POST['sendmail'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $token = rand(10000, 99999);

        $check = "SELECT * FROM users WHERE `email` = '$email' LIMIT 1";
        $query = mysqli_query($conn, $check);

        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query);
            $getName = $row['username'];
            $getEmail = $row['email'];

            $updateToken = "UPDATE users SET `token` = '$token' WHERE email = '$email' LIMIT 1";
            $run = mysqli_query($conn, $updateToken);

            if ($run) {
                send_token($getName, $getEmail, $token);
                $_SESSION['status'] = 'Email sent successfully.';
            } else {
                $_SESSION['status'] = 'Something went wrong.';
            }
        } else {
            $_SESSION['status'] = 'No Email Found.';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Forgot - Bootstrap Template</title>

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
                    Bootstrap fotgot Template
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
                <h1>Reset password</h1>
                <div class="login-fields">
                    <p>Please provide your details</p>
                    <span style="color: green;"><?php echo (!empty($_SESSION['status'])) ? $_SESSION['status'] : ''; ?></span>
                    <div class="field">
                        <label for="username">Email Address:</label>
                        <input type="text" id="email" name="email" value="" placeholder="Email" class="login"  />
                    </div> <!-- /field -->
                </div> <!-- /login-fields -->

                <div class="login-actions">
                    <input type="submit" name="sendmail" class="button btn btn-success btn-large" value="Send mail" />
                </div> <!-- .actions -->
            </form>
        </div> <!-- /content -->
    </div> <!-- /account-container -->

    <script src="public/backend/js/jquery-1.7.2.min.js"></script>
    <script src="public/backend/js/bootstrap.js"></script>
    <script src="public/backend/js/signin.js"></script>

</body>

</html>