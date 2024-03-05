<?php
include_once "../conn.php";

$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo ("<option value='" . $row["product_id"] . "'>" . $row["product_id"] . $row["product_name"] . "</option>");
        }
    }
    mysqli_free_result($result);
}

$conn->close();

?>