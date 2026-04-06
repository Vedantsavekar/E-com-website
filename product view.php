<?php
	session_start();
	include '..\config\db_connection.php';
	
	if(!isset($_GET['id'])){
		echo "Product not found";
		exit();
	}

	$id = $_GET['id'];
	
	$stmt = $conn->prepare("SELECT * FROM product_data WHERE Product_Id = ?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$result = $stmt->get_result();

	$product = $result->fetch_assoc();
	
	if(!$product){
		echo "Product not found";
		exit();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Product view</title>
		<link rel="stylesheet" href="..\css file\product view.css?v=1">
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
			<div class="product_div">
				<div class="product_img_div">
					<img class="product_img" src="../products/<?php echo $product['Product_img']; ?>">
				</div>
				<div class="div_btn">
					<form method="POST" action="cart_page.php">
						<input type="hidden" name="id" value="<?php echo $product['Product_Id']; ?>">
						<input type="hidden" name="name" value="<?php echo $product['Product_name']; ?>">
						<input type="hidden" name="price" value="<?php echo $product['Product_price']; ?>">
						<input type="hidden" name="img" value="<?php echo $product['Product_img']; ?>">
							
						<button type="submit" name="add_cart" id="add_cart_btn">Add Cart</button>
					</form>
				</div>
			</div>
			
			<div class="product_div0">
				<div class="product_info_div">
					<label class="product_title_label">Title:</label>
					<span class="product_title_span">
						<?php echo $product['Product_name']; ?>
					</span>
					<br>

					<label class="product_price_label">Price:</label>
					<span class="product_price_span">
						₹<?php echo $product['Product_price']; ?>
					</span>
				</div>
				
				<div class="product_description_div">
					<label class="product_description_label">Description:</label>
					<br>
					<span class="product_description_span">
						<?php echo $product['Product_description']; ?>
					</span>
				</div>
			</div>
		</div>
	</body>
</html>