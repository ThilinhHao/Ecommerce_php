<?php
    include '../../../config/database.php';

    $id =  $_GET['idcategory'];
    $sql = "UPDATE categories SET active='2' WHERE id = '$id'";
    $query = mysqli_query($conn, $sql);
    header('location: index.php');

?>