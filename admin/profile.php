<?php
    session_start();
    include '../config/database.php';
    $errors = [];
    if (!isset($_SESSION['username'])) {
        header('location: ../login.php');
    } elseif (isset($_POST['edit'])) {
        $username = '';
        if (empty(trim($_POST['username']))) {
            $errors['username'] = 'Please type username';
        } else {
            $username = $_POST['username'];
        }

        $email = '';
        if (empty(trim($_POST['email']))) {
            $errors['email'] = 'Please type email';
        } else {
            $email = $_POST['email'];
        }

        if (empty($errors)) {
            $sqlUpdate = "UPDATE users SET `username` = '$username', `email` = '$email' WHERE active = 3";
            mysqli_query($conn, $sqlUpdate);
            header('location: ../login.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Profile-Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="../public/backend/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/backend/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="../public/backend/css/font-awesome.css" rel="stylesheet">
    <link href="../public/backend/css/style.css" rel="stylesheet">
    <link href="../public/backend/css/pages/dashboard.css" rel="stylesheet">
</head>

<body>
    <?php include 'layouts/header.php'; ?>

    <div class="subnavbar">
        <div class="subnavbar-inner">
            <div class="container">
                <ul class="mainnav">
                    <li class="active"><a href="index.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
                    <li><a href="modules/category/index.php"><i class="shortcut-icon icon-bookmark"></i><span>Category</span> </a> </li>
                    <li><a href="modules/brand/index.php"><i class="shortcut-icon icon-comment"></i><span>Brand</span> </a> </li>
                    <li><a href="modules/product/index.php"><i class="shortcut-icon icon-file"></i><span>Product</span> </a> </li>
                    <li><a href="modules/product_image/index.php"><i class="shortcut-icon icon-picture"></i><span>Image product</span> </a> </li>
                    <li><a href="modules/users/index.php"><i class="shortcut-icon icon-user"></i><span>Users</span> </a> </li>
                    <li class=""><a href="modules/banners/index.php"><i class="icon-code"></i><span>Banners</span> </a> </li>
                    <li><a href="modules/orders/index.php"><i class="shortcut-icon icon-file"></i><span>Orders</span> </a> </li>
                </ul>
            </div>
        </div>
    </div>
    <?php
        $sql = "SELECT * FROM users WHERE active = 3";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);
        if ($row['username'] == $_SESSION['username']) {
    ?>
    <div class="tab-pane" id="formcontrols">
        <h3>Information admin:</h3>
        <br>
        <form id="edit-profile" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="firstname">Username:</label>
                    <div class="controls">
                        <input type="text" class="span2" name="username" value="<?php echo $row['username']; ?>">
                        <span style="color: red;"><?php echo (!empty($errors['username'])) ? $errors['username'] : ''; ?></span>
                    </div> <!-- /controls -->
                </div> <!-- /control-group -->

                <div class="control-group">
                    <label class="control-label">Email:</label>
                    <div class="controls">
                        <input type="text" class="span2" name="email" value="<?php echo $row['email']; ?>">
                        <span style="color: red;"><?php echo (!empty($errors['username'])) ? $errors['username'] : ''; ?></span>
                    </div> <!-- /controls -->
                </div> <!-- /control-group -->

                <div class="control-group">
                    <label class="control-label">Type:</label>
                    <div class="controls">
                        <input type="text" readonly class="span2" value="Admin">
                    </div> <!-- /controls -->
                </div> <!-- /control-group -->

                <div class="form-actions">
                    <input type="submit" name="edit" class="btn btn-primary" value="Sửa">
                </div> <!-- /form-actions -->
            </fieldset>
        </form>
    </div>
    <?php } ?>
    <?php include 'layouts/footer.php'; ?>
</body>

</html>