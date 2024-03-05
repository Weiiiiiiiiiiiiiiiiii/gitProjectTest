function getorder(type) {
    $('.removecss').css('border-bottom', '0');
    $('.addcss' + type).css("border-bottom", "1px solid black");
    var casevalue = type;
    $('#order').remove();
    $('#adddiv').append("<div id='order'></div>");

    // var currentUrl = window.location.href;

    // currentUrl = currentUrl.replace(/[?&]type=[^&]*(&|$|\?)/g, '');

    // 如果不存在，添加參數到網址
    // var newUrl = currentUrl + (currentUrl.indexOf('?') !== -1 ? '&' : '?') + "type="+type;

    // 使用 HTML5 History API 的 pushState 來更改網址，不引起頁面重新載入
    // history.pushState(null, null, newUrl);
    $.ajax({
        type: 'POST',
        data: {
            case: casevalue,
        },
        url: 'getorder.php',
        success:
            function (result) {
                $("#order").html(result);

            }
    })
}

function deleteOrder(delid, aftercase) {
    if (confirm("確定刪除編號為" + delid + "的訂單嗎?")) {
        $.ajax({
            type: 'POST',
            data: {
                delid: delid,
            },
            url: 'getorder.php',
            success:
                function (result) {
                    if (result === "ok") {
                        alert("已刪除編號為" + delid + "訂單!")
                        getorder(aftercase);
                    }
                },
        })
    }
    // console.log('Before removal:', $('.orderid' + id).length);
    // console.log('After removal:', $('.orderid' + id).length);
    //     setTimeout(() => {
    //         console.log("5");
    //         $('#order'+id).remove();
    //         $('#adddiv').append("<div id='order'></div>");
    //         $.ajax({
    //             type: 'POST',
    //             data: {
    //                 case: casevalue
    //             },
    //             url: 'getorder.php',
    //             success:
    //                 function (result) {
    //                     $("#order").html(result);
    //                 }
    //         })
    //  }, 100)
}

function orderdetail(orderid, ordertype, waitpay) {
    $.ajax({
        type: 'POST',
        data: {
            id: orderid,
            ordertype: ordertype,
            waitpay: waitpay,
        },
        url: 'getorder.php',
        success:
            function (result) {
                $('#order').remove();
                $('#adddiv').append("<div id='order'></div>");
                $("#order").html(result);
                window.scrollTo(0, 0);
            }
    })
}