<html>
<body>
<?php
	include 'db_utils.php';
	session_start();
	function checkLogin() {
		$user = $_POST['username'];
		$pass = $_POST['password'];
	
		$mysqli = blog_db_connect();
		  
		if ($stmt = $mysqli->prepare("SELECT password FROM User WHERE uid=?")) {
			$stmt->bind_param("s", $user);
			
			if($stmt->execute()) { // Error
				$stmt->bind_result($hashedPassword);

				if ($stmt->fetch()) {
					if (password_verify($pass, $hashedPassword)) {
						$_SESSION['username'] = $user;
						$_SESSION['login'] = true;
						echo "Successful login";
						$stmt->close();
						$mysqli->close();
						
						// Redirect to main page (customer/index.php)
						header('Location: ./');
						die();
					}

				}
				
			}

			echo "Invalid user ID or password.";
			$_SESSION['login'] = false;
			$_SESSION['username'] = null;
			$stmt->close();
			$mysqli->close();
		} else {
			echo "Error";
		}
		
	}
	
	checkLogin();
	

$_SESSION["username"] = $_POST["username"];
?>

</body>
</html>