<?php
    include '../../../config/database.php';
    include '../common/include.php';

    $id =  $_GET['idbrand'];
    $sql = "UPDATE brands SET active='2' WHERE id = '$id'";
    $query = mysqli_query($conn, $sql);
    header('location: index.php');

?>