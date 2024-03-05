<?php
include './back/conn.php';




    $sql = "SELECT u.user_id, o.order_id, pdt.product_img_1, pdt.product_name, od.order_num, od.order_num*pdt.product_price, pdt.product_price, pdtc.color_color, pdts.size_size
    FROM `order` AS o JOIN `user` AS u ON o.user_id = u.user_id
                    JOIN `orderdetail` AS od ON o.order_id = od.order_id
                    JOIN `product` AS pdt ON od.product_id = pdt.product_id
                    JOIN `ordertype` AS ot ON o.order_type = ot.ordertype_id
                    JOIN `product_color` AS pdtc ON od.color_id = pdtc.color_id
                    JOIN `product_size` AS pdts ON od.size_id = pdts.size_id
                    WHERE u.user_id=1 AND o.order_id = 38;";

    if($result = mysqli_query($conn, $sql)){
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['user_id'];
            echo $row['order_id'];
            echo $row['product_img_1'];
            echo $row['product_name'];
            echo $row['order_num'];
            echo $row['total_price'];
            echo $row['product_price'];
            echo $row['color_color'];
            echo $row['size_size'];
        }
    }




