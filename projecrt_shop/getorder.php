<?php
include './back/conn.php';

/* getorder start */
session_start();
$user_id = $_SESSION['user_id'];
if (isset($_POST['case'])) {
    $case = $_POST['case'];

    switch ($case) {
        case '1':

            $sql = "SELECT u.user_id, o.order_id, pdt.product_img_1, pdt.product_name, od.order_num, od.order_num*pdt.product_price, pdt.product_price, ot.ordertype_id FROM `order` AS o JOIN `user` AS u ON o.user_id = u.user_id JOIN `orderdetail` AS od ON o.order_id = od.order_id JOIN `product` AS pdt ON od.product_id = pdt.product_id JOIN `ordertype` AS ot ON o.order_type = ot.ordertype_id WHERE u.user_id=$user_id ORDER BY `o`.`order_id` DESC;";
            if ($result = mysqli_query($conn, $sql)) {
                $orderproducts = array();
                $productimg = array();
                $productnum = array();
                $productoneprice = array();
                $productprice = array();
                $ordertype = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $order_id = $row['order_id'];
                    $product_name = $row['product_name'];
                    $product_img = $row['product_img_1'];
                    $product_num = $row['order_num'];
                    $product_oneprice = $row['product_price'];
                    $product_price = $row['od.order_num*pdt.product_price'];
                    $order_type = $row['ordertype_id'];

                    $ordertype[$order_id][] = $order_type;
                    $orderproducts[$order_id][] = $product_name;
                    $productimg[$order_id][] = $product_img;
                    $productnum[$order_id][] = $product_num;
                    $productoneprice[$order_id][] = $product_oneprice;
                    $productprice[$order_id][] = $product_price;
                }

                foreach ($orderproducts as $order_id => $product_names) {
                    $value = 0;
                    echo "<div class='order-container' onclick='orderdetail(" . $order_id . "," . $case . "," . $ordertype[$order_id][0] . ")'>\n";
                    foreach ($product_names as $index => $product_name) {
                        $product_img = $productimg[$order_id][$index];
                        $product_num = $productnum[$order_id][$index];
                        $product_oneprice = $productoneprice[$order_id][$index];
                        $product_price = $productprice[$order_id][$index];

                        $value = $product_price + $value;
                        echo "<div class='product-container '>\n";
                        echo '<div class="img-container col-1"><img src="./' . $product_img . '"></div>';
                        echo "<div class='col-9 ms-1 pdtdes'>" . $product_name . "<br>x" . $product_num . "</div>\n";
                        echo "<div class='col-2 pdtprice'>單價:$" . $product_oneprice . "</div>\n";

                        echo "</div>\n";
                    }
                    echo "<div class='row price-container'>\n";
                    echo "<div class='col-3 text-center'>訂單編號:\n";
                    echo "<span id='orderid" . $order_id . "'>" . $order_id . "</span>\n";
                    echo "</div>\n";
                    echo "<div class='col-6 text-center'></div>\n";
                    echo "<div class='col-3 text-center'>訂單金額: $" . $value . "</div>\n";
                    echo "</div>\n";
                    echo "</div>\n";
                }
            }
            break;

        case '2':
            $sql = "SELECT u.user_id, o.order_id, pdt.product_img_1, pdt.product_name, od.order_num, od.order_num*pdt.product_price, pdt.product_price, ops.paystatus_type, ot.ordertype_id
            FROM `order` AS o JOIN `user` AS u ON o.user_id = u.user_id 
                            JOIN `orderdetail` AS od ON o.order_id = od.order_id 
                            JOIN `product` AS pdt ON od.product_id = pdt.product_id 
                            JOIN `ordertype` AS ot ON o.order_type = ot.ordertype_id 
                            JOIN `orderpaystatus` AS ops ON ot.paystatus_id = ops.paystatus_id 
                            WHERE u.user_id=$user_id AND ot.paystatus_id=1 ORDER BY `o`.`order_id` DESC;";
            if ($result = mysqli_query($conn, $sql)) {
                $orderproducts = array();
                $productimg = array();
                $productnum = array();
                $productoneprice = array();
                $productprice = array();
                $ordertype = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $order_id = $row['order_id'];
                    $product_name = $row['product_name'];
                    $product_img = $row['product_img_1'];
                    $product_num = $row['order_num'];
                    $product_oneprice = $row['product_price'];
                    $product_price = $row['od.order_num*pdt.product_price'];
                    $order_type = $row['ordertype_id'];



                    $ordertype[$order_id][] = $order_type;
                    $orderproducts[$order_id][] = $product_name;
                    $productimg[$order_id][] = $product_img;
                    $productnum[$order_id][] = $product_num;
                    $productoneprice[$order_id][] = $product_oneprice;
                    $productprice[$order_id][] = $product_price;
                }

                foreach ($orderproducts as $order_id => $product_names) {
                    $value = 0;
                    echo "<div class='order-container' onclick='orderdetail(" . $order_id . "," . $case . "," . $ordertype[$order_id][0] . ")'>\n";
                    foreach ($product_names as $index => $product_name) {
                        $product_img = $productimg[$order_id][$index];
                        $product_num = $productnum[$order_id][$index];
                        $product_oneprice = $productoneprice[$order_id][$index];
                        $product_price = $productprice[$order_id][$index];

                        $value = $product_price + $value;
                        echo "<div class='product-container '>\n";
                        echo '<div class="img-container col-1"><img src="./' . $product_img . '"></div>';
                        echo "<div class='col-9 ms-1 pdtdes'>" . $product_name . "<br>x" . $product_num . "</div>\n";
                        echo "<div class='col-2 pdtprice'>單價:$" . $product_oneprice . "</div>\n";

                        echo "</div>\n";
                    }
                    echo "<div class='row price-container'>\n";
                    echo "<div class='col-3 text-center'>訂單編號:\n";
                    echo "<span id='orderid" . $order_id . "'>" . $order_id . "</span>\n";
                    echo "</div>\n";
                    echo "<div class='col-6 text-center'></div>\n";
                    echo "<div class='col-3 text-center'>訂單金額: $" . $value . "</div>\n";
                    echo "</div>\n";
                    echo "</div>\n";
                }
            }
            break;
        case '3':
            $sql = "SELECT u.user_id, o.order_id, pdt.product_img_1, pdt.product_name, od.order_num, od.order_num*pdt.product_price, pdt.product_price
            FROM `order` AS o JOIN `user` AS u ON o.user_id = u.user_id
                            JOIN `orderdetail` AS od ON o.order_id = od.order_id
                            JOIN `product` AS pdt ON od.product_id = pdt.product_id
                            JOIN `ordertype` AS ot ON o.order_type = ot.ordertype_id
                            WHERE u.user_id=$user_id AND (ot.ordertype_id = 1 OR ot.ordertype_id = 2)  
                            ORDER BY `o`.`order_id` DESC";
            if ($result = mysqli_query($conn, $sql)) {
                $orderproducts = array();
                $productimg = array();
                $productnum = array();
                $productoneprice = array();
                $productprice = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $order_id = $row['order_id'];
                    $product_name = $row['product_name'];
                    $product_img = $row['product_img_1'];
                    $product_num = $row['order_num'];
                    $product_oneprice = $row['product_price'];
                    $product_price = $row['od.order_num*pdt.product_price'];

                    $orderproducts[$order_id][] = $product_name;
                    $productimg[$order_id][] = $product_img;
                    $productnum[$order_id][] = $product_num;
                    $productoneprice[$order_id][] = $product_oneprice;
                    $productprice[$order_id][] = $product_price;
                }

                foreach ($orderproducts as $order_id => $product_names) {
                    $value = 0;
                    echo "<div class='order-container orderid" . $order_id . "'onclick='orderdetail(" . $order_id . "," . $case . ",null)'>\n";
                    foreach ($product_names as $index => $product_name) {
                        $product_img = $productimg[$order_id][$index];
                        $product_num = $productnum[$order_id][$index];
                        $product_oneprice = $productoneprice[$order_id][$index];
                        $product_price = $productprice[$order_id][$index];

                        $value = $product_price + $value;
                        echo "<div class='product-container '>\n";
                        echo '<div class="img-container col-1"><img src="./' . $product_img . '"></div>';
                        echo "<div class='col-9 ms-1 pdtdes'>" . $product_name . "<br>x" . $product_num . "</div>\n";
                        echo "<div class='col-2 pdtprice'>單價:$" . $product_oneprice . "</div>\n";

                        echo "</div>\n";
                    }
                    echo "<div class='row py-2 price-container'>\n";
                    echo "<div class='col-3 text-center'>訂單編號:\n";
                    echo "<span id='orderid" . $order_id . "'>" . $order_id . "</span>\n";
                    echo "</div>\n";
                    echo "<div class='col-6'>\n";
                    echo "</div>\n";
                    echo "<div class='col-3 text-center'>訂單金額: $" . $value . "</div>\n";
                    echo "</div>\n";
                    echo "</div>\n";
                }
            }
            break;
        case '4':
            $sql = "SELECT u.user_id, o.order_id, pdt.product_img_1, pdt.product_name, od.order_num, od.order_num*pdt.product_price, pdt.product_price
            FROM `order` AS o JOIN `user` AS u ON o.user_id = u.user_id
                            JOIN `orderdetail` AS od ON o.order_id = od.order_id
                            JOIN `product` AS pdt ON od.product_id = pdt.product_id
                            JOIN `ordertype` AS ot ON o.order_type = ot.ordertype_id
                            WHERE u.user_id=$user_id AND (ot.ordertype_id = 3 OR ot.ordertype_id = 4)  
                            ORDER BY `o`.`order_id` DESC";
            if ($result = mysqli_query($conn, $sql)) {
                $orderproducts = array();
                $productimg = array();
                $productnum = array();
                $productoneprice = array();
                $productprice = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $order_id = $row['order_id'];
                    $product_name = $row['product_name'];
                    $product_img = $row['product_img_1'];
                    $product_num = $row['order_num'];
                    $product_oneprice = $row['product_price'];
                    $product_price = $row['od.order_num*pdt.product_price'];

                    $orderproducts[$order_id][] = $product_name;
                    $productimg[$order_id][] = $product_img;
                    $productnum[$order_id][] = $product_num;
                    $productoneprice[$order_id][] = $product_oneprice;
                    $productprice[$order_id][] = $product_price;
                }

                foreach ($orderproducts as $order_id => $product_names) {
                    $value = 0;
                    echo "<div class='order-container orderid" . $order_id . "'onclick='orderdetail(" . $order_id . "," . $case . ",null)'>\n";
                    foreach ($product_names as $index => $product_name) {
                        $product_img = $productimg[$order_id][$index];
                        $product_num = $productnum[$order_id][$index];
                        $product_oneprice = $productoneprice[$order_id][$index];
                        $product_price = $productprice[$order_id][$index];

                        $value = $product_price + $value;
                        echo "<div class='product-container '>\n";
                        echo '<div class="img-container col-1"><img src="./' . $product_img . '"></div>';
                        echo "<div class='col-9 ms-1 pdtdes'>" . $product_name . "<br>x" . $product_num . "</div>\n";
                        echo "<div class='col-2 pdtprice'>單價:$" . $product_oneprice . "</div>\n";

                        echo "</div>\n";
                    }
                    echo "<div class='row py-2 price-container'>\n";
                    echo "<div class='col-3 text-center'>訂單編號:\n";
                    echo "<span id='orderid" . $order_id . "'>" . $order_id . "</span>\n";
                    echo "</div>\n";
                    echo "<div class='col-6 text-center'>\n";
                    echo "</div>\n";
                    echo "<div class='col-3 text-center'>訂單金額: $" . $value . "</div>\n";
                    echo "</div>\n";
                    echo "</div>\n";
                }
            }
            break;
        case '5':
            $sql = "SELECT u.user_id, o.order_id, pdt.product_img_1, pdt.product_name, od.order_num, od.order_num*pdt.product_price, pdt.product_price
            FROM `order` AS o JOIN `user` AS u ON o.user_id = u.user_id
                            JOIN `orderdetail` AS od ON o.order_id = od.order_id
                            JOIN `product` AS pdt ON od.product_id = pdt.product_id
                            JOIN `ordertype` AS ot ON o.order_type = ot.ordertype_id
                            WHERE u.user_id=$user_id AND ot.ordertype_id = 5 
                            ORDER BY `o`.`order_id` DESC";
            if ($result = mysqli_query($conn, $sql)) {
                $orderproducts = array();
                $productimg = array();
                $productnum = array();
                $productoneprice = array();
                $productprice = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $order_id = $row['order_id'];
                    $product_name = $row['product_name'];
                    $product_img = $row['product_img_1'];
                    $product_num = $row['order_num'];
                    $product_oneprice = $row['product_price'];
                    $product_price = $row['od.order_num*pdt.product_price'];

                    $orderproducts[$order_id][] = $product_name;
                    $productimg[$order_id][] = $product_img;
                    $productnum[$order_id][] = $product_num;
                    $productoneprice[$order_id][] = $product_oneprice;
                    $productprice[$order_id][] = $product_price;
                }

                foreach ($orderproducts as $order_id => $product_names) {
                    $value = 0;
                    echo "<div class='order-container' onclick='orderdetail(" . $order_id . "," . $case . ",null)'>\n";
                    foreach ($product_names as $index => $product_name) {
                        $product_img = $productimg[$order_id][$index];
                        $product_num = $productnum[$order_id][$index];
                        $product_oneprice = $productoneprice[$order_id][$index];
                        $product_price = $productprice[$order_id][$index];

                        $value = $product_price + $value;
                        echo "<div class='product-container '>\n";
                        echo '<div class="img-container col-1"><img src="./' . $product_img . '"></div>';
                        echo "<div class='col-9 ms-1 pdtdes'>" . $product_name . "<br>x" . $product_num . "</div>\n";
                        echo "<div class='col-2 pdtprice'>單價:$" . $product_oneprice . "</div>\n";

                        echo "</div>\n";
                    }
                    echo "<div class='row price-container'>\n";
                    echo "<div class='col-3 text-center'>訂單編號:\n";
                    echo "<span id='orderid" . $order_id . "'>" . $order_id . "</span>\n";
                    echo "</div>\n";
                    echo "<div class='col-6 text-center'></div>\n";
                    echo "<div class='col-3 text-center'>訂單金額: $" . $value . "</div>\n";
                    echo "</div>\n";
                    echo "</div>\n";
                }
            }
            break;
        case '6':
            $sql = "SELECT u.user_id, o.order_id, pdt.product_img_1, pdt.product_name, od.order_num, od.order_num*pdt.product_price, pdt.product_price
            FROM `order` AS o JOIN `user` AS u ON o.user_id = u.user_id
                            JOIN `orderdetail` AS od ON o.order_id = od.order_id
                            JOIN `product` AS pdt ON od.product_id = pdt.product_id
                            JOIN `ordertype` AS ot ON o.order_type = ot.ordertype_id
                            WHERE u.user_id=$user_id AND ot.ordertype_id = 6 
                            ORDER BY `o`.`order_id` DESC";
            if ($result = mysqli_query($conn, $sql)) {
                $orderproducts = array();
                $productimg = array();
                $productnum = array();
                $productoneprice = array();
                $productprice = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $order_id = $row['order_id'];
                    $product_name = $row['product_name'];
                    $product_img = $row['product_img_1'];
                    $product_num = $row['order_num'];
                    $product_oneprice = $row['product_price'];
                    $product_price = $row['od.order_num*pdt.product_price'];

                    $orderproducts[$order_id][] = $product_name;
                    $productimg[$order_id][] = $product_img;
                    $productnum[$order_id][] = $product_num;
                    $productoneprice[$order_id][] = $product_oneprice;
                    $productprice[$order_id][] = $product_price;
                }

                foreach ($orderproducts as $order_id => $product_names) {
                    $value = 0;
                    echo "<div class='order-container' onclick='orderdetail(" . $order_id . "," . $case . ",null)'>\n";
                    foreach ($product_names as $index => $product_name) {
                        $product_img = $productimg[$order_id][$index];
                        $product_num = $productnum[$order_id][$index];
                        $product_oneprice = $productoneprice[$order_id][$index];
                        $product_price = $productprice[$order_id][$index];

                        $value = $product_price + $value;
                        echo "<div class='product-container '>\n";
                        echo '<div class="img-container col-1"><img src="./' . $product_img . '"></div>';
                        echo "<div class='col-9 ms-1 pdtdes'>" . $product_name . "<br>x" . $product_num . "</div>\n";
                        echo "<div class='col-2 pdtprice'>單價:$" . $product_oneprice . "</div>\n";

                        echo "</div>\n";
                    }
                    echo "<div class='row price-container'>\n";
                    echo "<div class='col-3 text-center'>訂單編號:\n";
                    echo "<span id='orderid" . $order_id . "'>" . $order_id . "</span>\n";
                    echo "</div>\n";
                    echo "<div class='col-6 text-center'></div>\n";
                    echo "<div class='col-3 text-center'>訂單金額: $" . $value . "</div>\n";
                    echo "</div>\n";
                    echo "</div>\n";
                }
            }
            break;

        case '7':
            $sql = "SELECT u.user_id, o.order_id, pdt.product_img_1, pdt.product_name, od.order_num, od.order_num*pdt.product_price, pdt.product_price
                FROM `order` AS o JOIN `user` AS u ON o.user_id = u.user_id
                                JOIN `orderdetail` AS od ON o.order_id = od.order_id
                                JOIN `product` AS pdt ON od.product_id = pdt.product_id
                                JOIN `ordertype` AS ot ON o.order_type = ot.ordertype_id
                                WHERE u.user_id=$user_id AND ot.ordertype_id = 7 
                                ORDER BY `o`.`order_id` DESC";
            if ($result = mysqli_query($conn, $sql)) {
                $orderproducts = array();
                $productimg = array();
                $productnum = array();
                $productoneprice = array();
                $productprice = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $order_id = $row['order_id'];
                    $product_name = $row['product_name'];
                    $product_img = $row['product_img_1'];
                    $product_num = $row['order_num'];
                    $product_oneprice = $row['product_price'];
                    $product_price = $row['od.order_num*pdt.product_price'];

                    $orderproducts[$order_id][] = $product_name;
                    $productimg[$order_id][] = $product_img;
                    $productnum[$order_id][] = $product_num;
                    $productoneprice[$order_id][] = $product_oneprice;
                    $productprice[$order_id][] = $product_price;
                }

                foreach ($orderproducts as $order_id => $product_names) {
                    $value = 0;
                    echo "<div class='order-container' onclick='orderdetail(" . $order_id . "," . $case . ",null)'>\n";
                    foreach ($product_names as $index => $product_name) {
                        $product_img = $productimg[$order_id][$index];
                        $product_num = $productnum[$order_id][$index];
                        $product_oneprice = $productoneprice[$order_id][$index];
                        $product_price = $productprice[$order_id][$index];

                        $value = $product_price + $value;
                        echo "<div class='product-container '>\n";
                        echo '<div class="img-container col-1"><img src="./' . $product_img . '"></div>';
                        echo "<div class='col-9 ms-1 pdtdes'>" . $product_name . "<br>x" . $product_num . "</div>\n";
                        echo "<div class='col-2 pdtprice'>單價:$" . $product_oneprice . "</div>\n";

                        echo "</div>\n";
                    }
                    echo "<div class='row price-container'>\n";
                    echo "<div class='col-3 text-center'>訂單編號:\n";
                    echo "<span id='orderid" . $order_id . "'>" . $order_id . "</span>\n";
                    echo "</div>\n";
                    echo "<div class='col-6 text-center'></div>\n";
                    echo "<div class='col-3 text-center'>訂單金額: $" . $value . "</div>\n";
                    echo "</div>\n";
                    echo "</div>\n";
                }
            }
            break;
    }
}
/* getorder end */


