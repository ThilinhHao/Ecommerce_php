<?php
    include '../common/include.php';

    $id =  $_GET['idproducts'];
    $sql = "UPDATE products SET active= 2 WHERE pid = '$id'";
    $query = mysqli_query($conn, $sql);
    header('location: index.php');

?>