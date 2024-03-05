<?php
session_start();
if (!isset($_SESSION['user_account']))
    header('Location: login.php');
?>
<!DOCTYPE php>
<php lang="en">

    <head>
        <title>會員中心</title>
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

        <!-- Script -->
        <script src="assets/js/jquery-1.11.0.min.js"></script>
        <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/templatemo.js"></script>
        <script src="assets/js/custom.js"></script>

        <script>
            // 初始化頁面
            $(document).ready(function() {
                loadContent('mc/mc'); // 載入初始內容
            });

            // 先將所有li元素的class移除
            function changeActive(element, contentId) {
                var menuItems = document.querySelectorAll('.list-group-item');
                menuItems.forEach(function(item) {
                    item.classList.remove('active');
                });

                // 再將被點擊的li元素加上active class
                element.classList.add('active');

                loadContent(contentId);
            }

            function loadContent(contentId) {
                // 發送AJAX請求
                $.ajax({
                    url: contentId + ".php", // 頁面內容存儲在以選項值為名稱的PHP文件中
                    method: "POST",
                    data: {}, // 放入需要發送的資料
                    success: function(data) {
                        $("#content").html(data); // 將獲取的內容放入右側內容區域
                    },
                    error: function() {
                        alert("載入內容失敗"); // 處理錯誤
                    }
                });
            }
        </script>

        <style>
            a {
                text-decoration: none;
                /* 取消下底線 */
            }
        </style>

        <!-- TemplateMo 559 Zay Shop  https://templatemo.com/tm-559-zay-shop -->

    </head>

    <!-- Top Nav -->
    <?php include_once "top-nav.php" ?>

    <!-- Header -->
    <?php include_once "header.php" ?>

    <!-- Conn -->
    <?php include_once "conn.php" ?>

    <!-- SELECT COUNT(*) FROM `order` WHERE; SQL查詢選單筆數 -->

    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="my-4 ps-4 h1"> 會員中心 </div>
                <div class="col-12 col-md-3">
                    <!-- 左側選單 -->
                    <form method="post" enctype="multipart/form-data">
                        <ul class="list-group text-center btn h4">
                            <li class="list-group-item list-group-item-action fw-bold active" onclick="changeActive(this, 'mc/mc')">會員資料</li>
                            <li class="list-group-item list-group-item-action fw-bold" onclick="changeActive(this, 'mc/mc_edit')">會員資料修改</li>
                            <a href="cart3.php">
                                <li class="list-group-item list-group-item-action fw-bold">
                                    我的購物車
                                    <span class="badge bg-dark rounded-pill">10</span>
                                </li>
                            </a>
                            <li class="list-group-item list-group-item-action fw-bold" onclick="changeActive(this, 'searchorder-final')">
                                訂單查詢
                                <span class="badge bg-dark rounded-pill">5</span>
                            </li>
                            <li class="list-group-item list-group-item-action fw-bold" onclick="changeActive(this, 'page5')">
                                我的收藏
                                <span class="badge bg-dark rounded-pill">2</span>
                            </li>
                            <li class="list-group-item list-group-item-action fw-bold" onclick="changeActive(this, 'mc/mc_logout')">登出</li>
                        </ul>
                    </form>
                </div>

                <!-- 右側內容區域 -->
                <div class="col-12 col-md-9" id="content"></div>
            </div>
        </div>
        </div>
    </body>

    <!-- Footer -->
    <?php include_once "footer.php" ?>
</php>