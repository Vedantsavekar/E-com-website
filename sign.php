<?php
	include '..\config\db_connection.php';

	$message="";
	
	// ✅ Show message AFTER redirect
	if(isset($_GET['msg']) && $_GET['msg'] == 1){
		$message = "sign in successful";
	}
	
	if(isset($_GET['msg']) && $_GET['msg'] == 0){
		$message = "You are already registered";
	}
	
	//when click sign in btn run this code
	if(isset($_POST['sign'])){
		
		//Check Dublicate phone and email.
		$phone=$_POST['phone'];
		$email=$_POST['email'];
		
		//write sql query
		$check=$conn->prepare("SELECT id FROM sign_up WHERE Phone_no = ? or email = ?");
		$check->bind_param("ss", $phone, $email);
		$check->execute();
		$result=$check->get_result();
		
		if($result->num_rows > 0){
			header("Location: sign.php?msg=0");
			exit();
		}else{
			$name=$_POST['name'];
			$phone=$_POST['phone'];
			$age=$_POST['age'];
			$gender=$_POST['gender'];
			$email=$_POST['email'];
			$pass=$_POST['pass'];
			$passhash=password_hash($pass, PASSWORD_DEFAULT);
		
			$stmt=$conn->prepare("INSERT into sign_up(Full_name, Phone_no, Age, Gender, Email, Password) VALUES (?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssss", $name, $phone, $age, $gender, $email, $passhash);
			if($stmt->execute()){
				header("Location: sign.php?msg=1");
				exit();
			}
		}
	}
?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Sign in</title>
		<link rel="stylesheet" href="..\css file\login.css?v=1">
	</head>
	<body>
		<?php if($message !== ""): ?>
			<div style="border: 1px solid black;
						padding: 5px 10px;
						border-radius: 8px;">
				<?php 
					echo $message;
				?>
			</div>
		
			<script>
				// redirect after 4 seconds
				setTimeout(function(){
					window.location.href = "login.php"; // change page here
				}, 3000);
			</script>
		<?php endif; ?>
		<form method="POST">
			<fieldset>
				<legend>Sign in</legend>
				<table>
					<tr>
						<td><label for="name">Name:</label></td>
						<td><input type="text" name="name" id="name" required></td>
					</tr>
            
					<tr>
						<td><label for="phone">Phone no:</label></td>
						<td><input type="text" name="phone" id="phone" required></td>
					</tr>
            
					<tr>
						<td><label for="age">Age:</label></td>
						<td><input type="text" name="age" id="age" required></td>
					</tr>
            
					<tr>
						<td><label>Gender:</label></td>
						<td>
							<input type="radio" name="gender" value="Male" required> <label>Male</label>
							<input type="radio" name="gender" value="Female"> <label>Female</label>
						</td>
					</tr>
            
					<tr>
						<td><label for="email">Email id:</label></td>
						<td><input type="email" name="email" id="email" required></td>
					</tr>
            
					<tr>
						<td><label for="pass">Password:</label></td>
						<td><input type="password" name="pass" id="pass" required></td>
					</tr>
            
					<tr>
						<td colspan="2">
							<center>
								<button type="submit" name="sign" id="sign_btn">Sign in</button>
								<br>
								<span>
									If you have account? 
									<a href="../html file/login.php" class="login_a">Login</a>
								</span>
							</center>
						</td>
					</tr>
				</table>
			</fieldset>
	</form>
</body>
</html>