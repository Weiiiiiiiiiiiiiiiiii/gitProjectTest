<!DOCTYPE html>
<html lang="en">

<head>
    <title>Zay Shop - Product Detail Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="assets/css/fontRobotocss2.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">

    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css">
    <!-- Search Order -->
    <link rel="stylesheet" href="assets/css/searchorder.css">
    <!--
    
TemplateMo 559 Zay Shop

https://templatemo.com/tm-559-zay-shop

-->
</head>

<body>
    <!-- Start Top Nav -->
    <?php
    include_once "top-nav.php"
    ?>
    <!-- Close Top Nav -->


    <!-- Header -->
    <?php
    include_once "header.php"
    ?>
    <!-- Close Header -->


    <!-- Start Order -->
    <?php
    include 'back/conn.php'
    ?>
    <div class=".container-fluid maincontainer py-4">
        <div class="container">
            <div class="row">
                <div class="col-3">123</div>
                <div class="col" id="adddiv">

                    <div class="status-container row">
                        <div class="col text-center py-2 my-2 removecss addcss1" onclick="getorder(1)">全部</div>
                        <div class="col text-center py-2 my-2 removecss addcss2" onclick="getorder(2)">待付款</div>
                        <div class="col text-center py-2 my-2 removecss addcss3" onclick="getorder(3)">待出貨</div>
                        <div class="col text-center py-2 my-2 removecss addcss4" onclick="getorder(4)">已出貨</div>
                        <div class="col text-center py-2 my-2 removecss addcss5" onclick="getorder(5)">待收貨</div>
                        <div class="col text-center py-2 my-2 removecss addcss6" onclick="getorder(6)">已完成</div>
                        <div class="col text-center py-2 my-2 removecss addcss7" onclick="getorder(7)">已取消</div>
                    </div>

                    <div id="order">
                        <?php
                        $user_id = 1;
                        $sql = "SELECT u.user_id, o.order_id, pdt.product_img_1, pdt.product_name, od.order_num, od.order_num*pdt.product_price, pdt.product_price, ot.ordertype_id FROM `order` AS o JOIN `user` AS u ON o.user_id = u.user_id JOIN `orderdetail` AS od ON o.order_id = od.order_id JOIN `product` AS pdt ON od.product_id = pdt.product_id JOIN `ordertype` AS ot ON o.order_type = ot.ordertype_id WHERE u.user_id=1 ORDER BY `o`.`order_id` DESC;";
                        $result = mysqli_query($conn, $sql);
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
                            echo "<div class='order-container' onclick='orderdetail(" . $order_id . ",1," . $ordertype[$order_id][0] . ")'>\n";
                            foreach ($product_names as $index => $product_name) {
                                $product_img = $productimg[$order_id][$index];
                                $product_num = $productnum[$order_id][$index];
                                $product_oneprice = $productoneprice[$order_id][$index];
                                $product_price = $productprice[$order_id][$index];


                                $value = $product_price + $value;
                                echo "<div class='product-container '>\n";
                                echo '<div class="img-container col-1"><img src="./' . $product_img . '"></div>';
                                echo "<div class='col-9 ms-1 pdtdes'>" . $product_name . "<br>x" . $product_num . "</div>\n";
                                echo "<div class='col-2 pdtprice'>單價:
                                $" . $product_oneprice . "</div>\n";

                                echo "</div>\n";
                            }
                            echo "<div class='row price-container'>\n";
                            echo "<div class='col-3 text-center'>訂單編號:\n";
                            echo "<span id='orderid" . $order_id . "'>" . $order_id . "</span>\n";
                            echo "</div>\n";
                            echo "<div class='col-6'></div>\n";
                            echo "<div class='col-3 text-center'>訂單金額: $" . $value . "</div>\n";
                            echo "</div>\n";
                            echo "</div>\n";
                        }

                        ?>
                    </div>
                </div>

            </div>
        </div>
        <!-- SELECT o.order_id, sum(od.order_num*pdt.product_price)
                    FROM `order` AS o JOIN `user` AS u ON o.user_id = u.user_id
                                    JOIN `orderdetail` AS od ON o.order_id = od.order_id
                                    JOIN `product` AS pdt ON od.product_id = pdt.product_id
                                    WHERE u.user_id=1
                                    GROUP BY o.order_id; -->
        <!-- Close Order -->


        <!-- Start Footer -->
        <?php
        include_once "footer.php"
        ?>
        <!-- End Footer -->

        <!-- Start Script -->
        <script src="assets/js/jquery-1.11.0.min.js"></script>
        <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/templatemo.js"></script>
        <script src="assets/js/custom.js"></script>
        <script src="assets/js/searchorder.js"></script>
        <!-- End Script -->

        <!-- Start Slider Script -->
        <script src="assets/js/slick.min.js"></script>
        <script>
            $('#carousel-related-product').slick({
                infinite: true,
                arrows: false,
                slidesToShow: 4,
                slidesToScroll: 3,
                dots: true,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 3
                        }
                    }
                ]
            });
        </script>
        <!-- End Slider Script -->

</body>

</html>