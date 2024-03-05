<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/fontawesome.css">
</head>

<body>


    <!-- HTML -->
    <!-- <button id="favorite-btn" data-product-id="123" data-favorite01="false">Add to Favorites</button> -->
    <?php
    $i = 0;
    while ($i < 5) {
    ?>
        <div>
            <ul>
                <span id="favorite-btn-<?=$i?>" data-product-id="<?= $i?>" data-favorite="false">
                    <li><a class="btn btn-success text-white "><i class="far fa-heart"></i></a></li>
                </span>



                <span id="cart-btn-<?=$i?>" data-product-id="<?= $i?>" data-cart="false">
                    <li><a class="btn btn-success text-white mt-2"><i class="fas fa-shopping-cart"></i></a></li>
                </span>
            </ul>
        </div>
    <?php
        $i++;
    }
    ?>
    <!-- 
    HTML部分：

<button id="favorite-btn" data-product-id="123" data-favorite="false">Add to Favorites</button>：這是一個HTML按鈕元素，其中id屬性是按鈕的唯一識別符，data-product-id屬性是產品的識別符，data-favorite屬性表示該產品是否已經是最愛。按鈕的文本內容可以自定義。
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
        

//         document.addEventListener('click', function(event) {
//     const target = event.target;
    
//     // 檢查點擊的是favorite-btn還是cart-btn
//     if (target.matches('[id^="favorite-btn"]')) {
//         // 點擊的是favorite-btn，執行相應的操作
//         const productId = target.getAttribute('data-product-id');
//         const isFavorite = target.getAttribute('data-favorite') === 'true';

//         // 處理相應的最愛按鈕操作，例如新增或刪除最愛商品
//         if (isFavorite) {
//             // 處理刪除最愛的邏輯
//             console.log('Removing product from favorites:', productId);
//             // 處理回傳資料庫的功能空間
//         } else {
//             // 處理新增最愛的邏輯
//             console.log('Adding product to favorites:', productId);
//             // 處理回傳資料庫的功能空間
//         }

//         // 更新按鈕狀態
//         updateButtonState(target);
//     } else if (target.matches('[id^="cart-btn"]')) {
//         // 點擊的是cart-btn，執行相應的操作
//         const productId = target.getAttribute('data-product-id');
//         const isCart = target.getAttribute('data-cart') === 'true';

//         // 處理相應的購物車按鈕操作，例如新增或刪除購物車商品
//         if (isCart) {
//             // 處理刪除購物車商品的邏輯
//             console.log('Removing product from cart:', productId);
//             // 處理回傳資料庫的功能空間
//         } else {
//             // 處理新增購物車商品的邏輯
//             console.log('Adding product to cart:', productId);
//             // 處理回傳資料庫的功能空間
//         }

//         // 更新按鈕狀態
//         updateButtonState(target);
//     }
// });

// // 函數：更新按鈕狀態及 `<i>` 標籤內的 class
// function updateButtonState(btn) {
//     const heartIcon = btn.querySelector('i');

//     // 檢查按鈕的類型
//     if (btn.matches('[id^="favorite-btn"]')) {
//         // 如果是最愛按鈕，則切換 `<i>` 標籤內的 class
//         const isFavorite = btn.getAttribute('data-favorite') === 'true';
//         if (isFavorite) {
//             heartIcon.classList.remove('far');
//             heartIcon.classList.add('fas');
//         } else {
//             heartIcon.classList.remove('fas');
//             heartIcon.classList.add('far');
//         }
//     } else if (btn.matches('[id^="cart-btn"]')) {
//         // 如果是購物車按鈕，則切換 `<i>` 標籤內的 class
//         const isCart = btn.getAttribute('data-cart') === 'true';
//         if (isCart) {
//             heartIcon.classList.remove('fas', 'fa-shopping-cart');
//             heartIcon.classList.add('fas', 'fa-cart-plus');
//         } else {
//             heartIcon.classList.remove('fas', 'fa-cart-plus');
//             heartIcon.classList.add('fas', 'fa-shopping-cart');
//         }
//     }
// }

    </script>
</body>

</html>