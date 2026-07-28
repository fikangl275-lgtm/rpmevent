<?php

include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM pic WHERE id_pic='$id'");

header("Location: data_pic.php");

?>