<?php
    include '../common/include.php';

    $errors = [];
    if (isset($_POST['submit'])) {
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
        $sortOrder = '';
        if (empty(trim($_POST['sortOrder']))) {
            $errors['sortOrder'] = 'Please type sortOrder';
        } else {
            $sortOrder = $_POST['sortOder'];
        }

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
            $sql = "INSERT INTO banners (title, content, image_url, sort_order, active) VALUES ('$title', '$content', '$image', '$sortOrder', '$active')";
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
                                <h3>Banners</h3>
                            </div>
                            <div class="widget-content">
                                <table class="table table-striped table-bordered">
                                    <form id="edit-profile" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                        <fieldset>
                                            <div class="control-group">
                                                <label class="control-label" for="firstname">Name:</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" name="title">
                                                    <span style="color: red;"><?php echo (!empty($errors['title'])) ? $errors['title'] : ''; ?></span>
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->

                                            <div class="control-group">
                                                <label class="control-label" for="lastname">Description:</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" name="content">
                                                    <span style="color: red;"><?php echo (!empty($errors['content'])) ? $errors['content'] : ''; ?></span>
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->

                                            <div class="control-group">
                                                <label class="control-label">Image:</label>
                                                <div class="controls">
                                                    <input type="file" class="span4" name="image">
                                                    <span style="color: red;"><?php echo (!empty($errors['image'])) ? $errors['image'] : ''; ?></span>
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->

                                            <div class="control-group">
                                                <label class="control-label" for="password1">Order:</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" name="sortOrder">
                                                    <span style="color: red;"><?php echo (!empty($errors['sortOrder'])) ? $errors['sortOrder'] : ''; ?></span>
                                                </div> <!-- /controls -->
                                            </div> <!-- /control-group -->

                                            <div class="control-group">
                                                <label class="control-label">Status:</label>
                                                <div class="controls">
                                                    <select name="active" class="span4">
                                                        <option class="span4" value="0">Not display</option>
                                                        <option class="span4" value="1">Display</option>
                                                    </select>
                                                </div>
                                            </div>
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