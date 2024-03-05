<?php
include './back/conn.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "UPDATE `order` SET `order_type`=7 WHERE order_id = $id;";

    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_affected_rows($conn) > 0) {
        echo "ok";
    }
}
