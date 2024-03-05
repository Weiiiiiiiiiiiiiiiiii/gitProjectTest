<!DOCTYPE html>
<html lang="en">

<head>
	<title>MY Cart</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- icon -->
	<link rel="apple-touch-icon" href="assets/img/apple-icon.png">
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

	<!-- start css -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/templatemo.css">
	<link rel="stylesheet" href="assets/css/custom.css">
	<link rel="stylesheet" href="cart.css">

	<!-- Load fonts style after rendering the layout styles -->
	<link rel="stylesheet" href="assets/css/fontRobotocss2.css">
	<link rel="stylesheet" href="assets/css/fontawesome.min.css">

	<!-- start script -->
	<script src="assets/js/jquery-1.11.0.min.js"></script>
	<script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/templatemo.js"></script>
	<script src="assets/js/custom.js"></script>

	<!-- start function -->
	<script>
		$(document).ready(
			function() {
				$.ajax({
					url: "./cartlist.php",
					type: "post",
					success: function(data) {
						$("#cart_content").append(data);
						console.log("success");
					}
				});
			}
		)

		function delCart(user_id, product_id, product_name) {
			// 測試function
			// console.log(user_id);
			if (confirm("確定將" + product_name + "移除出您的購物車嗎?")) {
				$.ajax({
					url: "./cartedit.php",
					type: "post",
					data: {
						type: "del",
						user_id: user_id,
						product_id: product_id,
					},
					success: function(delcart) {
						if (delcart === "OK") {
							alert("刪除成功");
							const cartname = "#cartname" + product_id;
							$(cartname).remove();
						} else {
							alert("刪除失敗");
						}
					}
				});
			}
		}

		function editCartNum(user_id, product_id, product_price) {

			const cartnum = "#cartnum" + product_id;
			const new_cartnum = $(cartnum).val();

			const cartnumtotal = "#cartnumtotal" + product_id;
			const new_cartnumtotal = parseInt(product_price,10) * parseInt(new_cartnum,10);

			console.log(cartnumtotal);
			// div元素要用text替換內容值
			$(cartnumtotal).text(new_cartnumtotal);

			
			// 測試function修改
			// console.log(new_cartnum);

			$.ajax({
				url: "./cartedit.php",
				type: "post",
				data: {
					type: "numedit",
					user_id: user_id,
					product_id: product_id,
					new_cartnum: new_cartnum,
				},
				success: function(numedit) {
					if (numedit === "OK") {
						// 測試後端功能
						// alert("修改成功");
						$(cartnum).val(new_cartnum);
					} else {
						// 測試後端功能
						// alert("修改失敗");
					}
				}
			});
			
		}
	</script>

</head>

<body class="goto-here">
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

	<div class="hero-wrap hero-bread">
		<div class="container">
			<div class="row no-gutters slider-text align-items-center justify-content-center">
				<div class="col-md-9 ftco-animate text-center">
					<!-- <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Cart</span></p> -->
					<br>
					<h1 class="mb-0 bread">My Cart</h1>
				</div>
			</div>
		</div>
	</div>

	<section class="ftco-section ftco-cart">
		<div class="container">
			<div class="row row-cols-7">
				<div class="col-1 cart-list-title"></div>
				<div class="col-1 cart-list-title"></div>
				<div class="col-1 cart-list-title">圖片</div>
				<div class="col-4 cart-list-title">名稱</div>
				<div class="col-2 cart-list-title">單價</div>
				<div class="col-1 cart-list-title">數量</div>
				<div class="col-2 cart-list-title">總價</div>
			</div>
			<hr>
		</div>

		<form id="cart_content">
		</form>

	</section>

	<section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
		<!-- <div class="container py-4">
        <div class="row d-flex justify-content-center py-5">
          <div class="col-md-6">
          	<h2 style="font-size: 22px;" class="mb-0">Subcribe to our Newsletter</h2>
          	<span>Get e-mail updates about our latest shops and special offers</span>
          </div>
          <div class="col-md-6 d-flex align-items-center">
            <form action="#" class="subscribe-form">
              <div class="form-group d-flex">
                <input type="text" class="form-control" placeholder="Enter email address">
                <input type="submit" value="Subscribe" class="submit px-3">
              </div>
            </form>
          </div>
        </div>
      </div> -->
	</section>
	<footer class="ftco-footer ftco-section">
		<!-- Start Footer -->
		<?php
		include_once "footer.php"
		?>
		<!-- End Footer -->
		<!-- <div class="container">
      	<div class="row">
      		<div class="mouse">
						<a href="#" class="mouse-icon">
							<div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
						</a>
					</div>
      	</div>
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Vegefoods</h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Menu</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">Shop</a></li>
                <li><a href="#" class="py-2 d-block">About</a></li>
                <li><a href="#" class="py-2 d-block">Journal</a></li>
                <li><a href="#" class="py-2 d-block">Contact Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Help</h2>
              <div class="d-flex">
	              <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
	                <li><a href="#" class="py-2 d-block">Shipping Information</a></li>
	                <li><a href="#" class="py-2 d-block">Returns &amp; Exchange</a></li>
	                <li><a href="#" class="py-2 d-block">Terms &amp; Conditions</a></li>
	                <li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
	              </ul>
	              <ul class="list-unstyled">
	                <li><a href="#" class="py-2 d-block">FAQs</a></li>
	                <li><a href="#" class="py-2 d-block">Contact</a></li>
	              </ul>
	            </div>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p> Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
		<!-- Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a> -->
		<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
		<!--</p>
          </div>
        </div>
      </div> -->
	</footer>



	<!-- loader -->
	<!-- <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div> -->


	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-migrate-3.0.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<script src="js/jquery.waypoints.min.js"></script>
	<script src="js/jquery.stellar.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/aos.js"></script>
	<script src="js/jquery.animateNumber.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/scrollax.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
	<script src="js/google-map.js"></script>
	<script src="js/main.js"></script>

	<script>
		$(document).ready(function() {

			var quantitiy = 0;
			$('.quantity-right-plus').click(function(e) {

				// Stop acting like a button
				e.preventDefault();
				// Get the field name
				var quantity = parseInt($('#quantity').val());

				// If is not undefined

				$('#quantity').val(quantity + 1);


				// Increment

			});

			$('.quantity-left-minus').click(function(e) {
				// Stop acting like a button
				e.preventDefault();
				// Get the field name
				var quantity = parseInt($('#quantity').val());

				// If is not undefined

				// Increment
				if (quantity > 0) {
					$('#quantity').val(quantity - 1);
				}
			});

		});
	</script>

</body>

</html>