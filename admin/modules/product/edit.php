<?php
include '../common/include.php';

$id =  $_GET['idproducts'];
$sql = "SELECT * FROM products WHERE pid = '$id' LIMIT 1";
$query = mysqli_query($conn, $sql);

if (isset($_POST['edit'])) {
    $names = $_POST['names'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $oldprice = $_POST['oldprice'];
    $description = $_POST['description'];
    $tags = $_POST['tags'];
    $best = $_POST['best'];
    $new = $_POST['new'];
    $image = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $image = time() . '_' . $image;
    $active = $_POST['active'];


    if ($_FILES['image']['name'] != '') {
        move_uploaded_file($imageTmp, '../../uploads/' . $image);
        $sql = "UPDATE products SET  `name` = '$names', `category_id` ='$category', `brand_id` ='$brand', `price` = '$price', `old_price` = '$oldprice', `description` = '$description', `tags` = '$tags', `is_best_sell` = '$best', `is_new` = '$new', `image` = '$image', `active` = '$active' WHERE pid = '$id'";
        $query = mysqli_query($conn, $sql);
        header('location: index.php');
    } else {
        $sql = "UPDATE products SET `name` = '$names', `category_id` ='$category', `brand_id` ='$brand',  `price` = '$price', `old_price` = '$oldprice', `description` = '$description', `tags` = '$tags', `is_best_sell` = '$best', `is_new` = '$new', `active` = '$active' WHERE pid = '$id'";
        $query = mysqli_query($conn, $sql);
        header('location: index.php');
    }
}
?>

<?php include 'comm.php'; ?>

<body>
    <?php
        include '../common/header.php';
        include 'inc.php';
    ?>

    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div class="widget ">
                            <div class="widget-header">
                                <i class="icon-user"></i>
                                <h3>Products</h3>
                            </div>
                            <div class="widget-content">
                                <table class="table table-striped table-bordered">
                                    <?php
                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                        <form id="edit-profile" class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <fieldset>
                                                <div class="control-group">
                                                    <label class="control-label">Name:</label>
                                                    <div class="controls">
                                                        <input type="text" class="span4" name="names" value="<?php echo $row['name']; ?>">
                                                    </div> <!-- /controls -->
                                                </div> <!-- /control-group -->

                                                <div class="control-group">
                                                    <label class="control-label">Category:</label>
                                                    <div class="controls">
                                                        <select name="category" class="span4">
                                                            <?php
                                                            $q = "SELECT * FROM categories";
                                                            $rs = mysqli_query($conn, $q);
                                                            if (mysqli_num_rows($rs) > 0) {
                                                                $i = 0;
                                                                while ($r = mysqli_fetch_assoc($rs)) {
                                                                    $i++;
                                                                    $cid = $r['id'];
                                                                    $name = $r['cname'];
                                                                    echo "<option value= '$cid'>$name</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Brand:</label>
                                                    <div class="controls">
                                                        <select name="brand" class="span4">
                                                            <?php
                                                            $qu = "SELECT * FROM brands";
                                                            $rsi = mysqli_query($conn, $qu);
                                                            if (mysqli_num_rows($rs) > 0) {
                                                                $i = 0;
                                                                while ($ri = mysqli_fetch_assoc($rsi)) {
                                                                    $i++;
                                                                    $bid = $ri['id'];
                                                                    $name = $ri['bname'];
                                                                    echo "<option value= '$bid'>$name</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Price:</label>
                                                    <div class="controls">
                                                        <input type="text" class="span4" name="price" value="<?php echo $row['price']; ?>">
                                                    </div> <!-- /controls -->
                                                </div> <!-- /control-group -->

                                                <div class="control-group">
                                                    <label class="control-label">Image:</label>
                                                    <div class="controls">
                                                        <input type="file" class="span4" name="image">
                                                        <img src="../../uploads/<?php echo $row['image']; ?>" width="10%">
                                                    </div> <!-- /controls -->
                                                </div> <!-- /control-group -->

                                                <div class="control-group">
                                                    <label class="control-label">Price old:</label>
                                                    <div class="controls">
                                                        <input type="text" class="span4" name="oldprice" value="<?php echo $row['old_price']; ?>">
                                                    </div> <!-- /controls -->
                                                </div> <!-- /control-group -->

                                                <div class="control-group">
                                                    <label class="control-label">Discription:</label>
                                                    <div class="controls">
                                                        <input type="text" class="span4" name="description" value="<?php echo $row['description']; ?>">
                                                    </div> <!-- /controls -->
                                                </div> <!-- /control-group -->

                                                <div class="control-group">
                                                    <label class="control-label">Label:</label>
                                                    <div class="controls">
                                                        <input type="text" class="span4" name="tags" value="<?php echo $row['tags']; ?>">
                                                    </div> <!-- /controls -->
                                                </div> <!-- /control-group -->

                                                <div class="control-group">
                                                    <label class="control-label">Best sell:</label>
                                                    <div class="controls">
                                                        <input type="text" class="span4" name="best" value="<?php echo $row['is_best_sell']; ?>">
                                                    </div> <!-- /controls -->
                                                </div> <!-- /control-group -->

                                                <div class="control-group">
                                                    <label class="control-label">Best new:</label>
                                                    <div class="controls">
                                                        <input type="text" class="span4" name="new" value="<?php echo $row['is_new']; ?>">
                                                    </div> <!-- /controls -->
                                                </div> <!-- /control-group -->

                                                <div class="control-group">
                                                    <label class="control-label">Status:</label>
                                                    <div class="controls">
                                                        <select name="active" class="span4">
                                                            <?php
                                                            if ($row['active'] == 1) {
                                                            ?>
                                                                <option class="span4" value="0">No display</option>
                                                                <option class="span4" value="1" selected>Display</option>

                                                            <?php
                                                            }
                                                            if ($row['active'] == 0) {
                                                            ?>
                                                                <option class="span4" value="0" selected>No display</option>
                                                                <option class="span4" value="1">Display</option>

                                                            <?php
                                                            }
                                                              ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-actions">
                                                    <input type="submit" name="edit" class="btn btn-primary" value="Sửa">
                                                    <button class="btn btn-primary" ><a href="index.php" style="text-decoration: none; color:aliceblue;">Cancel</a></button>
                                                </div> <!-- /form-actions -->
                                            </fieldset>
                                        </form>
                                    <?php } ?>
                                </table>
                            </div>
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