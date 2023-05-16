<?php
include 'layouts/header.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function send_token($getName, $getEmail, $totalMoney) {
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
    $mail->Subject = 'Thank You For Your Order!';


    $message = "<h1>Đặt hàng thành công - Đơn hàng</h1>"
            ."<h3>Chào " . $getName . "</h3>"
            . "<h4>Cảm ơn bạn đã đặt hàng từ chúng tôi! Đơn hàng của bạn đã được xác nhận và sẽ được gửi đến bạn trong thời gian sớm nhất.</h4>"
            . "<p>Thông tin đơn hàng của bạn:</p>"
            . "<p>Tổng tiền: $ " . number_format($totalMoney)  . "</p>"
            . "<span>Xin cảm ơn bạn đã mua hàng!</span>";
    $emailTemplate = $message;
    $mail->Body = $emailTemplate;
    $mail->send();
}

$errors = [];

$username = $_SESSION['username'];

$selectUser = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' ");
$rowUser = mysqli_fetch_array($selectUser);

$rowEmail = $rowUser['email'];

$count = 0;
$money = 0;

while($row = mysqli_fetch_array($query)) {
    $count++;
    $money += ($row['product_price'] * $row['product_quantity']);
}

$totalQuantity = 0;
$totalPrice = 0;

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

foreach ($cart as $product) {
    $quantity = $product['quantity'];
    $price = $product['price'];
    $totalQuantity += $quantity;
    $totalPrice += $quantity * $price;
}

if (isset($_POST['Placeorder'])) {

    $name = '';
    if (empty(trim($_POST['name']))) {
        $errors['name'] = 'Please type username.';
    } elseif (strlen($_POST['name']) >= 5) {
        $name = $_POST['name'];
    } else {
        $errors['name'] = 'Requires more than 5 characters.';
    }

    $address = '';
    if (empty(trim($_POST['address']))) {
        $errors['address'] = 'Please type address.';
    } else {
        $address = $_POST['address'];
    }

    $_SESSION['address'] = $address;

    $phone = '';
    if (empty(trim($_POST['phone']))) {
        $errors['phone'] = 'Please type phone.';
    } elseif (preg_match('/^[0-9]{10}+$/', $_POST['phone'])) {
        $phone = $_POST['phone'];
    } else {
        $errors['phone'] = 'Invalid phone.';
    }


    $email = $_POST['email'];

    // if (isset($_POST['payment_method'])) {
    //     $payment = $_POST['payment_method'];
    //     echo $payment;
    // } else {
    //     echo 'rỗng';
    // }

    if ($email != $rowEmail) {
        $errors['email'] = 'Email does not match the registered account.';
    } else {
        if (empty($errors)) {
            if (isset($_POST['payment_method'])) {

                $sql = "INSERT INTO orders (`customer_name`, `customer_phone`, `customer_email`, `total_money`, `total_products`, `status`)
                        VALUES ('$name', '$phone', '$email', '$totalPrice', '$totalQuantity', 0)";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    $orderId = mysqli_insert_id($conn);

                    $total = 0;
                    $totalMoney = 0;

                    foreach ($_SESSION['cart'] as $cartItem) {
                        $total ++;
                        $productId = $cartItem['id'];
                        $productName = $cartItem['name'];
                        $productImage = $cartItem['image'];
                        $productPrice = $cartItem['price'];
                        $productQuantity = $cartItem['quantity'];

                        $totalMoney += $productPrice * $productQuantity;
                        $sql = "INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity, active)
                                VALUES ('$orderId', '$productId', '$productName', '$productImage', '$productPrice', '$productQuantity', 0)";
                        $queryCart = mysqli_query($conn, $sql);
                    }

                    if ($queryCart) {
                        send_token($username, $rowEmail, $totalMoney);
                        $_SESSION['email'] = 'Email sent successfully.';

                        header('location: order_success.php');
                    } else {
                        $_SESSION['email'] = 'Something went wrong.';
                    }

                }
            } else {
                $errors['payment'] = 'Payment Failed.';
            }

        }
    }
}

