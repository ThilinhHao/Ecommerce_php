<?php include 'comm.php'; ?>

<body>
    <?php
    include '../common/include.php';
    include '../common/header.php';
    include 'inc.php';
    ?>

    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <a href="index.php"><input id="btnThem" type="button" value="Back to index"> </a>
                        <div class="widget widget-table action-table">
                            <div class="widget-header"> <i class="icon-th-list"></i>
                                <h3>List orders detail</h3>
                            </div>
                            <div class="widget-content">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th style="width: 20%;">Image</th>
                                            <th style="width: 10%;">Name</th>
                                            <th style="width: 5%; text-align: center;">Quantity</th>
                                            <th style="width: 45%;"></th>
                                            <th style="width: 15%;">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['order_id'])) {
                                            $orderId = $_GET['order_id'];
                                        }
                                        $count = 0;
                                        $sql = "SELECT * FROM order_items WHERE order_id = '$orderId'";
                                        $query = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_array($query)) {
                                            $count++;
                                        ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td> <img src="../../uploads/<?php echo $row['product_image']; ?>" width="30%"> </td>
                                                <td> <?php echo $row['product_name']; ?></td>
                                                <td style="text-align: center;"> <?php echo $row['product_quantity']; ?> </td>
                                                <td></td>
                                                <td> <?php echo "$ " . number_format($row['product_price']); ?> </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        include '../../layouts/footer.php';
        include 'footer.php';
        ?>

</body>

</html>