<?php
	session_start();

	// ✅ create cart if not exist
	if(!isset($_SESSION['cart'])){
		$_SESSION['cart'] = [];
	}

	// ✅ ADD TO CART
	if(isset($_POST['add_cart'])){
		$id = $_POST['id'];

		if(isset($_SESSION['cart'][$id])){
			$_SESSION['cart'][$id]['qty']++;
		} else {
			$_SESSION['cart'][$id] = [
				"name" => $_POST['name'],
				"price" => $_POST['price'],
				"img" => $_POST['img'],
				"qty" => 1
			];
		}
		
		header("Location: cart_page.php");
		exit();
	}

	// ✅ DELETE
	if(isset($_GET['del'])){
		unset($_SESSION['cart'][$_GET['del']]);
	}

	// ✅ INCREMENT
	if(isset($_GET['inc'])){
		$_SESSION['cart'][$_GET['inc']]['qty']++;
	}

	// ✅ DECREMENT
	if(isset($_GET['dec'])){
		$id = $_GET['dec'];
		$_SESSION['cart'][$id]['qty']--;

		if($_SESSION['cart'][$id]['qty'] <= 0){
			unset($_SESSION['cart'][$id]);
		}
		
		header("Location: cart_page.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Cart page</title>
		<link rel="stylesheet" href="..\css file\cart page.css?v=1">
	</head>
	<body>
		<nav class="nav">
			<span class="title">E-com</span>
			
			<div class="search_div">
				<input type="text" id="search_input" name="search_input" placeholder="Search here what you want.">
				<button id="search_btn">Search</button>
			</div>
			<ul class="nav_ul">
				<li class="nav_li"><a href="Home page.php" class="nav_a">Home</a></li>
				<li class="nav_li"><a href="" class="nav_a">Shop</a></li>
				<li class="nav_li"><a href="cart_page.php" class="nav_a">Cart</a></li>
				<li class="nav_li"><a href="" class="nav_a">About</a></li>
				<li class="nav_profile_li">
					<a href="" class="nav_a">Profile</a>
					<div class="profile_div">
						<ul class="profile_ul">
							<li class="profile_li"><?php echo isset($_SESSION['user']) ? $_SESSION['user'] : 'Guest'; ?><br><a href="#" class="profile_a">Account</a></li>
							<li class="profile_li"><a href="#" class="profile_a">My Orders</a></li>
							<div class="div_btn">
								<button id="login_btn"><a href="..\html file\login.php" class="profile_a">Login</a></button>
								<button id="logout_btn"><a href="logout.php" class="profile_a">Logout</a></button>
							</div>
						</ul>
					</div>
				</li>
			</ul>
		</nav>
		
		<div class="div">
			<div class="product_detail_div">
				<span class="productdetails_span">Product details</span>
				
				<div class="product_list_div">
					<?php
						$total_price = 0;
						$total_products = 0;

						if(empty($_SESSION['cart'])){
							echo "<p>Your cart is empty</p>";
						}

						foreach($_SESSION['cart'] as $id => $item):
							$subtotal = (float)$item['price'] * (int)$item['qty'];
							$total_price += $subtotal;
							$total_products += $item['qty'];
					?>
					<div class="product_div">
						
						<div class="img_div">
							<img src="../products/<?php echo $item['img']; ?>" class="product_img">
						</div>
						<div class="product_info_div">
							<label class="product_title_label">Title:</label>
							<span class="product_title_span">
								<?php echo $item['name']; ?>
							</span>
							<br>

							<label class="product_price_label">Price:</label>
							<span class="product_price_span">
								₹<?php echo $item['price']; ?>
							</span>
							<br>
							
							
							<a href="cart_page.php?del=<?php echo $id; ?>">
								<button id="delete_btn">Delete</button>
							</a>
						</div>
						<div class="product_incrimentdecriment_btn_div">
							<a href="cart_page.php?inc=<?php echo $id; ?>"><button id="increment_btn">+</button></a>
							<input id="qty_input" type="text" value="<?php echo $item['qty']; ?>" readonly>
							<a href="cart_page.php?dec=<?php echo $id; ?>"><button id="decriment_btn">-</button></a>
						</div>
						
					</div>
					<?php endforeach; ?>
				</div>
			</div>
			
			<div class="product_price_div">
				<span class="pricedetails_span">Price details</span>
				<br>
				<hr>
				<label class="total_product_label">Total products:</label>
				<span class="total_product_span"><?php echo $total_products; ?></span>
				<br>
				<label class="totalprice_label">Total price:</label>
				<span class="totalprice_span">₹<?php echo $total_price; ?></span>
				<hr>
				<br>
				<button id="next_btn">Next</button>
			</div>
		</div>
	</body>
</html>