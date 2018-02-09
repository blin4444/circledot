<!DOCTYPE html>
<html>
	<head>
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
		
		$statement = "";
		
		
		
		if ($isByPost) {
			$statement = "SELECT uid, date, title, post FROM BlogEntry WHERE id = ?";
		} else {
			$statement = "SELECT uid, date, title, post FROM BlogEntry WHERE uid = ? ORDER BY date desc";
		}
		
		
		if ($stmt = $mysqli->prepare($statement)) {
			if ($isByPost) {
				$numPostId = intval($post_id);
				$stmt->bind_param("i", $numPostId);
			} else {
				$stmt->bind_param("s", $user_id);
			}
		
				
				
				if ($stmt->execute()) {
					$stmt->store_result();
					$stmt->bind_result($uid, $date, $title, $post);
					
					if ($isByPost) {					
						$pageTitle = "CircleDot";
						$topTitle = $pageTitle;
					} else {
						$pageTitle = "Posts by $user_id";
						$topTitle = "$pageTitle on <a href='./'>CircleDot</a>";
					}
					
					?>
					
						<title>
							<?php
								echo htmlspecialchars($pageTitle) . ' &ndash; CircleDot';
							?>
						</title>
					</head>
				<body>
					
					<h3>
						<?php
							echo $topTitle;
						?>
					</h3>
					<?php
						
					$postCount = 0;	
						
					while ($stmt->fetch()) {
						++$postCount;
						
						?>
						
								<div>
									<h1><?php echo htmlspecialchars($title); ?></h1>
									<p><small>By <a href="post.php?user=<?php echo htmlspecialchars($uid); ?>"><?php echo htmlspecialchars($uid); ?></a> at <?php echo $date; ?></small></p>
									<p>
										<?php
											echo nl2br(htmlspecialchars($post));
										?>
									</p>
								</div>
									
						<?php
					}
					
					if ($postCount === 0) {
						?>
						<div>
							<h1>Post Not Found</h1>
						</div>
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
		
	//}
	
	//viewPost($post_id);
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