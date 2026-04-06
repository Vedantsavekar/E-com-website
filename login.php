<?php
	session_start();
	include '..\config\db_connection.php';
	
	$message="";
	$success = false;

	// ✅ Show message AFTER redirect//
	if(isset($_GET['msg']) && $_GET['msg'] == 0){
		$message = "You are not registred";
	}
	
	if(isset($_GET['msg']) && $_GET['msg'] == 1){
		$message = "Password is wrong";
	}
	
	if(isset($_GET['msg']) && $_GET['msg'] == 2){
		$message = "Login successful";
		$success = true;
	}
	
	//login logic
	if(isset($_POST['login'])){
		$email=trim($_POST['email']);
		$pass=trim($_POST['pass']);
		
		//Check email is correct or wrong
		$check=$conn->prepare("SELECT * FROM sign_up WHERE Email=?");
		$check->bind_param("s", $email);
		$check->execute();
		$result=$check->get_result();
		
		if($result->num_rows == 0){
			header("Location: login.php?msg=0");
			exit();
		}else{
			$user = $result->fetch_assoc();
			
			if(password_verify($pass, $user['Password'])){
				$_SESSION['user']=$user['Full_name'];
				header("Location: login.php?msg=2");
				exit();
			}else{
				header("Location: login.php?msg=1");
				exit();
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="..\css file\login.css?v=1">
	</head>
	<body>
		<?php if($message !== ""): ?>
			<div style="border: 1px solid black;
						padding: 5px 10px;
						border-radius: 8px;
						position: absolute;">
				<?php echo $message?>
			</div>
			
			<script>
				// redirect after 4 seconds
				setTimeout(function(){
					window.location.href = "Home page.php"; // change page here
				}, 3000);
			</script>
		<?php endif ?>
		<form method="POST">
			<fieldset>
				<legend>Login</legend>
				<table>
					<tr>
						<td><lable for="email">Email id:</lable></td>
						<td><input type="email" name="email" id="email" required></td>
					</tr>
					
					<tr>
						<td><lable for="pass">Password:</lable></td>
						<td><input type="password" name="pass" id="pass" required></td>
					</tr>
					
					<tr>
						<td colspan="2">
							<center>
								<button type="submit" name="login" id="login_btn">Login</button>
								<br>
								<span>
									If you have't account? <a href="..\html file\sign.php" class="signin_a">Sign in</a>
								</span>
							</center>
						</td>
					</tr>
				</table>
			</fieldset>
		</form>
	</body>
</html>