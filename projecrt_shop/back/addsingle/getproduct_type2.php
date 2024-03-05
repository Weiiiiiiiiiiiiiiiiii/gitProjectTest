<?php
include_once "../conn.php";
$id =isset($_POST['id'])?$_POST['id']:"";
//$id=1;
$sql = "SELECT * 
        FROM product 
        WHERE product_id = '".$id."'";
$result = mysqli_query($conn, $sql);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo ($row["product_type1"]);
        }
    }
    mysqli_free_result($result);
}

$conn->close();

?>