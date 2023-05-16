<?php
include 'layouts/header.php';

$pages = mysqli_query($conn, "SELECT * FROM products WHERE active != 2 AND active != 0");
$count = mysqli_num_rows($pages);
$item = 12;
$size = ceil($count / $item);

$page = '';
if (isset($_GET['page'])) {
    if ($_GET['page'] <= $size && $_GET['page'] > 0) {
        $page = $_GET['page'];
    }
}

$begin = 0;
if ($page == '' || $page == 1) {
    $begin = 0;
} else {
    $begin = ($page * 3) - 3;
}
?>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <?php
            if (isset($_GET['categoryid'])) {
                $id = $_GET['categoryid'];
                $sqlProduct = "SELECT * FROM products WHERE active != 2 AND category_id = '$id' ORDER BY sort_order ASC LIMIT $begin, $item";
                $queryProduct = mysqli_query($conn, $sqlProduct);
                while ($rowProducts = mysqli_fetch_array($queryProduct)) {
                    if ($rowProducts['active'] == 1) {
            ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="single-shop-product">
                                <div class="product-upper">
                                    <img src="admin/uploads/<?php echo $rowProducts['image']; ?>" alt="">
                                </div>
                                <h2><a href=""><?php echo $rowProducts['name']; ?></a></h2>
                                <div class="product-carousel-price">
                                    <ins><?php echo number_format($rowProducts['price']) . ' VNĐ'; ?></ins> <del><?php echo number_format($rowProducts['old_price']) . ' VNĐ'; ?></del>
                                </div>

                                <form method="post" action="cart.php?idproduct=<?php echo $rowProducts['pid']; ?>" class="cart">
                                    <input type="hidden" name="image" value="<?php echo $rowProducts['image']; ?>" />
                                    <input type="hidden" name="name" value="<?php echo $rowProducts['name']; ?>" />
                                    <input type="hidden" name="price" value="<?php echo $rowProducts['price']; ?>" />
                                    <input type="hidden" name="quantity" value="1" />

                                    <button class="add_to_cart_button" type="submit" name="submit">Add to cart</button>
                                </form>
                            </div>
                        </div>
            <?php
                    }
                }
            }
            ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="product-pagination text-center">
                    <nav>
                        <ul class="pagination">
                            <?php
                            if ($size >= 2) {
                                for ($i = 1; $i <= $size; $i++) {

                            ?>
                                    <li class="page-item">
                                        <a <?php echo ($i == $page) ? 'style="background: black";' : ''; ?> class="page-link" href="shop.php?page=<?php echo $i; ?>"> <?php echo $i; ?> </a>
                                    </li>
                            <?php
                                }
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>