<?php
    include 'layouts/header.php';

    if (isset($_POST['submit'])) {

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        $product_id = $_POST['product_id'];
        $product_name = $_POST['name'];
        $product_image = $_POST['image'];
        $product_price = $_POST['price'];
        $product_quantity = $_POST['quantity'];

        if (array_key_exists($product_id, $_SESSION['cart'])) {
            $_SESSION['cart'][$product_id]['quantity'] += $product_quantity;
        } else {
            $_SESSION['cart'][$product_id] = array(
                'name' => $product_name,
                'price' => $product_price,
                'id' => $product_id,
                'quantity' => $product_quantity,
                'image' => $product_image
            );
        }
    } elseif (isset($_POST['update_cart']) && !empty($_SESSION['cart'])) {
        $quantities = $_POST['quantity'];
        foreach ($_SESSION['cart'] as $key => $item) {
            if (isset($quantities[$item['id']])) {
                if ($quantities[$item['id']] == 0) {
                    unset($_SESSION['cart'][$key]);
                } else{
                    $_SESSION['cart'][$key]['quantity'] = $quantities[$item['id']];
                }
            }
        }
    } elseif(isset($_GET['delete'])) {
        $id = $_GET['delete'];

        unset($_SESSION['cart'][$id]);
        header('Location: cart.php');
    } elseif (isset($_GET['search'])) {
        $search = $_GET['search'];
        if ($search == '') {
            header("Location: shop.php");
        } else {
            header("Location: shop.php?search={$search}");
        }

    }
?>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="single-sidebar">
                    <h2 class="sidebar-title">Search Products</h2>
                    <form action="">
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
                    <div class="woocommerce">
                        <form method="post" action="">
                            <table cellspacing="0" class="shop_table cart">
                                <thead>
                                    <tr>
                                        <th class="product-remove">&nbsp;</th>
                                        <th class="product-thumbnail">Image</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $total = 0;
                                        $count = 0;
                                        if (!empty($_SESSION['cart'])) {
                                            foreach ($_SESSION['cart'] as $key => $product) {
                                                $id = $product['id'];
                                                $price = $product['price'];
                                                $quantity = $product['quantity'];
                                                $image = $product['image'];
                                                $name = $product['name'];
                                                $subTotal = $price * $quantity;
                                                $total += $subTotal;
                                                $count ++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $count; ?></td>
                                            <td><img src="admin/uploads/<?php echo $image; ?>" width="145" height="145"></td>
                                            <td> <?php echo $name; ?></td>
                                            <td> <?php echo "$ " . number_format($price); ?></td>
                                            <td>
                                                <input type="number" size="4" name="quantity[<?php echo $id; ?>]" class="input-text qty text" title="Qty" value="<?php echo $quantity; ?>" min="0" step="1">
                                                <input type="hidden" name="product_id[]" value="<?php echo $id; ?>"/>
                                            </td>
                                            <td>
                                                <a href="cart.php?delete=<?php echo $id; ?>">Delete</a>
                                            </td>
                                        </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td class="actions" colspan="6">
                                            <input type="submit" value="Update Cart" name="update_cart" class="button">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>

                        <div class="cart-collaterals">
                            <div class="cart_totals">
                                <h2>Cart Totals</h2>

                                <table cellspacing="0">
                                    <tbody>
                                        <tr class="order-total">
                                            <th>Order Total</th>
                                            <td><strong><span class="amount"><?php echo "$ " . number_format($total); ?></span></strong> </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                                    if (!empty($_SESSION['cart'])) {
                                ?>
                                        <div class="product-option-shop">
                                            <a class="add_to_cart_button" href="checkout.php">Checkout</a>
                                        </div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'layouts/footer.php'; ?>