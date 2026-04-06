<?php
	session_start();
	
	include '..\config\db_connection.php';
	
	if(!isset($_SESSION['user'])){
		header("Location:login.php");
		exit();
	}
		$result = $conn->query("SELECT * FROM product_data ORDER BY Product_Id DESC LIMIT 8");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Home page</title>
		<link rel="stylesheet" href="..\css file\Home page.css?v=1">
	</head>
	<body>
		<nav class="nav">
			<span class="title">E-com</span>
			
			<div class="search_div">
				<input type="text" id="search_input" name="search_input" placeholder="Search here what you want.">
				<button id="search_btn">Search</button>
			</div>
			<ul class="nav_ul">
				<li class="nav_li"><a href="" class="nav_a">Home</a></li>
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
		
			<!---- Filter div ----->
			<div class="filter_div">
				<span class="span_filter">Filter</span>
			</div>
			
			<!--------- product div --------->
			<div class="product_card_div">
			
				<?php while($row = $result->fetch_assoc()): ?>

				<div class="product_div">
					<div class="product_img_div">
						<img class="product_img" src="../products/<?php echo $row['Product_img']; ?>">
					</div>
				
					<div class="product_info_div">
						<label class="product_title_label">Title:</label>
						<span class="product_title_span">
							<?php echo $row['Product_name']; ?>
						</span>
						<br>

						<label class="product_price_label">Price:</label>
						<span class="product_price_span">
							₹<?php echo $row['Product_price']; ?>
						</span>
					</div>

					<div class="div_btn">
					
						<!-- Add to cart -->
						<form method="POST" action="cart_page.php">
							<input type="hidden" name="id" value="<?php echo $row['Product_Id']; ?>">
							<input type="hidden" name="name" value="<?php echo $row['Product_name']; ?>">
							<input type="hidden" name="price" value="<?php echo $row['Product_price']; ?>">
							<input type="hidden" name="img" value="<?php echo $row['Product_img']; ?>">
							
							<button type="submit" name="add_cart" id="add_cart">Add Cart</button>
						</form>
						
						
						<!-- View -->
						<a href="product view.php?id=<?php echo $row['Product_Id']; ?>">
							<button id="view">View</button>
						</a>
					</div>
				</div>

				<?php endwhile; ?>
				
			</div>
		</div>
	</body>
</html>