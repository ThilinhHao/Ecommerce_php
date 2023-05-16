<?php
include 'layouts/header.php';

$username = $_SESSION['username'];

if (isset($_POST['register'])) {

    $errors = [];

    $name = '';
    if (empty(trim($_POST['name']))) {
        $errors['name'] = 'Please type username.';
    } elseif (strlen($_POST['name']) >= 5) {
        $name = $_POST['name'];
    } else {
        $errors['name'] = 'Requires more than 5 characters.';
    }

    $phone = '';
    if (empty(trim($_POST['phone']))) {
        $errors['phone'] = 'Please type phone.';
    } elseif (preg_match('/^[0-9]{10}+$/', $_POST['phone'])) {
        $phone = $_POST['phone'];
    } else {
        $errors['phone'] = 'Invalid phone.';
    }

    $email = $_POST['email'];
    $active = $_POST['active'];

    if (empty($errors)) {
        $sql = "INSERT INTO customers (`name`, `phone`, `email`, `active`) VALUES ('$name', '$phone', '$email', '$active')";
        mysqli_query($conn, $sql);
        header('location: profile.php');
    }
} elseif (isset($_GET['iddelete'])) {
    $id = $_GET['iddelete'];
    $sqlDelete = mysqli_query($conn, "DELETE FROM customers WHERE id = '$id' ");
    header('location: profile.php');
}
?>
<div class="maincontent-area">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="latest-product">
                    <form action="" method="post" >
                        <h4 class="section-title">Customer</h4>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name:</label>
                            <input type="text" class="form-control" name="name" aria-describedby="emailHelp">
                            <span style="color: red;"><?php echo (!empty($errors['name'])) ? $errors['name'] : ''; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Phone:</label>
                            <input type="text" class="form-control" name="phone" aria-describedby="emailHelp">
                            <span style="color: red;"><?php echo (!empty($errors['phone'])) ? $errors['phone'] : ''; ?></span>
                        </div>

                        <?php
                            $select = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' ");
                            $row = mysqli_fetch_array($select);
                        ?>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Email</label>
                            <input type="text" class="form-control" readonly name="email" id="exampleInputPassword1" value="<?php echo $row['email']; ?>">
                        </div>

                        <div class="form-group">
                            <select name="active">
                                <option class="span4" value="1">Display</option>
                                <option class="span4" value="0">Not display</option>
                            </select>
                        </div>

                        <input type="submit" name="register" class="btn btn-primary" value="Add"></input>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br/>

<div class="maincontent-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="latest-product">
                    <h5 class="section-title">History order</h5>
                    <table class="table table-striped table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" style="text-align: center">Name</th>
                                <th scope="col" style="text-align: center">Phone</th>
                                <th scope="col" style="text-align: center">Email</th>
                                <th scope="col" style="text-align: center">Total product</th>
                                <th scope="col" style="text-align: center">Total money</th>
                                <th scope="col" style="text-align: center">Date</th>
                            </tr>
                        </thead>
                        <?php
                            $username = $_SESSION['username'];
                            $selectUser = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' ");
                            $rowUser = mysqli_fetch_array($selectUser);
                            $rowEmail = $rowUser['email'];

                            $select = "SELECT * FROM orders WHERE `customer_email` = '$rowEmail'";
                            $selectCustomer = mysqli_query($conn, $select);

                            $count = 0;
                            while ($row = mysqli_fetch_array($selectCustomer)) {
                                $count ++;
                        ?>
                        <tbody>
                            <tr>
                                <th scope="row"><?php echo $count; ?></th>
                                <td style="text-align: center"><?php echo $row['customer_name']; ?></td>
                                <td style="text-align: center"><?php echo $row['customer_phone']; ?></td>
                                <td style="text-align: center"><?php echo $row['customer_email']; ?></td>
                                <td style="text-align: center"><a href="detail_order.php?idorder=<?php echo $row['id']; ?>"><?php echo $row['total_products']; ?></a></td>
                                <td style="text-align: center"><?php echo "$ " . number_format($row['total_money']); ?></td>
                                <td style="text-align: center"><?php echo $row['created_date']; ?></td>
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