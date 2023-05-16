<?php
    include '../common/include.php';

    $id =  $_GET['idbanners'];
    $sql = "SELECT * FROM banners WHERE id = '$id' LIMIT 1";
    $query = mysqli_query($conn, $sql);

    $errors = [];
    if (isset($_POST['edit'])) {
        $title = '';
        if (empty(trim($_POST['title']))) {
            $errors['title'] = 'Please type title';
        } else {
            $title = $_POST['title'];
        }

        $content = '';
        if (empty(trim($_POST['content']))) {
            $errors['content'] = 'Please type content';
        } else {
            $content = $_POST['content'];
        }
        $image = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $image = time() . '_' . $image;

        $sortOrder = '';
        if (empty(trim($_POST['sortOrder']))) {
            $errors['sortOrder'] = 'Please type sortOrder';
        } else {
            $sortOrder = $_POST['sortOrder'];
        }

        $active = $_POST['active'];

        if (empty($errors)) {
            if ($_FILES['image']['name'] != '') {
                move_uploaded_file($imageTmp, '../../uploads/'.$image);
                while($row = mysqli_fetch_array($query)){
                    unlink('../../uploads/' . $row['image_url']);
                }
                $sqlUpdate = "UPDATE banners SET title = '$title', content = '$content',image_url = '$image', sort_order = '$sortOrder', active = '$active' WHERE id = '$id'";
                mysqli_query($conn, $sqlUpdate);
                header('location: index.php');
            } else {
                $sqlUpdate = "UPDATE banners SET title = '$title', content = '$content', sort_order = '$sortOrder', active = '$active' WHERE id = '$id'";
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

    <div class="tab-pane" id="formcontrols">
        <?php while ($row = mysqli_fetch_array($query)) { ?>
        <form id="edit-profile" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="firstname">Name:</label>
                    <div class="controls">
                        <input type="text" class="span4" name="title" value="<?php echo $row['title']; ?>">
                        <span style="color: red;"><?php echo (!empty($errors['title'])) ? $errors['title'] : ''; ?></span>
                    </div> <!-- /controls -->
                </div> <!-- /control-group -->

                <div class="control-group">
                    <label class="control-label" for="lastname">Description:</label>
                    <div class="controls">
                        <input type="text" class="span4" name="content" value="<?php echo $row['content']; ?>">
                        <span style="color: red;"><?php echo (!empty($errors['content'])) ? $errors['content'] : ''; ?></span>
                    </div> <!-- /controls -->
                </div> <!-- /control-group -->

                <div class="control-group">
                    <label class="control-label">Image:</label>
                    <div class="controls">
                        <input type="file" class="span4" name="image">
                        <img src="../../uploads/<?php echo $row['image_url']; ?>" width="10%">
                    </div> <!-- /controls -->
                </div> <!-- /control-group -->

                <div class="control-group">
                    <label class="control-label" for="password1">Order:</label>
                    <div class="controls">
                        <input type="text" class="span4" name="sortOrder" value="<?php echo $row['sort_order']; ?>">
                        <span style="color: red;"><?php echo (!empty($errors['sortOrder'])) ? $errors['sortOrder'] : ''; ?></span>
                    </div> <!-- /controls -->
                </div> <!-- /control-group -->

                <div class="control-group">
                    <label class="control-label">Status:</label>
                    <div class="controls">
                        <select name="active">
                        <?php
                            if ($row['active'] == 1) {
                        ?>
                            <option class="span4" value="0">Not display</option>
                            <option class="span4" value="1" selected>Display</option>
                        <?php
                            } else {
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
    </div>

    <?php
    include '../../layouts/footer.php';
    include 'footer.php';
    ?>

</body>

</html>