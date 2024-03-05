<?php
include "conn.php";
$search = isset($_POST['search']) ?$_POST['search']: "";
$user_id = isset($_SESSION['user_id']) ?$_SESSION['user_id']: 0;

if($search == ""){

    $sql="SELECT p.product_id, p.product_name, p.product_content, p.product_type1, p.product_type2, p.product_type3,
    CASE WHEN f.user_id IS NOT NULL THEN 1 ELSE 0 END AS 'favorite',
    CASE WHEN c.user_id IS NOT NULL THEN 1 ELSE 0 END AS 'carts',
    p.product_price,
    p.product_img_1
    FROM product p
    LEFT JOIN favorite f ON p.product_id = f.product_id AND f.user_id = '".$user_id."'
    LEFT JOIN carts c ON p.product_id = c.product_id AND c.user_id = '".$user_id."'
    GROUP BY p.product_id
    ORDER BY p.product_id";
    //'".$user_id."'
}else{
    $sql="SELECT p.product_id, p.product_name, p.product_content, p.product_type1, p.product_type2, p.product_type3,
    CASE WHEN f.user_id IS NOT NULL THEN 1 ELSE 0 END AS 'favorite',
    CASE WHEN c.user_id IS NOT NULL THEN 1 ELSE 0 END AS 'carts',
    p.product_price,
    p.product_img_1
    FROM product p
    LEFT JOIN favorite f ON p.product_id = f.product_id AND f.user_id = '".$user_id."'
    LEFT JOIN carts c ON p.product_id = c.product_id AND c.user_id = '".$user_id."'
    WHERE `product_name` LIKE '%".$search."%' or `product_content` LIKE '%".$search."%'
    GROUP BY p.product_id
    ORDER BY p.product_id";
}

$product_search_result = mysqli_query($conn, $sql);

if ($product_search_result) {
    if (mysqli_num_rows($product_search_result) > 0) {
        while ($row = mysqli_fetch_array($product_search_result)) {
        //     echo ("<div class=\"shopitem mt-3 mb-3\">\n");
        //     echo ("<div class=\"lead text-center\">" . $row["product_name"] . "</div>\n<div>" . $row["product_content"] . "</div>\n");
        //     echo ("<a href=\"./product/pdtdetail.php?prid=". $row["product_id"] ."\">");
        //     echo ("<img class=\"item img-thumbnail\" src=\"" . "http://" . $row["product_img_1"] . "\">\n");
        //     echo ("</a>");
        //     //echo ("<img class=\"item img-thumbnail\" src=\"" . "http://" . $row["product_img_2"] . "\">\n");
        //     //echo ("<img class=\"item img-thumbnail\" src=\"" . "http://" . $row["product_img_3"] . "\">\n");
        //     echo ("<div class=\"pt-3 pb-3\">" . $row['product_price'] . ",NTD</div>\n");
        //     if($row['carts']==0){
        //         echo("<button type=\"button\" class=\"btn btn-primary\" data-bs-toggle=\"button\" autocomplete=\"off\" onclick=\"addcart(".$row["product_id"].")\">\n");
        //         echo("<span id=\"".$row["product_id"]."\"span".">新增購物車</span>");
        //         echo("</button>\n");
        //     }else{
        //         echo("<button type=\"button\" class=\"btn btn-primary actice\"  data-bs-toggle=\"button\" autocomplete=\"off\" onclick=\"cartdel(".$row["product_id"].")\">\n");
        //         echo("<span id=\"".$row["product_id"]."\"span".">已加入購物車</span>");
        //         echo("</button>\n");
        //     }
        //     if($row['favorite']==0){
        //         echo("<button type=\"button\" class=\"btn btn-primary\" data-bs-toggle=\"button\" autocomplete=\"off\" onclick=\"addfav(".$row["product_id"].")>\n");
        //         echo("<span id=\"".$row["product_id"]."\"span".">新增購物車</span>");
        //         echo("</button>\n");
        //     }else{
        //         echo("<button type=\"button\" class=\"btn btn-primary actice\"  data-bs-toggle=\"button\" autocomplete=\"off\" onclick=\"favdel(".$row["product_id"].")\">\n");
        //         echo("<span id=\"".$row["product_id"]."\"span".">已加入我的最愛</span>");
        //         echo("</button>\n");
        //     }
            
         }
    } else {
        echo ("<div class=\"shopitem mt-3 mb-3\">\n");
        echo ("<h4>沒有符合您的搜尋結果</h4>");
        echo ("</div>\n");
    }
}else{
echo ("<div class=\"shopitem mt-3 mb-3\">\n");
echo ("<h4>沒有符合您的搜尋結果</h4>");
echo ("</div>\n");
}
$conn->close();
?>