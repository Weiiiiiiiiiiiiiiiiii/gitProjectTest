<?php
$localhost_url = "back/"; //預留主機路徑

$img_error = ""; //出錯警告
$product_name = isset($_POST['product_name']) ? $_POST['product_name'] : "";
$product_content = isset($_POST['product_content']) ? $_POST['product_content'] : "";
$product_type1 = isset($_POST['product_type1']) ? $_POST['product_type1'] : "";
$product_type2 = isset($_POST['product_type2']) ? $_POST['product_type2'] : "";
$product_type3 = isset($_POST['product_type3']) ? $_POST['product_type3'] : "";
$product_price = isset($_POST['product_price']) ? $_POST['product_price'] : "";
// $product_color = isset($_POST['product_color']) ? $_POST['product_color'] : "";
// $product_size = isset($_POST['product_size']) ? $_POST['product_size'] : "";
// $product_num = isset($_POST['product_num']) ? $_POST['product_num'] : "";
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
                echo "<script language='javascript'>alert(\"文件類型錯誤!\");</script>";
                exit;
            } else {
                echo "文件類型成功<br />";
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


   // 開啟transaction
mysqli_begin_transaction($conn);

// 新增基礎資料到product
$sql1 = "INSERT INTO product (`product_name`, `product_content`, `product_type1`, `product_type2`, `product_type3`, `product_price`, `product_img_1`, `product_img_2`, `product_img_3`, `product_img_4`, `product_img_5`, `product_img_6`) VALUES ('$product_name', '$product_content', '$product_type1', '$product_type2', '$product_type3', '$product_price', '$product_img_[0]', '$product_img_[1]', '$product_img_[2]', '$product_img_[3]', '$product_img_[4]', '$product_img_[5]')";
mysqli_query($conn, $sql1);

// 取得剛剛自動生成的product_id(因為資料庫本身有設定自動生成，所以要用抓的沒辦法寫死)
$product_id = mysqli_insert_id($conn);

// 新增個尺寸資料等到product_detail
for ($i = 0; $i < count($_POST['product_color']); $i++) {
    $product_color = $_POST['product_color'][$i];
    $product_size = $_POST['product_size'][$i];
    $product_num = $_POST['product_num'][$i];

    $sql2 = "INSERT INTO product_detail (`product_id`, `color_id`, `size_id`, `product_num`) VALUES ('$product_id', '$product_color', '$product_size', '$product_num')";
    mysqli_query($conn, $sql2);
}

// 如果有任何一個插入新增失敗，則取消新增
if (mysqli_error($conn)) {
    mysqli_rollback($conn); // 倒退取消
    echo "上傳失敗。";
} else {
    mysqli_commit($conn); // 上傳成功
    echo "上傳成功。";
}

// 關閉資料庫連線
mysqli_close($conn);
}
?>
<script>
    function addOption() {
    var container = document.getElementById("options-container");

    // 生成顏色下拉選單
    var colorDiv = document.createElement("div");
    colorDiv.className = "input-group mb-3";
    colorDiv.innerHTML = `
        <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            產品顏色
        </button>
        <select class="form-select" name="product_color[]" aria-label="Default select example">
            <option selected disabled> select color</option>
            <option value="1">01 OFF WHITE</option>
            <option value="2">02 LIGHT GRAY</option>
            <option value="5">05 GRAY</option>
            <option value="9">09 BLACK</option>
            <option value="30">30 NATURAL</option>
            <option value="34">34 BROWN</option>
            <option value="56">56 OLIVE</option>
        </select>
    `;
    container.appendChild(colorDiv);

    // 生成尺寸下拉選單
    var sizeDiv = document.createElement("div");
    sizeDiv.className = "input-group mb-3";
    sizeDiv.innerHTML = `
        <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            產品尺寸
        </button>
        <select class="form-select" name="product_size[]" aria-label="Default select example">
            <option selected disabled>select size</option>
            <option value="1">XS</option>
            <option value="2">S</option>
            <option value="3">M</option>
            <option value="4">L</option>
            <option value="5">XL</option>
            <option value="6">XXL</option>
            <option value="7">3XL</option>
        </select>
    `;
    container.appendChild(sizeDiv);

    // 生成數量輸入框
    var numDiv = document.createElement("div");
    numDiv.className = "input-group mb-3";
    numDiv.innerHTML = `
        <span class="input-group-text">產品數量 :</span>
        <input type="text" class="form-control" name="product_num[]" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
    `;
    container.appendChild(numDiv);
}

</script>
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
</head>

<body>
    
    <section class="container py-5">
        <div class="row text-center pt-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">商品上架</h1>
                <form method="post" action="addMultiple.php" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="product_name">產品名稱 :</span>
                        <input type="text" class="form-control" name="product_name" aria-label="Sizing example input" aria-describedby="product_name">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="product_content">產品內容 :</span>
                        <input type="text" class="form-control" name="product_content" aria-label="Sizing example input" aria-describedby="product_content">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="product_type1">產品類型1 :</span>
                        <input type="text" class="form-control" name="product_type1" aria-label="Sizing example input" aria-describedby="product_type1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="product_type2">產品類型2 :</span>
                        <input type="text" class="form-control" name="product_type2" aria-label="Sizing example input" aria-describedby="product_type2">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="product_type3">產品類型3 :</span>
                        <input type="text" class="form-control" name="product_type3" aria-label="Sizing example input" aria-describedby="product_type3">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">產品價格 :</span>
                        <input type="text" class="form-control" name="product_price" aria-label="Amount (to the nearest dollar)">
                    </div>
                    <div class="d-grid gap-2 d-md-block">
                    <button class="btn btn-primary" type="button" onclick="addOption()">新增產品各尺寸，顏色，數量</button>
                    </div>
                    <div id="options-container"></div>
                    

                    
                    <div class="input-group mb-3">
                        <span class="input-group-text">產品圖檔 :</span>
                        <input class="form-control" name='product_img_1[]' type="file" id="formFileMultiple" multiple>
                    </div>
                    <input type="submit" value="確定">
                </form>
            </div>
        </div>
    </section>





    <!-- Start Script -->
    <script src="../assets/js/jquery-1.11.0.min.js"></script>
    <script src="../assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/templatemo.js"></script>
    <script src="../assets/js/custom.js"></script>
    <!-- End Script -->
</body>

</html>