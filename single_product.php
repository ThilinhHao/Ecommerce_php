<?php
include 'layouts/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lưu ID của sản phẩm đã xem gần đây vào session
    if (isset($_SESSION['recently_viewed'])) {
        $recentlyViewed = $_SESSION['recently_viewed'];
    } else {
        $recentlyViewed = array();
    }
    array_unshift($recentlyViewed, $id);
    $_SESSION['recently_viewed'] = array_slice($recentlyViewed, 0, 4);

    $sqlProduct = "SELECT * FROM products WHERE pid = '$id' ORDER BY sort_order ASC";
    $queryProduct = mysqli_query($conn, $sqlProduct);
    $rowProduct = mysqli_fetch_array($queryProduct);

    $idCategory = $rowProduct['category_id'];
    $sqlCategory = "SELECT * FROM categories WHERE id = '$idCategory' ORDER BY sort_order ASC";
    $queryCategory = mysqli_query($conn, $sqlCategory);
    $rowCategory = mysqli_fetch_array($queryCategory);

} elseif (isset($_GET['search'])) {
    $search = $_GET['search'];
    header("Location: shop.php?search={$search}");
} else {
    header('location: index.php');
}
?>

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Single Product</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="single-sidebar">
                    <h2 class="sidebar-title">Search Products</h2>
                    <form action="" method="get">
                        <input type="text" name="search" placeholder="Search products...">
                        <input type="submit" value="Search">
                    </form>
                </div>

                <div class="single-sidebar">
                    <h2 class="sidebar-title">Products</h2>
                    <?php
                        $sqlProduct = "SELECT * FROM products WHERE active != 2 ORDER BY sort_order ASC LIMIT 5";
                        $queryProduct = mysqli_query($conn, $sqlProduct);
                        while ($rowProducts = mysqli_fetch_array($queryProduct)) {
                            if ($rowProducts['active'] == 1) {
                    ?>
                    <div class="thubmnail-recent">
                        <a href="single_product.php?id=<?php echo $rowProducts['pid']; ?>"><img src="admin/uploads/<?php echo $rowProducts['image']; ?>" class="recent-thumb" alt=""></a>
                        <h2><a href="single_product.php?id=<?php echo $rowProducts['pid']; ?>"><?php echo $rowProducts['name']; ?></a></h2>
                        <div class="product-sidebar-price">
                            <ins><?php echo "$ " . number_format($rowProducts['price']); ?></ins> <del><?php echo "$ " . number_format($rowProducts['old_price']); ?></del>
                        </div>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="col-md-8">
                <div class="product-content-right">
                    <div class="product-breadcroumb">
                        <a href="index.php">Home</a>
                        <a href="category.php?categoryid=<?php echo $rowCategory['id']; ?>"><?php echo $rowCategory['cname']; ?></a>
                        <a href="single_product.php?id=<?php echo $rowProduct['pid']; ?>"><?php echo $rowProduct['name']; ?></a>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="product-images">
                                <div class="product-main-img">
                                    <img src="admin/uploads/<?php echo $rowProduct['image']; ?>" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="product-inner">
                                <h2 class="product-name"><?php echo $rowProduct['name']; ?></h2>
                                <div class="product-inner-price">
                                    <ins><?php echo "$ " . number_format($rowProduct['price']); ?></ins> <del><?php echo "$ " . number_format($rowProduct['old_price']); ?></del>
                                </div>

                                <form method="post" action="cart.php" class="cart">
                                    <input type="hidden" name="image" value="<?php echo $rowProduct['image']; ?>" />
                                    <input type="hidden" name="name" value="<?php echo $rowProduct['name']; ?>" />
                                    <input type="hidden" name="price" value="<?php echo $rowProduct['price']; ?>" />
                                    <input type="hidden" name="quantity" value="1" />
                                    <input type="hidden" name="product_id" value="<?php echo $rowProduct['pid']; ?>" />

                                    <button class="add_to_cart_button" type="submit" name="submit">Add to cart</button>
                                </form>

                                <div role="tabpanel">
                                    <ul class="product-tab" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
                                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Reviews</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="home">
                                            <h2>Product Description</h2>
                                            <p><?php echo $rowProduct['description']; ?></p>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="profile">
                                            <h2>Reviews</h2>
                                            <div class="submit-review">
                                                <p><label for="name">Name</label> <input name="name" type="text"></p>
                                                <p><label for="email">Email</label> <input name="email" type="email"></p>
                                                <div class="rating-chooser">
                                                    <p>Your rating</p>

                                                    <div class="rating-wrap-post">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </div>
                                                <p><label for="review">Your review</label> <textarea name="review" id="" cols="30" rows="10"></textarea></p>
                                                <p><input type="submit" value="Submit"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="related-products-wrapper">
                        <h2 class="related-products-title">Related Products</h2>
                        <div class="related-products-carousel">
                        <?php
                            $productId = $_GET['id'];
                            $sql = "SELECT * FROM products WHERE pid = $productId";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $product = $result->fetch_assoc();
                            }

                            $similarProducts = array();
                            if (!empty($product)) {
                                $productName = $product["name"];
                                $productCategory = $product["category_id"];
                                $productBrand = $product["brand_id"];
                                $sql = "SELECT * FROM products WHERE pid != $productId AND category_id = '$productCategory' AND brand_id = '$productBrand' ORDER BY RAND() LIMIT 3";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $similarProducts[] = $row;
                                    }
                                }
                            }

                            if (!empty($similarProducts)) {
                                foreach ($similarProducts as $product) {
                            }
                        ?>
                            <div class="single-product">
                                <div class="product-f-image">
                                    <img src="admin/uploads/<?php echo $product['image']; ?>" alt="">
                                    <div class="product-hover">
                                        <a href="single_product.php?id=<?php echo $product['pid']; ?>" class="view-details-link"><i class="fa fa-link"></i> See details</a>
                                    </div>
                                </div>

                                <h2><a href=""><?php echo $product['name'] ?></a></h2>

                                <div class="product-carousel-price">
                                    <ins><?php echo "$ " . number_format($product['price']); ?></ins> <del><?php echo "$ " . number_format($product['old_price']); ?></del>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>