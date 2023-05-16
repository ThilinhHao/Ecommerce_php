<?php
include 'config/database.php';
session_start();
if (!isset($_SESSION['username'])) {
    header('location: login.php');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ustora</title>

    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="public/fontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/fontend/css/font-awesome.min.css">
    <link rel="stylesheet" href="public/fontend/css/owl.carousel.css">
    <link rel="stylesheet" href="public/fontend/style.css">
    <link rel="stylesheet" href="public/fontend/css/responsive.css">
    <link rel="stylesheet" href="public/fontend/css/form.css">

</head>

<body>
    <div class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="user-menu">
                        <ul>
                            <li><a href="profile.php"><i class="fa fa-user"></i> <?php echo $_SESSION['username']; ?></a></li>
                            <li><a href="change.php"><i class="fa fa-user"></i> Change password</a></li>
                            <li>
                                <a href="logout.php"><i class="fa fa-user"></i> Logout</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End header area -->

    <div class="site-branding-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="logo">
                        <h1><a href="./"><img src="public/fontend/img/logo.png"></a></h1>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="shopping-item">
                        <a href="cart.php">My cart<i class="fa fa-shopping-cart"></i>
                        <?php
                            $count = 0;
                            if (isset($_SESSION['cart'])) {
                                foreach ($_SESSION['cart'] as $key => $product) {
                                    $count ++;
                                }
                        ?>
                            <span class="product-count"><?php echo $count; } ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End site branding area -->

    <div class="mainmenu-area">
        <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="shop.php">Shope page</a></li>
                        <?php
                        $sqlCategories = "SELECT * FROM categories WHERE active != 2 ORDER BY sort_order ASC";
                        $query = mysqli_query($conn, $sqlCategories);
                        while ($rowCategories = mysqli_fetch_array($query)) {
                            if ($rowCategories['active'] == 1) {
                        ?>
                                <li><a href="category.php?categoryid=<?php echo $rowCategories['id']; ?>"><?php echo $rowCategories['cname']; ?></a></li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div> <!-- End mainmenu area -->