/* orderdetail start */


if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $type = $_POST['ordertype'];
    $waitpay = $_POST['waitpay'];
    if ($waitpay == '1' || $waitpay == '3') {
        $sql = "SELECT u.user_id, o.order_id, pdt.product_img_1, pdt.product_name, od.order_num, od.order_num*pdt.product_price, pdt.product_price, pdtc.color_color, pdts.size_size, c.city_name, t.towns_name, o.order_Rd , ts.translation_name, ts.translation_price, u.user_fname, u.user_lname, ot.ordertype_name, ops.paystatus_type, pm.payment_name
        FROM `order` AS o JOIN `user` AS u ON o.user_id = u.user_id
                        JOIN `orderdetail` AS od ON o.order_id = od.order_id
                        JOIN `product` AS pdt ON od.product_id = pdt.product_id
                        JOIN `ordertype` AS ot ON o.order_type = ot.ordertype_id
                        JOIN `product_color` AS pdtc ON od.color_id = pdtc.color_id
                        JOIN `product_size` AS pdts ON od.size_id = pdts.size_id
                        JOIN `translation` AS ts ON o.order_translation_id = ts.translation_id
                        JOIN `city` AS c ON o.order_city_id = c.city_id
                        JOIN `towns` AS t ON o.order_towns_id = t.towns_id
                        JOIN `orderpaystatus` AS ops ON ot.paystatus_id = ops.paystatus_id
                        JOIN `payment` AS pm ON o.payment_id = pm.payment_id
                        WHERE u.user_id=$user_id AND o.order_id = $id;";


        if ($result = mysqli_query($conn, $sql)) {
            $orderproducts = array();
            $productimg = array();
            $productnum = array();
            $productoneprice = array();
            $productprice = array();
            $productcolor = array();
            $productsize = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $order_id = $row['order_id'];
                $product_name = $row['product_name'];
                $product_img = $row['product_img_1'];
                $product_num = $row['order_num'];
                $product_oneprice = $row['product_price'];
                $product_price = $row['od.order_num*pdt.product_price'];
                $product_color = $row['color_color'];
                $product_size = $row['size_size'];
                $user_fname = $row['user_fname'];
                $user_lname = $row['user_lname'];
                $ordertype_name = $row['ordertype_name'];
                $paystatus_type = $row['paystatus_type'];
                $city_name = $row['city_name'];
                $towns_name = $row['towns_name'];
                $order_Rd = $row['order_Rd'];
                $translation_name = $row['translation_name'];
                $translation_price = $row['translation_price'];
                $payment_name = $row['payment_name'];



                $orderproducts[$order_id][] = $product_name;
                $productimg[$order_id][] = $product_img;
                $productnum[$order_id][] = $product_num;
                $productoneprice[$order_id][] = $product_oneprice;
                $productprice[$order_id][] = $product_price;
                $productcolor[$order_id][] = $product_color;
                $productsize[$order_id][] = $product_size;
            }
            echo "<div class='goback mb-1 px-1' onclick='getorder(" . $type . ")'>\n";
            echo "返回";
            echo "</div>\n";

            echo "<div class='order-container orderdetail'>\n";
            echo "<div class='col text-center orderid-container'>\n";
            echo "訂單編號" . $order_id . "";
            echo "</div>\n";

            echo "<div class='table-responsive'>\n";
            echo "<table class='table'>\n";
            echo "<thead>\n";
            echo "<tr>\n";
            echo "<th scope='col'>Images</th>\n";
            echo "<th scope='col'>Product</th>\n";
            echo "<th scope='col'>Color/Size</th>\n";
            echo "<th scope='col'>Price</th>\n";
            echo "<th scope='col'>Quantity</th>\n";
            echo "</tr>\n";
            echo "</thead>\n";
            echo "<tbody>\n";


            $totalprice = 0;
            for ($i = 0; $i < count($productsize[$order_id]); $i++) {

                // echo "<div class='product-container '>\n";
                // echo '<div class="img-container col-1"><img src="./' . $productimg[$order_id][$i] . '"></div>';
                // echo "<div class='col-9 ms-1 pdtdes'>" . $orderproducts[$order_id][$i] . "<br>尺寸:" . $productsize[$order_id][$i] . "&nbsp;&nbsp;&nbsp;&nbsp;顏色:" . $productcolor[$order_id][$i] . "<br>x" . $productnum[$order_id][$i] . "</div>\n";
                // echo "<div class='col-2 pdtprice'>單價:$" . $productoneprice[$order_id][$i] . "</div>\n";
                // echo "</div>\n";

                echo "<tr>";
                echo "<td><img src='./" . $productimg[$order_id][$i] . "'  class='product-image'></td>";
                echo "<td>" . $orderproducts[$order_id][$i] . "</td>";
                echo "<td>" . $productcolor[$order_id][$i] . ' /' . $productsize[$order_id][$i] . "</td>";
                echo "<td>NT" . $productoneprice[$order_id][$i] . "</td>";
                echo "<td>" . $productnum[$order_id][$i] . "</td>";
                echo "</tr>";

                $totalprice = $totalprice + $productprice[$order_id][$i];
            }

            $totalprice = $totalprice + $translation_price;
            echo "</tbody>\n";
            echo "<table>\n";
            echo "</div>\n";
            echo "<div class='col price-container'>\n";
            echo "<div class='row'>";
            echo "<div class='col-9 ms-4'>\n";
            echo "訂購人:" . $user_fname . $user_lname . "<br>";
            echo "訂單狀態:" . $ordertype_name;
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;付款狀態:" . $paystatus_type . "<br>";
            echo "配送方式:" . $translation_name;
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;配送地點:" . $city_name . $towns_name . $order_Rd . "<br>";
            echo "付款方式:" . $payment_name;
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;運費:$" . $translation_price . "<br>";
            echo "</div>\n";
            echo "<div class='col-2 text-center ms-4 mt-2'>\n";
            echo "總計:" . $totalprice;
            echo "<button class='btn btn-primary my-4 mx-3' onclick='deleteOrder(" . $order_id . "," . $type . ")'>取消訂單</button>\n";
            echo "</div>\n";
            echo "</div>";
            echo "</div>\n";
        }
    } elseif ($type == '3' || $type == '4') {
        $sql = "SELECT u.user_id, o.order_id, pdt.product_img_1, pdt.product_name, od.order_num, od.order_num*pdt.product_price, pdt.product_price, pdtc.color_color, pdts.size_size, c.city_name, t.towns_name, o.order_Rd , ts.translation_name, ts.translation_price, u.user_fname, u.user_lname, ot.ordertype_name, ops.paystatus_type, pm.payment_name
        FROM `order` AS o JOIN `user` AS u ON o.user_id = u.user_id
                        JOIN `orderdetail` AS od ON o.order_id = od.order_id
                        JOIN `product` AS pdt ON od.product_id = pdt.product_id
                        JOIN `ordertype` AS ot ON o.order_type = ot.ordertype_id
                        JOIN `product_color` AS pdtc ON od.color_id = pdtc.color_id
                        JOIN `product_size` AS pdts ON od.size_id = pdts.size_id
                        JOIN `translation` AS ts ON o.order_translation_id = ts.translation_id
                        JOIN `city` AS c ON o.order_city_id = c.city_id
                        JOIN `towns` AS t ON o.order_towns_id = t.towns_id
                        JOIN `orderpaystatus` AS ops ON ot.paystatus_id = ops.paystatus_id
                        JOIN `payment` AS pm ON o.payment_id = pm.payment_id
                        WHERE u.user_id=$user_id AND o.order_id = $id;";


        if ($result = mysqli_query($conn, $sql)) {
            $orderproducts = array();
            $productimg = array();
            $productnum = array();
            $productoneprice = array();
            $productprice = array();
            $productcolor = array();
            $productsize = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $order_id = $row['order_id'];
                $product_name = $row['product_name'];
                $product_img = $row['product_img_1'];
                $product_num = $row['order_num'];
                $product_oneprice = $row['product_price'];
                $product_price = $row['od.order_num*pdt.product_price'];
                $product_color = $row['color_color'];
                $product_size = $row['size_size'];
                $user_fname = $row['user_fname'];
                $user_lname = $row['user_lname'];
                $ordertype_name = $row['ordertype_name'];
                $paystatus_type = $row['paystatus_type'];
                $city_name = $row['city_name'];
                $towns_name = $row['towns_name'];
                $order_Rd = $row['order_Rd'];
                $translation_name = $row['translation_name'];
                $translation_price = $row['translation_price'];
                $payment_name = $row['payment_name'];



                $orderproducts[$order_id][] = $product_name;
                $productimg[$order_id][] = $product_img;
                $productnum[$order_id][] = $product_num;
                $productoneprice[$order_id][] = $product_oneprice;
                $productprice[$order_id][] = $product_price;
                $productcolor[$order_id][] = $product_color;
                $productsize[$order_id][] = $product_size;
            }
            echo "<div class='goback mb-1 px-1' onclick='getorder(" . $type . ")'>\n";
            echo "返回";
            echo "</div>\n";

            echo "<div class='order-container orderdetail'>\n";
            echo "<div class='col text-center orderid-container'>\n";
            echo "訂單編號" . $order_id . "";
            echo "</div>\n";

            echo "<div class='table-responsive'>\n";
            echo "<table class='table'>\n";
            echo "<thead>\n";
            echo "<tr>\n";
            echo "<th scope='col'>Images</th>\n";
            echo "<th scope='col'>Product</th>\n";
            echo "<th scope='col'>Color/Size</th>\n";
            echo "<th scope='col'>Price</th>\n";
            echo "<th scope='col'>Quantity</th>\n";
            echo "</tr>\n";
            echo "</thead>\n";
            echo "<tbody>\n";

            $totalprice = 0;
            for ($i = 0; $i < count($productsize[$order_id]); $i++) {

                // echo "<div class='product-container '>\n";
                // echo '<div class="img-container col-1"><img src="./' . $productimg[$order_id][$i] . '"></div>';
                // echo "<div class='col-9 ms-1 pdtdes'>" . $orderproducts[$order_id][$i] . "<br>尺寸:" . $productsize[$order_id][$i] . "&nbsp;&nbsp;&nbsp;&nbsp;顏色:" . $productcolor[$order_id][$i] . "<br>x" . $productnum[$order_id][$i] . "</div>\n";
                // echo "<div class='col-2 pdtprice'>單價:$" . $productoneprice[$order_id][$i] . "</div>\n";
                // echo "</div>\n";

                echo "<tr>";
                echo "<td><img src='./" . $productimg[$order_id][$i] . "'  class='product-image'></td>";
                echo "<td>" . $orderproducts[$order_id][$i] . "</td>";
                echo "<td>" . $productcolor[$order_id][$i] . ' /' . $productsize[$order_id][$i] . "</td>";
                echo "<td>NT" . $productoneprice[$order_id][$i] . "</td>";
                echo "<td>" . $productnum[$order_id][$i] . "</td>";
                echo "</tr>";

                $totalprice = $totalprice + $productprice[$order_id][$i];
            }

            $totalprice = $totalprice + $translation_price;
            echo "</tbody>\n";
            echo "<table>\n";
            echo "</div>\n";
            echo "<div class='col price-container'>\n";
            echo "<div class='row'>";
            echo "<div class='col-9 ms-4'>\n";
            echo "訂購人:" . $user_fname . $user_lname . "<br>";
            echo "訂單狀態:" . $ordertype_name;
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;付款狀態:" . $paystatus_type . "<br>";
            echo "配送方式:" . $translation_name;
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;配送地點:" . $city_name . $towns_name . $order_Rd . "<br>";
            echo "付款方式:" . $payment_name;
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;運費:$" . $translation_price . "<br>";
            echo "</div>\n";
            echo "<div class='col-2 text-center ms-4 mt-2'>\n";
            echo "總計:" . $totalprice;
            echo "<button class='btn btn-primary my-4 mx-3' onclick='deleteOrder(" . $order_id . "," . $type . ")'>取消訂單</button>\n";
            echo "</div>\n";
            echo "</div>";
            echo "</div>\n";
        }
    } else {
        $sql = "SELECT u.user_id, o.order_id, pdt.product_img_1, pdt.product_name, od.order_num, od.order_num*pdt.product_price, pdt.product_price, pdtc.color_color, pdts.size_size, c.city_name, t.towns_name, o.order_Rd , ts.translation_name, ts.translation_price, u.user_fname, u.user_lname, ot.ordertype_name, ops.paystatus_type, pm.payment_name
        FROM `order` AS o JOIN `user` AS u ON o.user_id = u.user_id
                        JOIN `orderdetail` AS od ON o.order_id = od.order_id
                        JOIN `product` AS pdt ON od.product_id = pdt.product_id
                        JOIN `ordertype` AS ot ON o.order_type = ot.ordertype_id
                        JOIN `product_color` AS pdtc ON od.color_id = pdtc.color_id
                        JOIN `product_size` AS pdts ON od.size_id = pdts.size_id
                        JOIN `translation` AS ts ON o.order_translation_id = ts.translation_id
                        JOIN `city` AS c ON o.order_city_id = c.city_id
                        JOIN `towns` AS t ON o.order_towns_id = t.towns_id
                        JOIN `orderpaystatus` AS ops ON ot.paystatus_id = ops.paystatus_id
                        JOIN `payment` AS pm ON o.payment_id = pm.payment_id
                        WHERE u.user_id=$user_id AND o.order_id = $id;";


        if ($result = mysqli_query($conn, $sql)) {
            $orderproducts = array();
            $productimg = array();
            $productnum = array();
            $productoneprice = array();
            $productprice = array();
            $productcolor = array();
            $productsize = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $order_id = $row['order_id'];
                $product_name = $row['product_name'];
                $product_img = $row['product_img_1'];
                $product_num = $row['order_num'];
                $product_oneprice = $row['product_price'];
                $product_price = $row['od.order_num*pdt.product_price'];
                $product_color = $row['color_color'];
                $product_size = $row['size_size'];
                $user_fname = $row['user_fname'];
                $user_lname = $row['user_lname'];
                $ordertype_name = $row['ordertype_name'];
                $paystatus_type = $row['paystatus_type'];
                $city_name = $row['city_name'];
                $towns_name = $row['towns_name'];
                $order_Rd = $row['order_Rd'];
                $translation_name = $row['translation_name'];
                $translation_price = $row['translation_price'];
                $payment_name = $row['payment_name'];



                $orderproducts[$order_id][] = $product_name;
                $productimg[$order_id][] = $product_img;
                $productnum[$order_id][] = $product_num;
                $productoneprice[$order_id][] = $product_oneprice;
                $productprice[$order_id][] = $product_price;
                $productcolor[$order_id][] = $product_color;
                $productsize[$order_id][] = $product_size;
            }
            echo "<div class='goback mb-1 px-1' onclick='getorder(" . $type . ")'>\n";
            echo "返回";
            echo "</div>\n";

            echo "<div class='order-container orderdetail'>\n";
            echo "<div class='col text-center orderid-container pb-2' style='border-bottom:1px solid black'>\n";
            echo "<b>訂單編號" . $order_id . "</b>";
            echo "</div>\n";

            
            echo "<div class='table-responsive'>\n";
            echo "<table class='table'>\n";
            echo "<thead>\n";
            echo "<tr>\n";
            echo "<th scope='col'>Images</th>\n";
            echo "<th scope='col'>Product</th>\n";
            echo "<th scope='col'>Color/Size</th>\n";
            echo "<th scope='col'>Price</th>\n";
            echo "<th scope='col'>Quantity</th>\n";
            echo "</tr>\n";
            echo "</thead>\n";
            echo "<tbody>\n";

            $totalprice = 0;
            for ($i = 0; $i < count($productsize[$order_id]); $i++) {

                // echo "<div class='product-container '>\n";
                // echo '<div class="img-container col-1"><img src="./' . $productimg[$order_id][$i] . '"></div>';
                // echo "<div class='col-9 ms-1 pdtdes'>" . $orderproducts[$order_id][$i] . "<br>尺寸:" . $productsize[$order_id][$i] . "&nbsp;&nbsp;&nbsp;&nbsp;顏色:" . $productcolor[$order_id][$i] . "<br>x" . $productnum[$order_id][$i] . "</div>\n";
                // echo "<div class='col-2 pdtprice'>單價:$" . $productoneprice[$order_id][$i] . "</div>\n";
                // echo "</div>\n";


                echo "<tr>";
                echo "<td><img src='./" . $productimg[$order_id][$i] . "'  class='product-image'></td>";
                echo "<td>" . $orderproducts[$order_id][$i] . "</td>";
                echo "<td>" . $productcolor[$order_id][$i] . ' /' . $productsize[$order_id][$i] . "</td>";
                echo "<td>NT" . $productoneprice[$order_id][$i] . "</td>";
                echo "<td>" . $productnum[$order_id][$i] . "</td>";
                echo "</tr>";

                $totalprice = $totalprice + $productprice[$order_id][$i];
            }

            $totalprice = $totalprice + $translation_price;
            echo "</tbody>\n";
            echo "<table>\n";
            echo "</div>\n";
            echo "<div class='col price-container'>\n";
            echo "<div class='row'>";
            echo "<div class='col-9 ms-4'>\n";
            echo "訂購人:" . $user_fname . $user_lname . "<br>";
            echo "訂單狀態:" . $ordertype_name;
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;付款狀態:" . $paystatus_type . "<br>";
            echo "配送方式:" . $translation_name;
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;配送地點:" . $city_name . $towns_name . $order_Rd . "<br>";
            echo "付款方式:" . $payment_name;
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;運費:$" . $translation_price . "<br>";
            echo "</div>\n";
            echo "<div class='col-2 text-center ms-4 mt-2'>\n";
            echo "總計:" . $totalprice;
            echo "</div>\n";
            echo "</div>";
            echo "</div>\n";
            echo "</div>\n";

        }
    }
}




/* orderdetail end */

/* deleteorder start */
if (isset($_POST['delid'])) {
    $delid = $_POST['delid'];


    $sql = "UPDATE `order` SET `order_type`=7 WHERE order_id = $delid;";

    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_affected_rows($conn) > 0) {
        echo "ok";
    }
}

/* deleteorder end */