?>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="single-sidebar">
                    <h2 class="sidebar-title">Products</h2>
                    <?php
                        $sqlProduct = "SELECT * FROM products WHERE active != 2 ORDER BY sort_order ASC LIMIT 5";
                        $queryProduct = mysqli_query($conn, $sqlProduct);
                        while ($rowProducts = mysqli_fetch_array($queryProduct)) {
                            if ($rowProducts['active'] == 1) {
                    ?>
                    <div class="thubmnail-recent">
                        <a href="single_product.php?id=<?php echo $rowProducts['pid']; ?>"></a></a><img src="admin/uploads/<?php echo $rowProducts['image']; ?>" class="recent-thumb" alt="">
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
                        <form enctype="multipart/form-data" action="" class="checkout" method="post" name="checkout" onsubmit="return validateForm()">
                            <div id="customer_details" class="col2-set">
                                <div class="col-1">
                                    <div class="woocommerce-billing-fields">
                                        <h3>Billing Details</h3>

                                        <p id="billing_first_name_field" class="form-row form-row-first validate-required">
                                            <label class="" for="billing_first_name">Name <abbr title="required" class="required">*</abbr>
                                            </label>
                                            <input type="text" value="" placeholder="" id="billing_name" name="name" class="input-text ">
                                            <span style="color: red;"><?php echo (!empty($errors['name'])) ? $errors['name'] : ''; ?></span>
                                        </p>

                                        <p id="billing_first_name_field" class="form-row form-row-first validate-required">
                                            <label class="" for="billing_first_name">Address <abbr title="required" class="required">*</abbr>
                                            </label>
                                            <input type="text" value="" placeholder="" id="billing_name" name="address" class="input-text ">
                                            <span style="color: red;"><?php echo (!empty($errors['address'])) ? $errors['address'] : ''; ?></span>
                                        </p>

                                        <p id="billing_email_field" class="form-row form-row-first validate-required validate-email">
                                            <label class="" for="billing_email">Email Address <abbr title="required" class="required">*</abbr>
                                            </label>
                                            <input type="text" value="" placeholder="" id="billing_email" name="email" class="input-text ">
                                            <span style="color: red;"><?php echo (!empty($errors['email'])) ? $errors['email'] : ''; ?></span>
                                        </p>

                                        <p id="billing_phone_field" class="form-row form-row-last validate-required validate-phone">
                                            <label class="" for="billing_phone">Phone <abbr title="required" class="required">*</abbr>
                                            </label>
                                            <input type="text" value="" placeholder="" id="billing_phone" name="phone" class="input-text ">
                                            <span style="color: red;"><?php echo (!empty($errors['phone'])) ? $errors['phone'] : ''; ?></span>
                                        </p>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

                <h3 id="order_review_heading">Your order</h3>
                <div id="order_review" style="position: relative;">
                    <table class="shop_table">
                        <thead>
                            <tr>
                                <th class="product-name">Product</th>
                                <th class="product-total">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_SESSION['cart'])) {
                                $total = 0;
                                foreach ($_SESSION['cart'] as $key => $product) {
                                    $price = $product['price'];
                                    $quantity = $product['quantity'];
                                    $name = $product['name'];
                                    $subTotal = $price * $quantity;
                                    $total += $subTotal;
                            ?>
                                <tr>
                                    <td> <?php echo $name; ?> x <?php echo $quantity; ?></td>
                                    <td> <?php echo "$ " . number_format($price * $quantity); ?></td>
                                </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr class="order-total">
                                <th>Order Total</th>
                                <td><strong><span class="amount"><?php echo "$ " . number_format($total); ?></span></strong> </td>
                            </tr>
                        <?php } ?>
                        </tfoot>
                    </table>

                    <div id="payment">
                        <ul class="payment_methods methods">
                            <li class="payment_method_bacs">
                                <input type="radio" data-order_button_text=""  value="check" name="payment_method" class="input-radio" id="payment_method_bacs">
                                <label for="payment_method_bacs">Pay on receipt of goods. </label>
                                <span style="color: red;"><?php echo (!empty($errors['payment'])) ? $errors['payment'] : ''; ?></span>
                            </li>
                        </ul>
                        <div class="form-row place-order">
                            <input type="submit" data-value="Place order" value="Place order" id="place_order" name="Placeorder" class="button alt">
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include 'layouts/footer.php'; ?>