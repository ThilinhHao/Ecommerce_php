
<?php
    include '../common/include.php';

    $id =  $_GET['idbrand'];
    $sql = "SELECT * FROM brands WHERE id = '$id' LIMIT 1";
    $query = mysqli_query($conn, $sql);

    $errors = [];
    if (isset($_POST['edit'])) {

        $name = '';
        if (empty(trim($_POST['name']))) {
            $errors['name'] = 'Please type name';
        } else {
            $name = $_POST['name'];
        }

        $link = '';
        if (empty(trim($_POST['link']))) {
            $errors['link'] = 'Please type link';
        } else {
            $link = $_POST['link'];
        }
        $active = $_POST['active'];
        $image = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $image = time() . '_' . $image;
        if (empty($errors)) {
            if ($_FILES['image']['name'] != '') {
                move_uploaded_file($imageTmp, '../../uploads/'.$image);
                while($row = mysqli_fetch_array($query)){
                    unlink('../../uploads/' . $row['image_url']);
                }
                $sqlUpdate = "UPDATE brands SET bname = '$name', link = '$link', image_url = '$image', active = '$active' WHERE id = '$id'";
                mysqli_query($conn, $sqlUpdate);
                header('location: index.php');
            } else {
                $sqlUpdate = "UPDATE brands SET bname = '$name', link = '$link', image_url = '$image', active = '$active' WHERE id = '$id'";
                mysqli_query($conn, $sqlUpdate);
                header('location: index.php');
            }
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
                                                        <input type="text" class="span4" name="name" value="<?php echo $row['bname']; ?>">
                                                        <span style="color: red;"><?php echo (!empty($errors['name'])) ? $errors['name'] : ''; ?></span>
                                                    </div> <!-- /controls -->
                                                </div> <!-- /control-group -->

                                                <div class="control-group">
                                                    <label class="control-label">Iamge:</label>
                                                    <div class="controls">
                                                        <input type="file" class="span4" name="image">
                                                        <img src="../../uploads/<?php echo $row['image_url']; ?>" width="10%">
                                                    </div> <!-- /controls -->
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Link</label>
                                                    <div class="controls">
                                                        <input type="text" class="span4" name="link" value="<?php echo $row['link']; ?>">
                                                        <span style="color: red;"><?php echo (!empty($errors['link'])) ? $errors['link'] : ''; ?></span>
                                                    </div> <!-- /controls -->
                                                </div> <!-- /control-group -->

                                                <div class="control-group">
                                                    <label class="control-label">Status:</label>
                                                    <div class="controls" >
                                                        <select name="active" class="span4">
                                                            <?php
                                                            if ($row['active'] == 1) {
                                                            ?>
                                                                <option class="span4" value="0">Not display</option>
                                                                <option class="span4" value="1" selected>Display</option>
                                                            <?php
                                                            }
                                                            if ($row['active'] == 0) {
                                                            ?>
                                                                <option class="span4" value="0" selected>Not display</option>
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