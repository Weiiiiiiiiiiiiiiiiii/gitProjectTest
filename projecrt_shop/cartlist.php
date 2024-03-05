<?php

include 'conn.php';

// $sql = "SELECT u.user_account, p.product_name, c.carts_num, p.product_img_1, p.product_content, p.product_price FROM carts c LEFT JOIN user u ON c.user_id = u.user_id LEFT JOIN product p ON c.product_id = p.product_id WHERE c.user_id=".$_SESSION['user_id'].";";

$sql = "SELECT u.user_account, c.product_id, p.product_name, c.carts_num, p.product_img_1, p.product_content, p.product_price FROM carts c LEFT JOIN user u ON c.user_id = u.user_id LEFT JOIN product p ON c.product_id = p.product_id WHERE c.user_id=1;";

if ($result = mysqli_query($conn, $sql)) {
    // echo "success"; 連線測試成功
    if (mysqli_num_rows($result) != 0) {

        while ($product = mysqli_fetch_assoc($result)) {

            // $user_id = $_SESSION['user_id'];

            $user_id = 1;
            $user_account = $product['user_account'];
            $product_id = $product['product_id'];
            $product_name = $product['product_name'];
            // 移除商品敘述(過長)
            // $product_content = $product['product_content']; 
            $product_img_1 = $product['product_img_1'];
            $product_price = $product['product_price'];
            $carts_num = $product['carts_num'];



            // 命名整個div id=商品id
            echo "<div id=\"cartname" . $product_id . "\" class=\"container\">\n";
            
            echo "<div class=\"row row-cols-7 align-items-center\">\n";
            // echo "<div class=\"row\">\n";

            // echo "<div class=\"col\">\n";

            echo "<div class=\"col-1 cart-list-title align-items-center\">\n";
            echo "<label for=\"carts{$product_id}\">確認購買\n";
            echo "<input type=\"checkbox\" id=\"carts{$product_id}\" name=\"carts[]\" value=\"{$product_id}\" />\n";
            // echo "<div class=\"row row-cols-6 align-items-center\">\n";
            
            echo "</label>\n";
            echo "</div>\n";

            
            // 刪除icon & 刪除功能
            echo "<div class=\"col-1 cart-list-title align-items-center\">\n";
            // echo "<button type=\"button\" class=\"btn btn-outline-secondary\"><img src=\"assets/img/icon_del.png\" alt=\"\" style=\"width:10px; height:10px;\"></button>\n";
            echo "<button type=\"button\" onclick=\"delCart(" . $user_id . ", " . $product_id . ", '" . $product_name . "')\" class=\"btn btn-dark\">刪除</button>\n";
            echo "</div>\n";

            // 圖片放置 & 圖片放大功能(待完成) & 隱藏input(可以傳值)
            echo "<div class=\"col-1 cart-list-title align-items-center\">\n";
            echo "<img src=\"" . $product_img_1 . "\" alt=\"\" style=\"width:50px; height:50px;\">\n";
            echo "<input type=\"hidden\" name=\"productPhotos[]\" value=\"" . $product_img_1 . "\">";
            echo "</div>\n";

            // 商品名稱 & 價格
            echo "<div class=\"col-4 cart-list-title align-items-center\">" . $product_name . "\n";
            echo "<input type=\"hidden\" name=\"productNames[]\" value=\"" . $product_name . "\">";
            echo "</div>\n";

            echo "<div class=\"col-2 cart-list-title align-items-center\">" . $product_price . "\n";
            echo "<input type=\"hidden\" name=\"productPrices[]\" value=\"" . $product_price . "\">";
            echo "</div>\n";

            // 商品數量
            echo "<div class=\"col-1 cart-list-title align-items-center\">\n";
            echo "<input type=\"text\" id=\"cartnum" . $product_id . "\" name=\"cartNums[]\" onkeyup=\"editCartNum(" . $user_id . ", " . $product_id . ", " . $product_price . ")\" class=\"quantity form-control input-number\" size=\"5\" value=\"" . $carts_num . "\" min=\"1\" max=\"100\">\n";
            echo "</div>\n";

            // 商品價格
            $product_price_total = $product_price * $carts_num;
            echo "<div id=\"cartnumtotal" . $product_id . "\" class=\"col-2 cart-list-title align-items-center\">" . $product_price_total . "\n";
            echo "<input type=\"hidden\" name=\"cartNumTotals[]\" value=\"" . $product_price_total . "\">";
            echo "</div>\n";

            // echo "</div>\n";
            
            echo "</div>\n";
            // echo "</div>\n";
            echo "<hr>\n";
            echo "</div>\n";


        }
    } else {
        echo "<div class=\"container\">";
        echo "<div class=\"row row-cols-6 align-items-center\">\n";
        echo "<div class=\"col-12 cart-list-title align-items-center\">\n";
        echo "購物車目前無任何商品";
        echo "</div>\n</div>\n";
        echo "<hr>\n</div>\n";
    }
}

echo "<button type=\"button\" onclick=\"\" class=\"btn btn-outline-secondary\">確認付款</button>\n";

// $product = mysqli_fetch_assoc($result);

// print_r($product); 測試印出值



mysqli_close($conn);
