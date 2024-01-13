<?php
include 'layouts/header.php';
?>
<div class="slider-area">
    <!-- Slider -->
    <div class="block-slider block-slider4">
        <ul class="" id="bxslider-home4">
            <?php
            $sqlBanners = "SELECT * FROM banners WHERE active != 2 ORDER BY sort_order ASC";
            $query = mysqli_query($conn, $sqlBanners);
            while ($rowBanners = mysqli_fetch_array($query)) {
                if ($rowBanners['active'] == 1) {
            ?>
                    <li>
                        <img src="admin/uploads/<?php echo $rowBanners['image_url'] ?>" alt="Slide">
                        <div class="caption-group">
                            <h2 class="caption title">
                                <span class="primary"><?php echo $rowBanners['title']; ?><strong></strong></span>
                            </h2>
                            <h4 class="caption subtitle"><?php echo $rowBanners['content']; ?></h4>
                            <a class="caption button-radius" href="#"><span class="icon"></span>Shop now</a>
                        </div>
                    </li>
            <?php
                }
            }
            ?>
        </ul>
    </div>
    <!-- ./Slider -->
</div> <!-- End slider area -->

<div class="promo-area">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="single-promo promo1">
                    <i class="fa fa-refresh"></i>
                    <p>30 Days return</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="single-promo promo2">
                    <i class="fa fa-truck"></i>
                    <p>Free shipping</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="single-promo promo3">
                    <i class="fa fa-lock"></i>
                    <p>Secure payments</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="single-promo promo4">
                    <i class="fa fa-gift"></i>
                    <p>New products</p>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End promo area -->

<div class="maincontent-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="latest-product">
                    <h2 class="section-title">Latest Products</h2>
                    <div class="product-carousel">
                        <?php
                        $sqlProduct = "SELECT * FROM products WHERE active != 2 ORDER BY sort_order ASC";
                        $queryProduct = mysqli_query($conn, $sqlProduct);
                        while ($rowProducts = mysqli_fetch_array($queryProduct)) {
                            if ($rowProducts['active'] == 1) {
                        ?>
                                <div class="single-product">
                                    <div class="product-f-image">
                                        <img src="admin/uploads/<?php echo $rowProducts['image']; ?>" alt="">
                                        <div class="product-hover">
                                            <a href="single_product.php?id=<?php echo $rowProducts['pid']; ?>" class="view-details-link"><i class="fa fa-link"></i> See details</a>
                                        </div>
                                    </div>

                                    <h2><a href="single-product.php?id=<?php echo $rowProducts['pid']; ?>"><?php echo $rowProducts['name']; ?></a></h2>

                                    <div class="product-carousel-price">
                                        <ins><?php echo "$ " . number_format($rowProducts['price']); ?></ins> <del><?php echo "$ " . number_format($rowProducts['old_price']); ?></del>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End main content area -->

<div class="brands-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="brand-wrapper">
                    <div class="brand-list">
                        <?php
                        $sqlBrand = "SELECT * FROM brands WHERE active != 2 ORDER BY sort_order ASC";
                        $queryBrand = mysqli_query($conn, $sqlBrand);
                        while ($rowBrands = mysqli_fetch_array($queryBrand)) {
                            if ($rowBrands['active'] == 1) {
                        ?>
                                <img src="admin/uploads/<?php echo $rowBrands['image_url']; ?>" alt="">
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End brands area -->

<div class="product-widget-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="single-product-widget">
                    <h2 class="product-wid-title">Top Sellers</h2>
                    <?php
                        $sqlProduct = "SELECT * FROM products WHERE active != 2 AND is_best_sell = 1";
                        $queryProduct = mysqli_query($conn, $sqlProduct);
                        while ($rowProducts = mysqli_fetch_array($queryProduct)) {
                            if ($rowProducts['active'] == 1) {
                    ?>
                        <div class="single-wid-product">
                            <a href="single_product.php?id=<?php echo $rowProducts['pid']; ?>"><img src="admin/uploads/<?php echo $rowProducts['image'] ?>" alt="" class="product-thumb"></a>
                            <h2><a href="single_product.php?id=<?php echo $rowProducts['pid']; ?>" style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;"><?php echo $rowProducts['name']; ?></a></h2>
                            <div class="product-wid-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-wid-price">
                                <ins><?php echo "$ " . number_format($rowProducts['price']); ?></ins> <del><?php echo "$ " . number_format($rowProducts['old_price']); ?></del>
                            </div>
                        </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>

                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">Recently Viewed</h2>
                        <?php
                           if (isset($_SESSION['recently_viewed'])) {
                                $recentlyViewed = $_SESSION["recently_viewed"];
                                $recentlyViewedStr = implode(",", $recentlyViewed);
                                $sql = "SELECT * FROM products WHERE pid IN ($recentlyViewedStr)";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_array()) {
                        ?>
                            <div class="single-wid-product">
                                <a href="single_product.php?id=<?php echo $row['pid']; ?>"><img src="admin/uploads/<?php echo $row['image'] ?>" alt="" class="product-thumb"></a>
                                <h2><a href="single_product.php?id=<?php echo $row['pid']; ?>" style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;"><?php echo $row['name']; ?></a></h2>
                                <div class="product-wid-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product-wid-price">
                                    <ins><?php echo "$ " . number_format($row['price']); ?></ins>
                                    <del><?php echo "$ " . number_format($row['old_price']); ?></del>
                                </div>
                            </div>
                        <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>

            <div class="col-md-4">
                <div class="single-product-widget">
                    <h2 class="product-wid-title">Top New</h2>
                    <?php
                        $sqlProduct = "SELECT * FROM products WHERE active != 2 AND is_new = 1";
                        $queryProduct = mysqli_query($conn, $sqlProduct);
                        while ($rowProducts = mysqli_fetch_array($queryProduct)) {
                            if ($rowProducts['active'] == 1) {
                    ?>
                    <div class="single-wid-product">
                        <input type="hidden" name="product_id" value="<?php echo $rowProducts['pid']; ?>" />
                        <a href="single_product.php?id=<?php echo $rowProducts['pid']; ?>"><img src="admin/uploads/<?php echo $rowProducts['image'] ?>" alt="" class="product-thumb"></a>
                        <h2><a href="single_product.php?id=<?php echo $rowProducts['pid']; ?>" style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;"><?php echo $rowProducts['name']; ?></a></h2>
                        <div class="product-wid-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product-wid-price">
                            <ins><?php echo "$ " . number_format($rowProducts['price']); ?></ins> <del><?php echo "$ " . number_format($rowProducts['old_price']); ?></del>
                        </div>
                    </div>

                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End product widget area -->

<?php include 'layouts/footer.php'; ?>