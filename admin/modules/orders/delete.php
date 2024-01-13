<?php
    include '../common/include.php';

    if (isset($_GET['idorder'])) {
        $id = $_GET['idorder'];
        $sqlDelete = mysqli_query($conn, "DELETE FROM orders WHERE id = '$id' ");

        header('location: index.php');
    }

?>