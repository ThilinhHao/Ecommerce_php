<?php
    include '../../../config/database.php';

    $id =  $_GET['idusers'];
    if (isset($_GET['idusers'])) {
        $sql = "UPDATE users SET  `active` = 2 WHERE id = '$id'";
        $query = mysqli_query($conn, $sql);
        header('location: index.php');
    }
?>