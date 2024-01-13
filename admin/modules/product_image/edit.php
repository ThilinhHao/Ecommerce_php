<?php
include '../common/include.php';
include '../../../config/database.php';

$id =  $_GET['idimg'];
$sql = "SELECT * FROM product_images WHERE id = '$id' LIMIT 1";
$query = mysqli_query($conn, $sql);

if (isset($_POST['edit'])) {
    $names = $_POST['names'];
    $image = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $image = time() . '_' . $image;
    $active = $_POST['active'];


    if ($_FILES['image']['name'] != '') {
        move_uploaded_file($imageTmp, '../../uploads/' . $image);
        $sql = "UPDATE product_images SET  `product_id` = $names, `image_url` = $image, `active` = $active WHERE id = '$id'";
        $query = mysqli_query($conn, $sql);
        header('location: index.php');
    } else {
        $sql = "UPDATE product_images SET `product_id` = $names, `active` = $active WHERE id = '$id'";
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
                                <h3>Image products</h3>
                            </div>
                            <div class="widget-content">
                                <table class="table table-striped table-bordered">
                                    <?php
                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                        <form id="edit-profile" class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <fieldset>

                                                <div class="control-group">
                                                    <label class="control-label">Label:</label>
                                                    <div class="controls">
                                                        <select name="names">
                                                            <?php
                                                            $q = "SELECT * FROM products";
                                                            $rs = mysqli_query($conn, $q);
                                                            if (mysqli_num_rows($rs) > 0) {
                                                                $i = 0;
                                                                while ($r = mysqli_fetch_assoc($rs)) {
                                                                    $i++;
                                                                    $id = $r['pid'];
                                                                    $name = $r['name'];
                                                                    echo "<option value= '$id'>$name</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Image:</label>
                                                    <div class="controls">
                                                        <input type="file" class="span4" name="image">
                                                        <img src="../../uploads/<?php echo $row['image_url']; ?>" width="10%">
                                                    </div> <!-- /controls -->
                                                </div> <!-- /control-group -->

                                                <div class="control-group">
                                                    <label class="control-label">Status:</label>
                                                    <div class="controls">
                                                        <select name="active">
                                                            <?php
                                                            if ($row['active'] == 1) {
                                                            ?>
                                                                <option class="span4" value="0">Not displayed</option>
                                                                <option class="span4" value="1" selected>Display</option>
                                                            <?php
                                                            }
                                                            if ($row['active'] == 0) {
                                                            ?>
                                                                <option class="span4" value="0" selected>Not displayed</option>
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