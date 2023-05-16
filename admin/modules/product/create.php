<?php
include '../common/include.php';

$errors = [];
if (isset($_POST['submit'])) {
    $category = '';
    if (empty($_POST['category'])) {
        $errors['category'] = 'Please type category';
    } else {
        $category = $_POST['category'];
    }
    $brand = '';
    if (empty($_POST['brand'])) {
        $errors['brand'] = 'Please type brand';
    } else {
        $brand = $_POST['brand'];
    }
    $names = '';
    if (empty(trim($_POST['names']))) {
        $errors['names'] = 'Please type name';
    } else {
        $names = $_POST['names'];
    }

    $newPrice = '';
    if (empty(trim($_POST['newPrice']))) {
        $errors['newPrice'] = 'Please type new price';
    } else {
        $newPrice = $_POST['newPrice'];
    }

    $oldPrice = '';
    if (empty(trim($_POST['oldPrice']))) {
        $errors['oldPrice'] = 'Please type old price';
    } else {
        $oldPrice = $_POST['oldPrice'];
    }

    $description = '';
    if (empty(trim($_POST['description']))) {
        $errors['description'] = 'Please type description';
    } else {
        $description = $_POST['description'];
    }

    $tags = '';
    if (empty(trim($_POST['tags']))) {
        $errors['tags'] = 'Please type tags';
    } else {
        $tags = $_POST['tags'];
    }

    $sortOrder = '';
    if (empty(trim($_POST['sortOrder']))) {
        $errors['sortOrder'] = 'Please type tags';
    } else {
        $sortOrder = $_POST['sortOrder'];
    }

    $isBestSell = $_POST['isBestSell'];
    $isNew = $_POST['isNew'];
    $active = $_POST['active'];

    $image = '';
    if (empty(($_FILES['image']['name']))) {
        $errors['image'] = 'Please type image';
    } else {
        $image = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $image = time() . '_' . $image;
    }

    if (empty($errors)) {
        $sql = "INSERT INTO products
            (`name`, `category_id`, `brand_id`, `price`,`old_price`, `image`, `description`, `tags`, `is_best_sell`, `is_new`,`sort_order`, `active`) VALUES
            ('$names', '$category', '$brand', '$newPrice','$oldPrice', '$image', '$description', '$tags', '$isBestSell', '$isNew', '$sortOrder', '$active')";
        mysqli_query($conn, $sql);
        move_uploaded_file($imageTmp, '../../uploads/' . $image);
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
                                <h3>Products</h3>
                            </div>
                            <div class="widget-content">
                                <table class="table table-striped table-bordered">
                                    <form id="edit-profile" class="form-horizontal" method="post" enctype="multipart/form-data">
                                        <fieldset>
                                            <div class="control-group">
                                                <label class="control-label">Name:</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" name="names">
                                                    <span style="color: red;"><?php echo (!empty($errors['names'])) ? $errors['names'] : ''; ?></span>
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
                                                    <input type="text" class="span4" name="newPrice">
                                                    <span style="color: red;"><?php echo (!empty($errors['newPrice'])) ? $errors['newPrice'] : ''; ?></span>
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->

                                            <div class="control-group">
                                                <label class="control-label">Price old:</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" name="oldPrice">
                                                    <span style="color: red;"><?php echo (!empty($errors['oldPrice'])) ? $errors['oldPrice'] : ''; ?></span>
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->


                                            <div class="control-group">
                                                <label class="control-label">Image:</label>
                                                <div class="controls">
                                                    <input type="file" class="span4" name="image">
                                                    <span style="color: red;"><?php echo (!empty($errors['image'])) ? $errors['image'] : ''; ?></span>
                                                </div> <!-- /controls -->
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Description:</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" name="description">
                                                    <span style="color: red;"><?php echo (!empty($errors['description'])) ? $errors['description'] : ''; ?></span>
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->

                                            <div class="control-group">
                                                <label class="control-label">Label:</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" name="tags">
                                                    <span style="color: red;"><?php echo (!empty($errors['tags'])) ? $errors['tags'] : ''; ?></span>
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->

                                            <div class="control-group">
                                                <label class="control-label">Best sell:</label>
                                                <div class="controls">
                                                    <select name="isBestSell" class="span4">
                                                        <option class="span4" value="0">Normal</option>
                                                        <option class="span4" value="1">Best sell</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Best new:</label>
                                                <div class="controls">
                                                    <select name="isNew" class="span4">
                                                        <option class="span4" value="0">Normal</option>
                                                        <option class="span4" value="1">Best new</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Status:</label>
                                                <div class="controls">
                                                    <select name="active" class="span4">
                                                        <option class="span4" value="1">Display</option>
                                                        <option class="span4" value="0">Not displayed</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="password1">Order:</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" name="sortOrder">
                                                    <span style="color: red;"><?php echo (!empty($errors['sortOrder'])) ? $errors['sortOrder'] : ''; ?></span>
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->
                                            <div class="form-actions">
                                                <input type="submit" name="submit" class="btn btn-primary" value="Add">
                                                <button class="btn btn-primary" ><a href="index.php" style="text-decoration: none; color:aliceblue;">Cancel</a></button>
                                            </div> <!-- /form-actions -->
                                        </fieldset>
                                    </form>
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
</html>