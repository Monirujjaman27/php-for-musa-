<!DOCTYPE html>
<html lang="en">
<head>
	<title>Home</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./fonts/linearicons-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="./vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="./vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./vendor/slick/slick.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./vendor/MagnificPopup/magnific-popup.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="./css/util.css">
	<link rel="stylesheet" type="text/css" href="./css/main.css">
<!--===============================================================================================-->
</head>
<body class="animsition">


<?php include 'includes/session.php'; ?>
<?php

$database = mysqli_connect('localhost', 'root', '', 'ecomm');
$conn = $pdo->open();

$output = array('error'=>false);
if(isset($_GET['addnewctId'] )){

$id = base64_decode($_GET['addnewctId']);
$quantity = $_GET['quantity'] = 1;
$_SESSION['user'] = '1';
if(isset($_SESSION['user'])){
	$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM cart WHERE user_id=:user_id AND product_id=:product_id");
	$stmt->execute(['user_id'=>$user['id'], 'product_id'=>$id]);
	$row = $stmt->fetch();
	if($row['numrows'] < 1){
		try{
			$stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (1, $id,1)");
			$stmt->execute(['user_id'=>$user['id'], 'product_id'=>$id, 'quantity'=>$quantity]);
			$output['message'] = 'Item added to cart';
			
		}
		catch(PDOException $e){
			$output['error'] = true;
			$output['message'] = $e->getMessage();
		}
	}
	else{
		$output['error'] = true;
		$output['message'] = 'Product already in cart';
	}
}
else{
	if(!isset($_SESSION['cart'])){
		$_SESSION['cart'] = array();
	}

	$exist = array();

	foreach($_SESSION['cart'] as $row){
		array_push($exist, $row['productid']);
	}

	if(in_array($id, $exist)){
		$output['error'] = true;
		$output['message'] = 'Product already in cart';
	}
	else{
		$data['productid'] = $id;
		$data['quantity'] = $quantity;

		if(array_push($_SESSION['cart'], $data)){
			$output['message'] = 'Item added to cart';
		}
		else{
			$output['error'] = true;
			$output['message'] = 'Cannot add item to cart';
		}
	}

}
}


$cartQuary = "SELECT * FROM cart ";
$cartQuaryData = mysqli_query($database, $cartQuary);

if(isset($_GET['cart-clear'] )){
	$clearcart = "DELETE FROM cart"; 
	$cartQuaryData = mysqli_query($database, $clearcart);
	if($cartQuaryData){
		header("Location: index.php");
die();
	}
 }
?>

<header class="header-v4">
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						Free shipping for standard order over $100
					</div>

					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m trans-04 p-lr-25">
							Help & FAQs
						</a>

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							My Account
						</a>

						<a href="login.php" class="flex-c-m trans-04 p-lr-25">
							LOGIN
						</a>

						<a href="../Ecommerce-Site-PHP/ecommerce/signup.php" class="flex-c-m trans-04 p-lr-25">
							SINGUP
						</a>
					</div>
				</div>
			</div>

			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">
					
					<!-- Logo desktop -->		
					<a href="index.php" class="logo">
						<img src="images/icons/logo-01.png" alt="IMG-LOGO">
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'index.php') {
                                              echo 'active-menu';
                                            } ?>">
								<a href="index.php">Home</a>
								<ul class="sub-menu">
									<li><a href="index.html">Homepage 1</a></li>
									<li><a href="home-02.html">Homepage 2</a></li>
									<li><a href="home-03.html">Homepage 3</a></li>
								</ul>
							</li>

							<li class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'product.html') {
                                              echo 'active-menu';
                                            } ?>">
								<a href="product.html">Shop</a>
							</li>

							<li class="label1" data-label1="hot">
								<a href="shoping-cart.html">Features</a>
							</li>

							<li class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'blog.php') {
                                              echo 'active-menu';
                                            } ?>">
								<a href="blog.php">Blog</a>
							</li>

							<li class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'about.php') {
                                              echo 'active-menu';
                                            } ?>">
								<a href="about.php">About</a>
							</li>

							<li class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'contact.php') {
                                              echo 'active-menu';
                                            } ?>">
								<a href="contact.php">Contact</a>
							</li>
						</ul>
					</div>	

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>

