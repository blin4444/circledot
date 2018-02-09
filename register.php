<html>
<body>
<?php
	include 'db_utils.php';
	session_start();
	
	function register() {
		$mysqli =  blog_db_connect();
		
		
		if ($stmt = $mysqli->prepare("INSERT INTO User (uid, password) VALUES (?,?)")) {
			$hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
			
			$stmt->bind_param("ss", $_POST["username"], $hashedPassword);
			
			if($stmt->execute()) { // Error
				header('Location: ./');
			}
		}
		
		echo "Error";	
		$stmt->close();
	}
	
	if ($_POST["password"] == $_POST["password2"]) {
	
		register();
	} else {
		echo "Passwords don't match";
	}
	

?>

</body>
</html>