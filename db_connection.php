<?php
	$conn=new mysqli("localhost", "root", "", "e-commerce_web");
	
	if(!$conn){
		echo "database not connected";
	}
?>