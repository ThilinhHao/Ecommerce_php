<?php include 'comm.php'; ?>

<body>
    <?php
        include '../common/include.php';
        include '../common/header.php';
        include 'inc.php';

        if (isset($_GET['idimg'])) {
            $idDelte = $_GET['idimg'];

        echo '<script type="text/javascript">
            if (confirm("Do you want to delete this order??")) {
                window.location.href = "delete.php?idimg='.$idDelte.'";
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
                    <a href="create.php"><input id="btnThem" type="button" value="Add New"> </a>
                        <div class="widget widget-table action-table">
                            <div class="widget-header" id="dsban"> <i class="icon-th-list"></i>
                                <h3>Products</h3>
                            </div>
                            <!-- /widget-header -->
                            <div class="widget-content">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th style="width: 10%;">Image</th>
                                            <th style="width: 20%;">Name</th>
                                            <th style="width: 10%;">Status</th>
                                            <th style="width: 45%;"></th>
                                            <th class="td-actions" style="width: 10%;"> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $pages = mysqli_query($conn, "SELECT * FROM product_images WHERE active != 2");
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

                                        $sql = "SELECT p.*, pi.* FROM product_images pi inner join products p on p.pid=pi.product_id WHERE pi.active != 2 ORDER BY pi.sort_order ASC LIMIT $begin, $item";
                                        $query = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_array($query)) {
                                            if ($row['active'] != 2) {
                                        ?>
                                                <tr>
                                                    <td> <?php echo $row['id']; ?></td>
                                                    <td><img src="../../uploads/<?php echo $row['image_url']; ?>" width="70%"></td>
                                                    <td> <?php echo $row['name']; ?> </td>
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
                                                        <a href="edit.php?idimg=<?php echo $row['id']; ?>" class="btn btn-small btn-success">
                                                            <i class="icon-large icon-pencil"> </i>
                                                        </a>
                                                        <a href="index.php?idimg=<?php echo $row['id']; ?>" class="btn btn-danger btn-small">
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