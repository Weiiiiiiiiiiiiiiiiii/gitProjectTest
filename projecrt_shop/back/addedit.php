<?php
$localhost_url = "back/"; //預留主機路徑
//127.0.0.1/projecrt_shop/
$img_error = ""; //出錯警告
$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : "";
$product_name = isset($_POST['product_name']) ? $_POST['product_name'] : "";
$product_content = isset($_POST['product_content']) ? $_POST['product_content'] : "";
$product_type1 = isset($_POST['product_type1']) ? $_POST['product_type1'] : "";
$product_type2 = isset($_POST['product_type2']) ? $_POST['product_type2'] : "";
$product_type3 = isset($_POST['product_type3']) ? $_POST['product_type3'] : "";
$product_price = isset($_POST['product_price']) ? $_POST['product_price'] : "";
$product_color = isset($_POST['product_color']) ? $_POST['product_color'] : "";
$product_size = isset($_POST['product_size']) ? $_POST['product_size'] : "";
$product_num = isset($_POST['product_num']) ? $_POST['product_num'] : "";
$allowtype = array("image/gif", "image/pjpeg", "image/jpeg", "image/png");
$product_img_ = array("NULL", "NULL", "NULL", "NULL", "NULL", "NULL");
if (!file_exists("images")) {
    // 建立一個資料夾, 權限777, 可讀取, 寫入, 執行
    mkdir("images", 0777);
}
if ($product_name != "" && $product_content != "" && $product_type1 != "") {
    $i = 0;
    $product_img = "";
    $product_img_num = "";
    if (isset($product_name)) {
        foreach ($_FILES["product_img_1"]["error"] as $key => $error) {
            if (!in_array($_FILES["product_img_1"]["type"][$key], $allowtype)) {
                require "./conn.php";
                // 檢查連接是否成功
                if ($conn->connect_error) {
                    die("連接失敗: " . $conn->connect_error);
                }
                //啟動transaction
                mysqli_begin_transaction($conn);
                // 新增基礎資料到product
                $sql1 = "UPDATE `product` SET `product_content` = '$product_content', `product_type1` = '$product_type1', `product_type2` = '$product_type2', `product_type3` = '$product_type3',`product_price` = '$product_price' WHERE `product`.`product_id` = '" . $product_id . "'";
                mysqli_query($conn, $sql1);

                $sql2 = "INSERT INTO product_detail (`product_id`, `color_id`, `size_id`, `product_num` ) VALUES ('$product_id', '$product_color', '$product_size', '$product_num')";
                mysqli_query($conn, $sql2);
                // 如果有任何一個插入新增失敗，則取消新增
                if (mysqli_error($conn)) {
                    mysqli_rollback($conn); // 倒退取消
                    $img_error=  "上傳失敗。";
                } else {
                    mysqli_commit($conn); // 上傳成功
                    $img_error=  "新增尺寸成功。";
                }
                // 關閉資料庫連線
                mysqli_close($conn);
                exit;
            } else {
                $img_error=  "文件類型成功<br />";
            }
            $times = explode(" ", microtime());
            $photoName = strftime("%Y_%m_%d_%H_%M_%S_", $times[1]) . substr($times[0], 2, 5) . ".jpg";
            $_FILES['product_img_1']["name"][$key] = $photoName;
            //$_FILES['product_img_1']["name"][$key]會有原本的檔案名稱+副檔名 ex:123.ipg
            $url[$i] = "images/" . $_FILES['product_img_1']["name"][$key];
            move_uploaded_file($_FILES['product_img_1']["tmp_name"][$key], $url[$i]);
            $product_img_[$i] = $localhost_url . "images/" . $_FILES['product_img_1']["name"][$key];
            $i++;
        }
    }
    require "./conn.php";
    // 檢查連接是否成功
    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }
    //啟動transaction
    mysqli_begin_transaction($conn);
    // 新增基礎資料到product
    $sql1 = "UPDATE `product` SET `product_content` = '$product_content', `product_type1` = '$product_type1', `product_type2` = '$product_type2', `product_type3` = '$product_type3',`product_price` = '$product_price',`product_img_1` = '$product_img_[0]',`product_img_2` = '$product_img_[1]',`product_img_3` = '$product_img_[2]',`product_img_4` = '$product_img_[3]',`product_img_5` = '$product_img_[4]',`product_img_6` = '$product_img_[5]' WHERE `product`.`product_id` = '" . $product_id . "'";
    mysqli_query($conn, $sql1);

    $sql2 = "INSERT INTO product_detail (`product_id`, `color_id`, `size_id`, `product_num` ) VALUES ('$product_id', '$product_color', '$product_size', '$product_num')";
    mysqli_query($conn, $sql2);
    // 如果有任何一個插入新增失敗，則取消新增
    if (mysqli_error($conn)) {
        mysqli_rollback($conn); // 倒退取消
        $img_error=  "上傳失敗。";
    } else {
        mysqli_commit($conn); // 上傳成功
        $img_error= "更新成功。";
    }
    // 關閉資料庫連線
    mysqli_close($conn);
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="../assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/templatemo.css">
    <link rel="stylesheet" href="../assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="../assets/css/fontRobotocss2.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <title>商品上架</title>
    <!-- Start Script -->
    <script src="../assets/js/jquery-1.11.0.min.js"></script>
    <script src="../assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/templatemo.js"></script>
    <script src="../assets/js/custom.js"></script>
    <!-- End Script -->
    <script>
        $(document).ready(
            function() {
                $.ajax({
                    url: "./addsingle/getproduct.php",
                    type: "post",
                    success: function(data) {
                        //append:加入選項
                        $("#product_name").append(data);
                        console.log("success");
                    }
                });
            }
        )

        function dosome() {
            var select = $("#product_name").val();
            console.log(select);
            $.ajax({
                url: "./addsingle/getproduct_id.php",
                type: "post",
                data: {
                    id: select
                },
                success: function(data) {
                    //append:加入選項
                    //$("#product_name").append(data);
                    $product_content = (data);
                    console.log("id:" + data);
                    console.log("success");
                    $("#product_id").val(data);
                }
            });
            $.ajax({
                url: "./addsingle/getproduct_content.php",
                type: "post",
                data: {
                    id: select
                },
                success: function(data) {
                    //append:加入選項
                    //$("#product_name").append(data);
                    $product_content = (data);
                    console.log(data);
                    console.log("success");
                    $("#product_content").val(data);
                }
            });
            $.ajax({
                url: "./addsingle/getproduct_type1.php",
                type: "post",
                data: {
                    id: select
                },
                success: function(data) {
                    //append:加入選項
                    //$("#product_name").append(data);
                    $product_content = (data);
                    console.log(data);
                    console.log("success");
                    $("#product_type1").val(data);
                }
            });
            $.ajax({
                url: "./addsingle/getproduct_type2.php",
                type: "post",
                data: {
                    id: select
                },
                success: function(data) {
                    //append:加入選項
                    //$("#product_name").append(data);
                    $product_content = (data);
                    console.log(data);
                    console.log("success");
                    $("#product_type2").val(data);
                }
            });
            $.ajax({
                url: "./addsingle/getproduct_type3.php",
                type: "post",
                data: {
                    id: select
                },
                success: function(data) {
                    //append:加入選項
                    //$("#product_name").append(data);
                    $product_content = (data);
                    console.log(data);
                    console.log("success");
                    $("#product_type3").val(data);
                }
            });
            $.ajax({
                url: "./addsingle/getproduct_price.php",
                type: "post",
                data: {
                    id: select
                },
                success: function(data) {
                    //append:加入選項
                    //$("#product_name").append(data);
                    $product_content = (data);
                    console.log(data);
                    console.log("success");
                    $("#product_price").val(data);
                }
            });
        }
    </script>
