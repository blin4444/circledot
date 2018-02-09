<!DOCTYPE html>
<html>
	<head>
        <title>
						Passwords
						</title>
					</head>
				<body>
<?php
	$post_id = 0;
	$user_id = "";
	
	$isByPost = isset($_GET["post"]);
	if ($isByPost) {
		$post_id = $_GET["post"];
	}
	
	$isByUser = isset($_GET["user"]);
	if ($isByUser) {
		$user_id = $_GET["user"];
	}
	
	include 'db_utils.php';
	session_start();
	$isSuccess = false;
	$error = "";
	
	$date = null;
	$post = "";
	$title = "";
	$uid = "";

	$topTitle = "";
	
	//function viewPost($post_id) {
		$mysqli =  blog_db_connect();
				
			$statement = "SELECT uid, password FROM User";
		
		
		if ($stmt = $mysqli->prepare($statement)) {
				if ($stmt->execute()) {
                    $stmt->bind_result($uid, $password);
					?>
				
					
					<h3>
						<?php
							echo $topTitle;
						?>
					</h3>
					<?php
						
					$postCount = 0;	
						
					while ($stmt->fetch()) {
                        ++$postCount;
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);                        
                        echo "$uid, $password, $hashedPassword<br />";						
						?>
									
						<?php
					}
	
				} else {
					$error = "did not execute";
				}
			?>
			
				
			<?php 
			
		} else {
			$error = "fail to prepare";
		}
		
	
?>
		
<?php

	$stmt->close();
	$mysqli->close();
?>

		<hr />
		<div>
			<p>
				<a href="./">Home</a><br />				
				<small>
					&copy; 2018 CircleDot, LLC.
				</small>
			</p>
		</div>

	</body>								
</html>