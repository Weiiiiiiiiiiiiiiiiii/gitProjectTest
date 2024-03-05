<?php
// include_once "../conn.php";
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : "";
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : "";
$ordertype_id = isset($_GET['ordertype_id']) ? $_GET['ordertype_id'] : "";
$ordertype_name = isset($_GET['ordertype_name']) ? $_GET['ordertype_name'] : "";
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>訂單詳情</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* 全局樣式 */
    .product-image {
    width: 50px;
    height: auto;
    }

    .order-header h2 {
        margin: 0;
    }

    /* 訂單明細樣式 */
    .order-details {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 4px;
    }

    .table img {
        width: 60px;
        height: 60px;
    }

    /* 訂購者資訊樣式 */
    .buyer-info {
        background-color: #fff;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    /* 響應式斷點樣式 */
    @media (max-width: 768px) {
        .order-details, .buyer-info {
            padding: 10px;
        }
        .order-header h2 {
            font-size: 16px;
        }
        .table img {
            width: 40px;
            height: 40px;
        }
    }

    </style>
</head>
<body>
    <!-- Header -->
    <?php
    include_once "../newheader.php";
    ?>
    <!-- Close Header -->
    <div class="container mt-4">
        <div class="order-header d-flex justify-content-between align-items-center mb-4">
            <div><h2>會員: <?= $user_id ?></h2></div>
            <div><h2>訂單編號: <?= $order_id ?></h2></div>
            <div><h2>訂單狀態: <?= $ordertype_name ?></h2></div>
        </div>

        <!-- 訂單明細 -->
        <div class="order-details mb-4">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Images</th>
                            <th scope="col">Product</th>
                            <th scope="col">Color/Size</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- 每一項訂單明細的範例 依照orderdetail_id排序-->
                        <?php
                        include_once "../conn.php";
                        $sql = "SELECT 
                                od.orderdetail_id,
                                o.order_id,
                                od.product_id,
                                p.product_name,
                                pc.color_color,
                                ps.size_size,
                                p.product_price,
                                od.order_num,
                                (p.product_price * od.order_num) AS total_price,
                                p.product_img_1
                                FROM 
                                orderdetail od
                                JOIN 
                                product p ON od.product_id = p.product_id
                                JOIN 
                                product_color pc ON od.color_id = pc.color_id
                                JOIN 
                                product_size ps ON od.size_id = ps.size_id
                                JOIN 
                                `order` o ON od.order_id = o.order_id
                                JOIN 
                                user u ON o.user_id = u.user_id
                                WHERE 
                                u.user_id = $user_id AND 
                                o.order_id = $order_id AND 
                                o.order_type = $ordertype_id;";

                                if($result = mysqli_query($conn,$sql)){
                                    // echo "success"; 
                                    if (mysqli_num_rows($result) != 0){
                                        // echo "ok";
                                        while ($orderdetaillist = mysqli_fetch_assoc($result)){
                                            echo '<tr>';
                                            echo '<td><img src="' . $orderdetaillist['product_img_1'] . '" alt="product_img_1" class="product-image"></td>';
                                            echo '<td>' . $orderdetaillist['product_name'] . '</td>';
                                            echo '<td>' . $orderdetaillist['color_color'] . ' /' . $orderdetaillist['size_size'] . '</td>';
                                            echo '<td>NT' . $orderdetaillist['product_price'] . '</td>';
                                            echo '<td>' . $orderdetaillist['order_num'] . '</td>';
                                            echo '<td>' . $orderdetaillist['total_price'] . '</td>';
                                            echo '</tr>';
                                        }
                                    }
                                }
                                ?>
                        <!-- 可以依據實際訂單數量複製更多的<tr>...</tr> -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 訂購者資訊 -->
        <div class="payment-info">
                <div class="row">
                    <?php
                    $sql_information = "SELECT 
                    o.user_id,
                    u.user_fname,
                    u.user_lname,
                    o.order_id,
                    ot.ordertype_id,
                    c.city_name AS order_city,
                    t.towns_name AS order_town,
                    o.order_Rd,
                    tr.translation_name,
                    tr.translation_price,
                    SUM(p.product_price * od.order_num) + tr.translation_price AS total_price_with_translation
                    FROM 
                    `order` o
                    JOIN 
                    user u ON o.user_id = u.user_id
                    JOIN 
                    ordertype ot ON o.order_type = ot.ordertype_id
                    JOIN 
                    orderdetail od ON o.order_id = od.order_id
                    JOIN 
                    product p ON od.product_id = p.product_id
                    JOIN 
                    city c ON o.order_city_id = c.city_id
                    JOIN 
                    towns t ON o.order_towns_id = t.towns_id
                    JOIN 
                    translation tr ON o.order_translation_id = tr.translation_id
                    WHERE 
                    u.user_id = $user_id AND 
                    o.order_id = $order_id AND 
                    ot.ordertype_id = $ordertype_id
                    GROUP BY 
                    o.user_id, 
                    o.order_id, 
                    ot.ordertype_id, 
                    c.city_name, 
                    t.towns_name,
                    o.order_Rd,
                    tr.translation_name,
                    tr.translation_price;";
                    if($result2 = mysqli_query($conn,$sql_information)){
                        // echo "success"; 
                        if (mysqli_num_rows($result2) != 0){
                            // echo "ok";
                            $orderinformation = mysqli_fetch_assoc($result2);
                                echo '<div class="col-12 col-md-3">';
                                echo '<h3>配送地址：' . $orderinformation['order_city'] . $orderinformation['order_town'] . $orderinformation['order_Rd'] .'</h3>';
                                echo '</div>';
                                echo '<div class="col-12 col-md-3">';
                                echo '<h3>運送方式：'. $orderinformation['translation_name'] .'</h3>';
                                echo '<h3>運費：'. $orderinformation['translation_price'] .'</h3>';
                                echo '</div>';
                                echo '<div class="col-12 col-md-3">';
                                echo '<h3>總計：'. $orderinformation['total_price_with_translation'] .'</h3>';
                                echo '</div>';
                                echo '<div class="col-12 col-md-3">';
                                echo '<h3>訂購者姓名：'. $orderinformation['user_lname'] . $orderinformation['user_fname'] .'</h3>';
                                echo '</div>';
                        }
                    }
                    ?>
                </div>
            <!-- 其他訂購者資訊 -->
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