<?php
						if ($cartQuaryData && mysqli_num_rows($cartQuaryData) > 0) {
?>
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11  icon-header-noti js-show-cart" data-notify="<?= mysqli_num_rows($cartQuaryData); ?>">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>
						<?php
						}else
						
						?>
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11  js-show-cart" >
						<i class="zmdi zmdi-shopping-cart"></i>
						</div>
						<?php
					
?>

						<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti">
							<i class="zmdi zmdi-favorite-outline"></i><sup  id="sup"></sup>
						</a>
					</div>
				</nav>
			</div>	
		</div>	

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->		
			<div class="logo-mobile">
				<a href="index.html"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>

				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="2">
					<i class="zmdi zmdi-shopping-cart"></i>
				</div>

				<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="0">
					<i class="zmdi zmdi-favorite-outline"></i>
				</a>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile">
				<li>
					<div class="left-top-bar">
						Free shipping for standard order over $100
					</div>
				</li>

				<li>
					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m p-lr-10 trans-04">
							Help & FAQs
						</a>

						<a href="" class="flex-c-m p-lr-10 trans-04">
							My Account
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							LOGIN
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							SINGUP
						</a>
					</div>
				</li>
			</ul>

			<ul class="main-menu-m">
				<li>
					<a href="index.html">Home</a>
					<ul class="sub-menu-m">
						<li><a href="index.html">Homepage 1</a></li>
						<li><a href="home-02.html">Homepage 2</a></li>
						<li><a href="home-03.html">Homepage 3</a></li>
					</ul>
					<span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
				</li>

				<li>
					<a href="product.html">Shop</a>
				</li>

				<li>
					<a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a>
				</li>

				<li>
					<a href="blog.html">Blog</a>
				</li>

				<li>
					<a href="about.html">About</a>
				</li>

				<li>
					<a href="contact.html">Contact</a>
				</li>
			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="images/icons/icon-close2.png" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search...">
				</form>
			</div>
		</div>
	</header>

	<!-- Cart -->
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Your Cart
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>
			
			<div class="header-cart-content flex-w js-pscroll">
				<ul class="header-cart-wrapitem w-full">
					<?php
				if (mysqli_num_rows($cartQuaryData) > 0) {
							   foreach ($cartQuaryData as $cartItem) {
?>	
<?php 
$proCartId = $cartItem['product_id'];
$CartSinglequary= "SELECT* FROM products WHERE id = '$proCartId'";
$quaryData = mysqli_query($database, $CartSinglequary);

?>

	<?php						if (mysqli_num_rows($quaryData) > 0) {
							   foreach ($quaryData as $procartItem) {
								   ?>
				<li class="header-cart-item flex-w flex-t m-b-12">
						<div class="header-cart-item-img">
							<img src="images/<?= $procartItem['photo'];?>" alt="IMG">
						</div>
						<div class="header-cart-item-txt p-t-8">
							<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
								   <?= $procartItem['name'];?>
								 
	
							</a>

							<span class="header-cart-item-info">
							<?= $cartItem['quantity'];?> x <?= $procartItem['price'];?>
							</span>
						</div>
					</li>
			<?php   } } ?>
			<?php   } } ?>
				</ul>
				
				<div class="w-full">
					<div class="header-cart-total w-full p-tb-40">
						Total: $75.00
					</div>

					<div class="header-cart-buttons flex-w w-full">
						<a href="?cart-clear=clear" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
							Clear Cart
						</a>

						<a href="checkout.php" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
							Check Out
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>