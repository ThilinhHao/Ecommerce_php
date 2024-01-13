<?php
    include '../common/include.php';

    $id =  $_GET['idcategory'];
    $sql = "SELECT * FROM categories WHERE id = '$id' LIMIT 1";
    $query = mysqli_query($conn, $sql);

    $errors = [];
    if (isset($_POST['edit'])) {
        $name = '';
        if (empty(trim($_POST['name']))) {
            $errors['name'] = 'Please type name';
        } else {
            $name = $_POST['name'];
        }

        $sort = '';
        if (empty(trim($_POST['sort']))) {
            $errors['sort'] = 'Please type sort';
        } else {
            $sort = $_POST['sort'];
        }

        $active = $_POST['active'];

        if (empty($errors)) {
            $sql = "UPDATE categories SET  `cname` = '$name', `sort_order` = '$sort', `active` = '$active' WHERE id = '$id'";
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
                                <h3>Categories</h3>
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
                                                        <input type="text" class="span4" name="name" value="<?php echo $row['cname']; ?>">
                                                        <span style="color: red;"><?php echo (!empty($errors['name'])) ? $errors['name'] : ''; ?></span>
                                                    </div> <!-- /controls -->
                                                </div> <!-- /control-group -->

                                                <div class="control-group">
                                                    <label class="control-label">Order:</label>
                                                    <div class="controls">
                                                        <input type="text" class="span4" name="sort" value="<?php echo $row['sort_order']; ?>">
                                                        <span style="color: red;"><?php echo (!empty($errors['sort'])) ? $errors['sort'] : ''; ?></span>
                                                    </div> <!-- /controls -->
                                                </div> <!-- /control-group -->

                                                <div class="control-group">
                                                    <label class="control-label">Status:</label>
                                                    <div class="controls">
                                                        <select name="active" class="span4">
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