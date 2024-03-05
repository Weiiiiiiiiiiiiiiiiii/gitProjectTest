<?php
    $server = "localhost";
    $user = "root";
    $pwd = "";
    $db = "project";

    $conn = new mysqli($server, $user, $pwd, $db);
    mysqli_query($conn, "SET NAMES utf8");
?>