<html>
<body>
<?php
	include 'db_utils.php';
	session_start();
	
	function blogPost($isEdit) {
		$mysqli =  blog_db_connect();
		
		$statement = "";
		if ($isEdit) {
			$statement = "UPDATE BlogEntry SET title = ?, post = ? WHERE id = ? AND uid = ?";			
		} else {
			$statement = "INSERT INTO BlogEntry (uid, date, title, post) VALUES (?,NOW(),?,?)";
		}

		if ($stmt = $mysqli->prepare($statement)) {
			if ($isEdit) {
				$stmt->bind_param("ssis", $_POST["title"], $_POST["post"], intval($_POST["id"]), $_SESSION["username"]);
			} else {
				$stmt->bind_param("sss", $_SESSION["username"], $_POST["title"], $_POST["post"]);				
			}
			
			if($stmt->execute()) { // Error
				header('Location: ./');
			} else {
				echo 'Failed to execute statement';
			}

			$stmt->close();
		}
		
		echo "Error";	
	}
	
	blogPost(isset($_POST["id"]));
?>

</body>
</html>