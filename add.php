<!DOCTYPE html>
<html>
	<head>
		<title>New Blog Post</title>
	</head>
	<body>
	<div>

		<?php
			include 'db_utils.php';

			session_start();
			$post_id = 0;
			$isByPost = isset($_GET["post"]);
			$title = "";
			$post = "";

			$escapedTitle = "";

			$isLoggedIn = isset($_SESSION["login"]) && $_SESSION["login"];

			if ($isLoggedIn && $isByPost) {
				$post_id = intval($_GET["post"]);
			
				if ($post_id > 0) {
					$statement = "SELECT title, post FROM BlogEntry WHERE id = ? AND uid = ?";
					$mysqli =  blog_db_connect();

					if ($stmt = $mysqli->prepare($statement)) {
						$stmt->bind_param("is", $post_id, $_SESSION["username"]);

						if ($stmt->execute()) {
							$stmt->store_result();
							$stmt->bind_result($title, $post);


							if ($stmt->fetch()) {
								$escapedTitle = htmlspecialchars($title);
							} else {
								echo "Could not get blog post";
							}
						}

						$stmt->close();
					}

					$mysqli->close();
				}		
			} else if (!$isLoggedIn) {
				echo "Error";				
			}
		?>

	<h1>
		<?php
			if ($isByPost) {
				echo "Editing $escapedTitle";
			} else {
		?>
				New Blog Post
		<?php
			}
		?>
	</h1>

	<form action="blog.php" method="POST">
	Title: <br />
		<input type="text" name="title" value="<?php echo $escapedTitle; ?>" />
		<div>
		<textarea name="post" ><?php echo $post ?></textarea>
		</div>
		<div>
		<input type="submit" />
		</div>
		<?php
			if ($isByPost) {
				?>
				<input type="hidden" name="id" value="<?php echo $post_id; ?>" />
				<?php
			}
		?>
	</form>
	</div>
	
	</body>

</html>