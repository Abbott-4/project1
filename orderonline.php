<?php

// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location:http://192.168.43.228/project/login.php");
    exit;
}


require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
			$itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["code"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["code"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Free Bootstrap Themes by Zerotheme dot com - Free Responsive Html5 Templates">
    <meta name="author" content="https://www.Zerotheme.com">
	
    <title>ChokoCake | Free Bootstrap Chocolate Templates</title>
	
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	
	<!-- Custom CSS -->
	<link href="css/style2.css" rel="stylesheet">
	
	<!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Owl Carousel Assets -->
    <link href="owl-carousel/owl.carousel.css" rel="stylesheet">
    <!-- <link href="owl-carousel/owl.theme.css" rel="stylesheet"> -->
	
	
	<link href="style.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" type="text/css" href="style1.css">
	
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


	



	<!-- jQuery and Modernizr-->
	<script src="js/jquery-2.1.1.js"></script>

	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="sub-page">
<div class="wrap-body">

	<header class="clearfix">
		
		<!--Navigation-->
		<nav id="menu" class="navbar">
			<div class="container">
				<div class="navbar-header"><!--<span id="heading" class="visible-xs">Categories</span>-->
				  <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
					<a class="navbar-brand" href="#">
						<img src="images/logo.jpg" width="250px"/>
					</a>
				</div>
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
						<li><a href="index.html">Home</a></li>
						<li><a href="aboutus.html">About Us</a></li>

						<li><a href="careers.html">Careers</a></li>
						<li><a href="orderonline.php">Order Online</a></li>

						<li><a href="contactus.html">Contact Us</a></li>
						<li><a href="register.php">Register</a></li>
					</ul>
				</div>
			</div>
		</nav>
		
		<!-- Static Header -->
		<div class="header-text">
			<div class="col-md-12 text-center">
				<br>
				<span>Order online</span>
				
			</div>
		</div><!-- /header-text -->
		
	</header>
	<!-- /Section: intro -->
	
	<!-- /////////////////////////////////////////Content -->
	<div id="page-content">
		<!-----------------Content-------------------->
		<div class="box-content"> 
			
				<div class="row">
					

				<a href="http://192.168.43.228/project
				/e1/index.php" class="btn btn-skin">List data</a>
<a href="logout.php" class="btn btn-skin">Sign Out of Your Account</a>
<div id="shopping-cart">
<div class="txt-heading">Shopping Cart</div>

<a id="btnEmpty" href="orderonline.php?action=empty">Empty Cart</a>
<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>	
<table class="tbl-cart" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="text-align:left;">Name</th>
<th style="text-align:left;">Code</th>
<th style="text-align:right;" width="5%">Quantity</th>
<th style="text-align:right;" width="10%">Unit Price</th>
<th style="text-align:right;" width="10%">Price</th>
<th style="text-align:center;" width="5%">Remove</th>
</tr>	
<?php		
    foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["quantity"]*$item["price"];
		?>
				<tr>
				<td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
				<td><?php echo $item["code"]; ?></td>
				<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
				<td  style="text-align:right;"><?php echo "$ ".$item["price"]; ?></td>
				<td  style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
				<td style="text-align:center;"><a href="orderonline.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
				</tr>
				<?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["price"]*$item["quantity"]);
		}
		?>

<tr>
<td colspan="2" align="right">Total:</td>
<td align="right"><?php echo $total_quantity; ?></td>
<td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
<td></td>
</tr>
</tbody>
</table>		
  <?php
} else {
?>
<div class="no-records">Your Cart is Empty</div>
<?php 
}
?>
</div>

<div id="product-grid">
	<div class="txt-heading">Products</div>
	<?php
	$product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY id ASC");
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
		<div class="product-item">
			<form method="post" action="orderonline.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
			<div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
			<div class="product-tile-footer">
			<div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
			<div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
			<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
			<div> id=<?php echo  $product_array[$key]["id"]; ?></div> 
		   <div> <a href="http://localhost"
           target="popup"
           onclick="window.open('get-product-info.php?id=<?php echo $product_array[$key]["id"] ; ?>','popup','width=400,height=400');return false;">
           Open Link in Popup</a></div>
		</div>
			</form>
		</div>
	<?php
		}
	}
	?>
</div>



			</div>
		</div>
		
	</div>
		
	<footer id="footer">
		<div class="wrap-footer">
			<div class="container">
				<div class="row"> 
					<div class="col-footer footer-1 col-md-3">
						<h2 class="footer-title">About Us</h2>
						<div class="footer-content">
							The Luca’s bread offers a large amount of choice and high quality of Sourdough Bread and Desserts. We lovingly make a fine selection of delicious and special breads, sandwiches and other desserts in our Bakery. We also have many types of drinks and several combos.  <br> <br> 
							We are trying to focus on the culture thing and healthy diet.
						</div>
					</div> 
					<div class="col-footer footer-2 col-md-3">
						<h2 class="footer-title">Recent Posts</h2>
						<div class="footer-content">
							<ul>
								<li><a href="#">Origin of Luca's Loaves</a></li>
								<li><a href="#">How to make good bread</a></li>
								<li><a href="#">Nine popular breads you might choose</a></li>
								<li><a href="#">New types of bread are expected to be introduced</a></li>
							</ul>
						</div>
					</div>
					<div class="col-footer footer-3 col-md-3">
						<h2 class="footer-title">OUR FLICKR</h2>
						<div class="footer-content">
							<div class="row">
							<div class="col-md-4">
									<a href="#"><img src="images/1footer.jpg" /></a>
									<a href="#"><img src="images/2footer.jpg" /></a>
									<a href="#"><img src="images/3footer.jpg" /></a>
								</div>
								<div class="col-md-4">
									<a href="#"><img src="images/4footer.jpg" /></a>
									<a href="#"><img src="images/5footer.jpg" /></a>
									<a href="#"><img src="images/6footer.jpg" /></a>
								</div>
								<div class="col-md-4">
									<a href="#"><img src="images/7footer.jpg" /></a>
									<a href="#"><img src="images/8footer.jpg" /></a>
									<a href="#"><img src="images/9footer.jpg" /></a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-footer footer-4 col-md-3">
						<h2 class="footer-title">Tag Cloud</h2>
						<div class="footer-content">
							<a href="#">animals</a>
							<a href="#">cooking</a>
							<a href="#">countries</a>
							<a href="#">city</a>
							<a href="#">children</a>
							<a href="#">home</a>
							<a href="#">likes</a>
							<a href="#">photo</a>
							<a href="#">link</a>
							<a href="#">law</a>
							<a href="#">shopping</a>
							<a href="#">skate</a>
							<a href="#">scholl</a>
							<a href="#">video</a>
							<a href="#">travel</a>
							<a href="#">images</a>
							<a href="#">love</a>
							<a href="#">lists</a>
							<a href="#">makeup</a>
							<a href="#">media</a>
							<a href="#">password</a>
							<a href="#">pagination</a>
							<a href="#">wildlife</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bottom-footer">
			<div class="container">
				<div class="copyright text-center">
					<span>20ITA2 design by Abbott(Lin Jixiang)</span>
				</div>
			</div>
		</div> 
	</footer>
	
	<!-- JS -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>

</div>
</body>
</html>