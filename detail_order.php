<?php
include 'layouts/header.php';
?>

<div class="maincontent-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="latest-product">
                <a href="profile.php"><input id="btnThem" type="button" value="Back"> </a>
                    <h5 class="section-title">Detail order</h5>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 5%;">No</th>
                                <th scope="col" style="width: 15%;">Image</th>
                                <th scope="col" style="width: 10%;">Name</th>
                                <th scope="col" style="width: 10%;">Quantity</th>
                                <td style="width: 45%;"></td>
                                <th scope="col" style="width: 15%;">Price</th>

                            </tr>
                        </thead>
                        <?php
                            if (isset($_GET['idorder'])) {
                                $id = $_GET['idorder'];
                            }

                            $select = "SELECT * FROM order_items WHERE `order_id` = '$id'";
                            $selectCustomer = mysqli_query($conn, $select);

                            $count = 0;
                            while ($row = mysqli_fetch_array($selectCustomer)) {
                                $count ++;
                        ?>
                        <tbody>
                            <tr>
                                <th scope="row"><?php echo $count; ?></th>
                                <td><img src="admin/uploads/<?php echo $row['product_image']; ?>" width="50%" ></td>
                                <td><?php echo $row['product_name']; ?></td>
                                <td><?php echo $row['product_quantity']; ?></td>
                                <td></td>
                                <td><?php echo "$ " . number_format($row['product_price']); ?></td>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>