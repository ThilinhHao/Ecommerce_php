<?php
include '../common/include.php';

$errors = [];
if (isset($_POST['submit'])) {
    $name = '';
    if (empty(trim($_POST['name']))) {
        $errors['name'] = 'Please type name';
    } else {
        $name = $_POST['name'];
    }

    $sortOrder = '';
    if (empty(trim($_POST['sortOrder']))) {
        $errors['sortOrder'] = 'Please type sortOrder';
    } else {
        $sortOrder = $_POST['sortOrder'];
    }

    $active = $_POST['active'];

    if (empty($errors)) {
        $sql = "INSERT INTO categories (cname, sort_order, active) VALUES ('$name', '$sortOrder', '$active')";
        mysqli_query($conn, $sql);
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
                                <h3>Categories</h3>
                            </div>
                            <div class="widget-content">
                                <table class="table table-striped table-bordered">
                                    <form id="edit-profile" class="form-horizontal" method="post" enctype="multipart/form-data">
                                        <fieldset>
                                            <div class="control-group">
                                                <label class="control-label" for="firstname">Name:</label>
                                                <div class="controls">
                                                    <input type="text" class="span4" name="name">
                                                    <span style="color: red;"><?php echo (!empty($errors['name'])) ? $errors['name'] : ''; ?></span>
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
                                                    <select name="active"  class="span4">
                                                        <option class="span4" value="1">Display</option>
                                                        <option class="span4" value="0">Not display</option>
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