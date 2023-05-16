<?php
    session_start();

    if ($_SESSION['active'] !== 3) {
        header('Location: ../login.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin</title>
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
                    <li class=""><a href="modules/banners/index.php"><i class="shortcut-icon icon-tag"></i><span>Banners</span> </a> </li>
                    <li><a href="modules/orders/index.php"><i class="shortcut-icon icon-file"></i><span>Orders</span> </a> </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <!-- /span6 -->
                    <div class="span12">
                        <div class="widget">
                            <div class="widget-header">
                                <h3>Dashboard</h3>
                            </div>
                            <!-- /widget-header -->
                            <div class="widget-content">
                                <div class="shortcuts">
                                    <a href="modules/category/index.php" class="shortcut">
                                        <i class="shortcut-icon icon-bookmark"></i><span class="shortcut-label">Category</span>
                                    </a>
                                    <a href="modules/brand/index.php" class="shortcut">
                                        <i class="shortcut-icon icon-comment"></i><span class="shortcut-label">Brand</span>
                                    </a>
                                    <a href="modules/product/index.php" class="shortcut">
                                        <i class="shortcut-icon icon-file"></i><span class="shortcut-label">Product</span>
                                    </a>
                                    <a href="modules/product_image/index.php" class="shortcut">
                                        <i class="shortcut-icon icon-picture"></i> <span class="shortcut-label">Image product</span>
                                    </a>
                                    <a href="modules/users/index.php" class="shortcut">
                                        <i class="shortcut-icon icon-user"></i><span class="shortcut-label">Users</span>
                                    </a>
                                    <a href="modules/banners/index.php" class="shortcut">
                                        <i class="shortcut-icon icon-tag"></i><span class="shortcut-label">Banners</span>
                                    </a>
                                    <a href="modules/order/index.php" class="shortcut">
                                        <i class="shortcut-icon icon-file"></i><span class="shortcut-label">Orders</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'layouts/footer.php'; ?>
</body>

</html>