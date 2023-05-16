<?php
    include '../common/include.php';

    if (isset($_GET['idbanners'])) {
        $id =  $_GET['idbanners'];
        $sql = "UPDATE banners SET  `active` = 2 WHERE id = '$id'";
        $query = mysqli_query($conn, $sql);

        header('location: index.php');
    }
?>