</head>

<body>
    <!-- Start Top Nav -->
    <?php
    // include_once "../top-nav.php"
    ?>
    <!-- Close Top Nav -->


    <!-- Header -->
    <?php
    // include_once "../header.php"
    ?>
    <!-- Close Header -->
    <section class="container py-5">
        <div class="row text-center pt-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">商品上架</h1>
                <form method="post" action="addedit.php" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <input type="hidden" class="form-control" name="product_id" id="product_id" aria-label="Sizing example input" aria-describedby="product_id">
                    </div>
                    <div class="input-group mb-3">
                        <button class="btn btn-secondary " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            產品名稱
                        </button>
                        <select class="form-select" name="product_name" id="product_name" onchange="dosome(this.selectedIndex)" aria-label="Default select example">
                            <option selected disabled> select product</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">產品內容 :</span>
                        <input type="text" class="form-control" name="product_content" id="product_content" aria-label="Sizing example input" aria-describedby="product_content" value=<?= $product_content ?>>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">產品類型1 :</span>
                        <input type="text" class="form-control" name="product_type1" id="product_type1" aria-label="Sizing example input" aria-describedby="product_type1" value=<?= $product_type1 ?>>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">產品類型2 :</span>
                        <input type="text" class="form-control" name="product_type2" id="product_type2" aria-label="Sizing example input" aria-describedby="product_type2" value=<?= $product_type2 ?>>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">產品類型3 :</span>
                        <input type="text" class="form-control" name="product_type3" id="product_type3" aria-label="Sizing example input" aria-describedby="product_type3" value=<?= $product_type3 ?>>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">產品價格 :</span>
                        <input type="text" class="form-control" name="product_price" id="product_price" aria-label="Amount (to the nearest dollar)" value=<?= $product_price ?>>
                    </div>
                    <div class="input-group mb-3">
                        <button class="btn btn-secondary " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            產品顏色
                        </button>
                        <select class="form-select" name="product_color" aria-label="Default select example">
                            <option selected disabled> select color</option>
                            <option value="1">01 OFF WHITE</option>
                            <option value="2">02 LIGHT GRAY</option>
                            <option value="5">05 GRAY</option>
                            <option value="9">09 BLACK</option>
                            <option value="30">30 NATURAL</option>
                            <option value="34">34 BROWN</option>
                            <option value="56">56 OLIVE</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <button class="btn btn-secondary " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            產品尺寸
                        </button>
                        <select class="form-select" name="product_size" aria-label="Default select example">
                            <option selected disabled>select size</option>
                            <option value="1">XS</option>
                            <option value="2">S</option>
                            <option value="3">M</option>
                            <option value="4">L</option>
                            <option value="5">XL</option>
                            <option value="6">XXL</option>
                            <option value="7">3XL</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="product_num">產品數量 :</span>
                        <input type="text" class="form-control" name="product_num" aria-label="Sizing example input" aria-describedby="product_num">

                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="product_img_1[]">產品圖檔 :</span>
                        <input class="form-control" name='product_img_1[]' type="file" id="formFileMultiple" multiple>
                    </div>
                    <input type="submit" value="確定">
                </form>
            </div>
        </div>
    </section>



    <!-- Start Footer -->
    <?php
    // include_once "../footer.php"
    ?>
    <!-- End Footer -->


</body>

</html>