<?php
session_start();
if (!isset($_SESSION['user_account']))
    header('Location: login.php');
?>
<!DOCTYPE php>
<php lang="en">

    <head>
        <title>Zay Shop - Product Listing Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/templatemo.css">
        <link rel="stylesheet" href="assets/css/custom.css">

        <!-- Load fonts style after rendering the layout styles -->
        <link rel="stylesheet" href="assets/css/fontRobotocss2.css">
        <link rel="stylesheet" href="assets/css/fontawesome.css">

        <!-- Start Script -->
        <script src="assets/js/jquery-1.11.0.min.js"></script>
        <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/templatemo.js"></script>
        <script src="assets/js/custom.js"></script>
        <!-- End Script -->
        <!--
    
TemplateMo 559 Zay Shop

https://templatemo.com/tm-559-zay-shop

-->

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const buttons1 = document.querySelectorAll('[id^="cart-btn"]'); // 選擇所有id以"cart-btn"開頭的按鈕
                buttons1.forEach(button1 => {
                    let isCart = button1.dataset.cart === 'true'; // 從data屬性獲取按鈕的購物車狀態
                    console.log(isCart);

                    // 初始化按鈕狀態
                    updateButtonState(button1, isCart);

                    button1.addEventListener('click', function() {
                        // 點擊按鈕時切換購物車狀態
                        isCart = !isCart;//將!isCart反轉往回丟
                        button1.dataset.cart = isCart.toString(); // 將已經更新的isCart用toString()的方式回丟給html

                        // 更新按鈕狀態
                        updateButtonState(button1, isCart);

                        // 根據狀態執行相應的操作
                        const cartproductId = button1.getAttribute('data-product-id'); // 獲取產品ID
                        if (isCart) {
                            console.log('Adding product to cart:', cartproductId);
                            // 在這裡執行新增到購物車的相應操作
                        } else {
                            console.log('Removing product from cart:', cartproductId);
                            // 在這裡執行從購物車中刪除的相應操作
                        }
                    });
                });

                // 函數：更新按鈕狀態
                function updateButtonState(btn, isCart) {
                    const heartIcon = btn.querySelector('i');

                    // 根據購物車狀態切換圖標
                    if (isCart) {
                        heartIcon.classList.remove('fas', 'fa-shopping-cart');
                        heartIcon.classList.add('fas', 'fa-cart-plus');
                    } else {
                        heartIcon.classList.remove('fas', 'fa-cart-plus');
                        heartIcon.classList.add('fas', 'fa-shopping-cart');
                    }
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                const buttons = document.querySelectorAll('[id^="favorite-btn"]'); // 選擇所有id以"favorite-btn"開頭的按鈕
                buttons.forEach(button => {
                    let isFavorite = button.dataset.favorite === 'true'; // 從data屬性獲取按鈕的最愛狀態
                    console.log(isFavorite);

                    // 初始化按鈕狀態
                    updateButtonState(button, isFavorite);

                    button.addEventListener('click', function() {
                        // 點擊按鈕時切換購物車狀態
                        isFavorite = !isFavorite;//將!isFavorite反轉往回丟
                        button.dataset.cart = isFavorite.toString(); // 將已經更新的isFavorite用toString()的方式回丟給html

                        // 更新按鈕狀態
                        updateButtonState(button, isFavorite);

                        // 根據狀態執行相應的操作
                        const favoriteproductId = button.getAttribute('data-product-id'); // 獲取產品ID
                        if (isFavorite) {
                            console.log('Adding product to favorite:', favoriteproductId);
                            // 在這裡執行新增到購物車的相應操作
                        } else {
                            console.log('Removing product from favorite:', favoriteproductId);
                            // 在這裡執行從購物車中刪除的相應操作
                        }
                    });
                });

                // 函數：更新按鈕狀態
                // 函數：更新按鈕圖標
                function updateButtonState(btn, isFavorite) {
                    const heartIcon = btn.querySelector('i');

                    // 如果是最愛，切換到實心心形圖標
                    if (isFavorite) {
                        heartIcon.classList.remove('far');
                        heartIcon.classList.add('fas');
                    } else { // 如果不是最愛，切換到空心心形圖標
                        heartIcon.classList.remove('fas');
                        heartIcon.classList.add('far');
                    }
                }

            });
        </script>
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

        <!-- Modal -->
        <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="w-100 pt-1 mb-5 text-right">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="get" class="modal-content modal-body border-0 p-0">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                        <button type="submit" class="input-group-text bg-success text-light">
                            <i class="fa fa-fw fa-search text-white"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>



        <!-- Start Content -->
        <div class="container py-5">
            <div class="row">

                <div class="col-lg-3">
                    <h1 class="h2 pb-4">Categories</h1>
                    <ul class="list-unstyled templatemo-accordion">
                        <li class="pb-3">
                            <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                                Gender
                                <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                            </a>
                            <ul class="collapse show list-unstyled pl-3">
                                <li><a class="text-decoration-none" href="#">Men</a></li>
                                <li><a class="text-decoration-none" href="#">Women</a></li>
                            </ul>
                        </li>
                        <li class="pb-3">
                            <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                                Sale
                                <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                            </a>
                            <ul id="collapseTwo" class="collapse list-unstyled pl-3">
                                <li><a class="text-decoration-none" href="#">Sport</a></li>
                                <li><a class="text-decoration-none" href="#">Luxury</a></li>
                            </ul>
                        </li>
                        <li class="pb-3">
                            <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                                Product
                                <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                            </a>
                            <ul id="collapseThree" class="collapse list-unstyled pl-3">
                                <li><a class="text-decoration-none" href="#">Bag</a></li>
                                <li><a class="text-decoration-none" href="#">Sweather</a></li>
                                <li><a class="text-decoration-none" href="#">Sunglass</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-inline shop-top-menu pb-3 pt-1">
                                <li class="list-inline-item">
                                    <a class="h3 text-dark text-decoration-none mr-3" href="#">All</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="h3 text-dark text-decoration-none mr-3" href="#">Men's</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="h3 text-dark text-decoration-none" href="#">Women's</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 pb-4">
                            <div class="d-flex">
                                <select class="form-control">
                                    <option>Featured</option>
                                    <option>A to Z</option>
                                    <option>Item</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- 商品區域開始 -->
                        <div class="row">
                            <?php
                            // 商品數量
                            //include "./shop/productsearch.php";                            
                            include "conn.php";
                            $search = isset($_POST['search']) ? $_POST['search'] : "";
                            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

                            if ($search == "") {
                                $sql = "SELECT p.product_id, p.product_name, p.product_content, p.product_type1, p.product_type2, p.product_type3,
                                    CASE WHEN f.user_id IS NOT NULL THEN 1 ELSE 0 END AS 'favorite',
                                    CASE WHEN c.user_id IS NOT NULL THEN 1 ELSE 0 END AS 'carts',
                                    p.product_price,
                                    p.product_img_1
                                    FROM product p
                                    LEFT JOIN favorite f ON p.product_id = f.product_id AND f.user_id = '" . $user_id . "'
                                    LEFT JOIN carts c ON p.product_id = c.product_id AND c.user_id = '" . $user_id . "'
                                    GROUP BY p.product_id
                                    ORDER BY p.product_id";
                            } else {
                                $sql = "SELECT p.product_id, p.product_name, p.product_content, p.product_type1, p.product_type2, p.product_type3,
                                        CASE WHEN f.user_id IS NOT NULL THEN 1 ELSE 0 END AS 'favorite',
                                        CASE WHEN c.user_id IS NOT NULL THEN 1 ELSE 0 END AS 'carts',
                                        p.product_price,
                                        p.product_img_1
                                        FROM product p
                                        LEFT JOIN favorite f ON p.product_id = f.product_id AND f.user_id = '" . $user_id . "'
                                        LEFT JOIN carts c ON p.product_id = c.product_id AND c.user_id = '" . $user_id . "'
                                        WHERE `product_name` LIKE '%" . $search . "%' or `product_content` LIKE '%" . $search . "%'
                                        GROUP BY p.product_id
                                        ORDER BY p.product_id";
                            }
                            $product_search_result = mysqli_query($conn, $sql);


                            $total_products = mysqli_num_rows($product_search_result);

                            // 每頁顯示的商品數量
                            $products_per_page = 12;

                            // 當前頁碼，假設從 URL 中獲取，這裡暫時設定為1
                            //$current_page = 1;
                            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

                            // 計算起始索引
                            $start_index = ($current_page - 1) * $products_per_page;

                            // 設定結束索引
                            $end_index = $start_index + $products_per_page;
                            if ($product_search_result) {
                                if (mysqli_num_rows($product_search_result) > 0) {
                                    $m = 0;
                                    while ($row = mysqli_fetch_array($product_search_result)) {
                                        $favorite = ($row['favorite'] == "1") ? "true" : "false";
                                        $cart = ($row['carts'] == "1") ? "true" : "false";

                                        if ($m >= $start_index && $m < $end_index) {//分業按鈕預留，未測試
                                            $styledisplay = "";
                                        } else {
                                            $styledisplay = "display:none";
                                        }
                            ?>
                                        <!-- 單個商品 -->
                                        <div class="col-md-4" style="<?= $styledisplay ?>">
                                            <div class="card mb-4 product-wap rounded-0">
                                                <div class="card rounded-0">
                                                    <img class="card-img rounded-0 img-fluid" src="<?= $row['product_img_1'] ?>">
                                                    <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                                        <ul class="list-unstyled">
                                                            <span id="favorite-btn-<?= $row['product_id'] ?>" data-product-id="<?= $row['product_id'] ?>" data-favorite="<?= $favorite ?>">
                                                                <li><a class="btn btn-success text-white "><i class="far fa-heart"></i></a></li>
                                                            </span>

                                                            <li><a class="btn btn-success text-white mt-2"><i class="far fa-eye"></i></a></li>

                                                            <span id="cart-btn-<?= $row['product_id'] ?>" data-product-id="<?= $row['product_id'] ?>" data-cart="<?= $cart ?>">
                                                                <li><a class="btn btn-success text-white mt-2"><i class="fas fa-shopping-cart"></i></a></li>
                                                            </span>

                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <a href="shop-single.php" class="h3 text-decoration-none"><?= $row['product_name'] ?></a>
                                                    <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                                        <li>M/L/X/XL<?= $row['carts'] ?><?= $cart ?></li>
                                                        <li class="pt-2">
                                                            <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                                            <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                                            <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                                            <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                                            <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled d-flex justify-content-center mb-1">
                                                        <li>
                                                            <i class="text-warning fa fa-star"></i>
                                                            <i class="text-warning fa fa-star"></i>
                                                            <i class="text-warning fa fa-star"></i>
                                                            <i class="text-muted fa fa-star"></i>
                                                            <i class="text-muted fa fa-star"></i>
                                                        </li>
                                                    </ul>
                                                    <p class="text-center mb-0">$<?= $row['product_price'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                            <?php
                                        $m++;
                                    }
                                }
                            }
                            $conn->close();
                            ?>
                        </div>
                        <!-- 商品區域結束 -->
                    </div>
                    <div class="row">
                        <ul class="pagination pagination-lg justify-content-end">
                            <?php
                            // 總頁數
                            $total_pages = ceil($total_products / $products_per_page);

                            // 生成分頁按鈕
                            for ($page = 1; $page <= $total_pages; $page++) {
                                $active_class = ($page == $current_page) ? 'active' : ''; // 檢查當前頁碼是否與迴圈中的頁碼相同

                                // 在適當的按鈕上添加 active 類別
                            ?>
                                <li class="page-item <?php echo $active_class; ?>">
                                    <a class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 <?php echo ($active_class !== '') ? 'text-light' : 'text-dark'; ?>" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Content -->

        <!-- Start Brands -->
        <section class="bg-light py-5">
            <div class="container my-4">
                <div class="row text-center py-3">
                    <div class="col-lg-6 m-auto">
                        <h1 class="h1">Our Brands</h1>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            Lorem ipsum dolor sit amet.
                        </p>
                    </div>
                    <div class="col-lg-9 m-auto tempaltemo-carousel">
                        <div class="row d-flex flex-row">
                            <!--Controls-->
                            <div class="col-1 align-self-center">
                                <a class="h1" href="#multi-item-example" role="button" data-bs-slide="prev">
                                    <i class="text-light fas fa-chevron-left"></i>
                                </a>
                            </div>
                            <!--End Controls-->

                            <!--Carousel Wrapper-->
                            <div class="col">
                                <div class="carousel slide carousel-multi-item pt-2 pt-md-0" id="multi-item-example" data-bs-ride="carousel">
                                    <!--Slides-->
                                    <div class="carousel-inner product-links-wap" role="listbox">

                                        <!--First slide-->
                                        <div class="carousel-item active">
                                            <div class="row">
                                                <div class="col-3 p-md-5">
                                                    <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_01.png" alt="Brand Logo"></a>
                                                </div>
                                                <div class="col-3 p-md-5">
                                                    <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_02.png" alt="Brand Logo"></a>
                                                </div>
                                                <div class="col-3 p-md-5">
                                                    <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_03.png" alt="Brand Logo"></a>
                                                </div>
                                                <div class="col-3 p-md-5">
                                                    <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_04.png" alt="Brand Logo"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End First slide-->

                                        <!--Second slide-->
                                        <div class="carousel-item">
                                            <div class="row">
                                                <div class="col-3 p-md-5">
                                                    <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_01.png" alt="Brand Logo"></a>
                                                </div>
                                                <div class="col-3 p-md-5">
                                                    <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_02.png" alt="Brand Logo"></a>
                                                </div>
                                                <div class="col-3 p-md-5">
                                                    <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_03.png" alt="Brand Logo"></a>
                                                </div>
                                                <div class="col-3 p-md-5">
                                                    <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_04.png" alt="Brand Logo"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End Second slide-->

                                        <!--Third slide-->
                                        <div class="carousel-item">
                                            <div class="row">
                                                <div class="col-3 p-md-5">
                                                    <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_01.png" alt="Brand Logo"></a>
                                                </div>
                                                <div class="col-3 p-md-5">
                                                    <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_02.png" alt="Brand Logo"></a>
                                                </div>
                                                <div class="col-3 p-md-5">
                                                    <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_03.png" alt="Brand Logo"></a>
                                                </div>
                                                <div class="col-3 p-md-5">
                                                    <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_04.png" alt="Brand Logo"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End Third slide-->

                                    </div>
                                    <!--End Slides-->
                                </div>
                            </div>
                            <!--End Carousel Wrapper-->

                            <!--Controls-->
                            <div class="col-1 align-self-center">
                                <a class="h1" href="#multi-item-example" role="button" data-bs-slide="next">
                                    <i class="text-light fas fa-chevron-right"></i>
                                </a>
                            </div>
                            <!--End Controls-->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Brands-->


        <!-- Start Footer -->
        <?php
        include_once "footer.php"
        ?>
        <!-- End Footer -->


    </body>

</php>