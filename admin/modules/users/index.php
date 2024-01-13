<?php include 'comm.php'; ?>

<body>
    <?php
        include '../common/include.php';
        include '../common/header.php';
        include 'inc.php';

        $page = '';
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        $begin = 0;
        if ($page == '' || $page == 1) {
            $begin = 0;
        } else {
            $begin = ($page * 3) - 3;
        }

        $pages = mysqli_query($conn, "SELECT * FROM users WHERE active != 3 AND active != 2");
        $count = mysqli_num_rows($pages);
        $item = 3;
        $size = ceil($count / $item);

        $sql = "SELECT * FROM users WHERE active != 3 ORDER BY id  ASC LIMIT $begin, $item " ;
        $query = mysqli_query($conn, $sql);

        if (isset($_GET['idusers'])) {
            $idDelte = $_GET['idusers'];

        echo '<script type="text/javascript">
            if (confirm("Do you want to delete this order??")) {
                window.location.href = "delete.php?idusers='.$idDelte.'";
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
                    <div class="widget widget-table action-table">
                        <div class="widget-header"> <i class="icon-th-list"></i>
                            <h3>List users</h3>
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th style="width: 15%;">Username</th>
                                        <th style="width: 10%;">Email </th>
                                        <th style="width: 10%;">Status</th>
                                        <th style="width: 50%;"></th>
                                        <th class="td-actions" style="width: 10%;"> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $count = 0;
                                        while ($row = mysqli_fetch_array($query)) {
                                            if ($row['active'] != 2) {
                                                $count ++;
                                    ?>
                                    <tr>
                                        <td><?php echo $count; ?></td>
                                        <td> <?php echo $row['username']; ?></td>
                                        <td> <?php echo $row['email']; ?> </td>
                                        <td>
                                        <?php
                                            if ($row['active'] == 1) {
                                                echo 'Display';
                                            } elseif( $row['active'] == 0) {
                                                echo 'No display';
                                            }
                                        ?>
                                        </td>
                                        <td></td>
                                        <td class="td-actions">
                                            <a href="../../../change.php" class="btn btn-small btn-success">
                                                <i class="icon-large icon-pencil"> </i>
                                            </a>
                                            <a href="index.php?idusers=<?php echo $row['id']; ?>" class="btn btn-danger btn-small">
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
    <?php
    include '../../layouts/footer.php';
    include 'footer.php';
    ?>

</body>

</html>