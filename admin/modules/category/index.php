<?php include 'comm.php'; ?>

<body>
    <?php
        include '../common/include.php';
        include '../common/header.php';
        include 'inc.php';

        if (isset($_GET['idcategory'])) {
            $idDelte = $_GET['idcategory'];

            echo '<script type="text/javascript">
                if (confirm("Do you want to delete this order??")) {
                    window.location.href = "delete.php?idcategory='.$idDelte.'";
                } else {
                    window.location.href = "index.php";
                }
                </script>';
        }
    ?>

    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <form method="post" id="f_search">
                            <input id="txtSearch" type="search" name="search" placeholder="Enter category name...">
                            <input id="btnSearch" type="submit" name="submit" value="Search">
                        </form>

                        <a href="create.php"><input id="btnThem"  type="button" value="Add New"> </a>

                        <div class="widget widget-table action-table">
                            <div class="widget-header" id="dsban"> <i class="icon-th-list"></i>
                                <h3>Categories</h3>
                            </div>
                            <!-- /widget-header -->
                            <div class="widget-content">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%;">No</th>
                                            <th style="width: 20%;">Name</th>
                                            <th style="width: 10%;">Status</th>
                                            <th style="width: 50%;"></th>
                                            <th class="td-actions" style="width: 10%;"> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $pages = mysqli_query($conn, "SELECT * FROM categories WHERE active != 2");
                                        $count = mysqli_num_rows($pages);
                                        $item = 15;
                                        $size = ceil($count / $item);

                                        $page = '';
                                        if (isset($_GET['page'])) {
                                            if ($_GET['page'] <= $size && $_GET['page'] > 0) {
                                                $page = $_GET['page'];
                                            } else {
                                            ?>
                                            <script>
                                                window.location.href='../../errors.php';
                                            </script>
                                            <?php
                                            }
                                        }

                                        $begin = 0;
                                        if ($page == '' || $page == 1) {
                                            $begin = 0;
                                        } else {
                                            $begin = ($page * 15) - 15;
                                        }

                                        if (isset($_POST['submit'])) {
                                            $result = $_POST['search'];
                                            if (empty($result)) {
                                                $sql = "SELECT * FROM categories WHERE active != 2 ORDER BY sort_order";
                                            } else {
                                                $sql = "SELECT * FROM categories c WHERE c.cname LIKE '%" . $result . "%'";
                                            }
                                        } else {
                                            $sql = "SELECT * FROM categories WHERE active != 2 ORDER BY sort_order LIMIT $begin, $item";
                                        }

                                        $query = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_array($query)) {
                                            if ($row['active'] != 2) {
                                                ?>
                                            <tr>
                                                <td> <?php echo $row['id']; ?></td>
                                                <td> <?php echo $row['cname']; ?> </td>
                                                <td>
                                                    <?php
                                                    if ($row['active'] == 0) {
                                                        echo 'No display';
                                                    }
                                                    if ($row['active'] == 1) {
                                                        echo 'Display';
                                                    }
                                                    ?>
                                                </td>
                                                <td></td>
                                                <td class="td-actions">
                                                    <a href="edit.php?idcategory=<?php echo $row['id']; ?>" class="btn btn-small btn-success">
                                                        <i class="icon-large icon-pencil"> </i>
                                                    </a>
                                                    <a href="index.php?idcategory=<?php echo $row['id']; ?>" class="btn btn-danger btn-small">
                                                        <i class="btn-icon-only icon-remove"> </i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php
                                        if ($size >= 2) {
                                            for ($i = 1; $i <= $size; $i++) {
                                    ?>
                                        <li class="page-item"><a <?php echo ($i == $page) ? 'style="background: black;"' : ''; ?>class="page-link" href="index.php?page=<?php echo $i; ?>"> <?php echo $i; ?> </a></li>
                                    <?php
                                            }
                                        }
                                    ?>
                                </ul>
                            </nav>
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