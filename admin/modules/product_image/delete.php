<?php
    include '../../../config/database.php';

    $id =  $_GET['idimg'];
    $sql = "UPDATE product_images SET active='2' WHERE id = '$id'";
    $query = mysqli_query($conn, $sql);
    header('location: index.php');

?>