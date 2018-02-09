<!DOCTYPE html>
<html>
    <head>
        <title>CircleDot</title>
    </head>
    <body>
        <h1>CircleDot</h1>
        <hr />
        
        <?php
        include 'db_utils.php';
        session_start();
        	if (isset($_SESSION["login"]) && $_SESSION["login"]) {
        ?>
        <h1>My Blog</h1>
        <a href="add.php">New Post</a>
       
        
	<?php
		//list posts
		$user = $_SESSION["username"];
		$mysqli = blog_db_connect();
		
		  
		if ($stmt = $mysqli->prepare("SELECT id, date, title, post FROM BlogEntry WHERE uid=? ORDER BY date DESC")) {
			$stmt->bind_param("s", $user);
			
			if($stmt->execute()) { // Error				
				$stmt->bind_result($id, $date, $title, $post);
				$postCount = 0;
			
				while ($stmt->fetch()) {
					++$postCount;
				?>
				 
				<h2>
					<a href="post.php?post=<?php echo $id; ?>"><?php echo htmlspecialchars($title); ?></a>
				</h2>
				<?php
					echo nl2br(htmlspecialchars($post));
				?>
					<p><small>Posted by <a href="post.php?user=<?php echo htmlspecialchars($user); ?>"><?php echo htmlspecialchars($user); ?></a> at <?php echo $date; ?> |
					<a href="add.php?post=<?php echo $id; ?>">Change</a> |
					<a href="delete.php?post=<?php echo $id; ?>">Delete</a>					
					</small></p>
				<?php
				}
				
				?>
				<br /><br />
				<?php
				if ($postCount === 0) {
					echo "No posts yet. Create one!";
				} else {
					echo $postCount . " posts";
				}

			}
		} else {
			echo "Error";
		}
		
		} else {
	?>
		
		<div>
		<form action="login.php" method="POST">
		        <div>
		        	Username:
		        </div>
		        <div>
		        	<input name="username" type="text" />
		        </div>
		        <div>
		        	Password:
		        </div>
		        <div>
		     		<input name="password" type="password" />
		     	</div>
		     	<div>
		     		<input type="submit" />&nbsp;&nbsp;<a href="register.html">Register</a>
		     	</div>
		</form>
		</div>
		<div>
			<h1>
				Latest Blog Posts
			</h1>
			<div>
				<?php 
					$mysqli = blog_db_connect();
		
		  
					if ($stmt = $mysqli->prepare("SELECT id, uid, date, title FROM BlogEntry ORDER BY date DESC LIMIT 15")) {
						if($stmt->execute()) { // Error
							$stmt->bind_result($id, $uid, $date, $title);
							$postCount = 0;
						
							while ($stmt->fetch()) {
								++$postCount;
							?>
								 
							 	<h4>
							 		<a href="post.php?post=<?php echo $id; ?>">
										<?php echo htmlspecialchars($title); ?>
									</a>
								</h4>
								
								<p><small>by <a href="post.php?user=<?php echo htmlspecialchars($uid); ?>"><?php echo htmlspecialchars($uid); ?></a> at <?php echo $date; ?></small></p>
							<?php
							}
							
							?>
							<br /><br />
							<?php
							if ($postCount === 0) {
								echo "No posts.";
							}
			
						}
					}
				?>
			</div>
		</div>
	
	<?php
	}
	?>
	<hr />
	<div>
		<?php
			if ($_SESSION["login"]) {
				echo "Hi " .$_SESSION["username"] . '. <a href="logout.php">Log Out</a>' ;
			}
		?>
		<p>
			<small>&copy; 2018 CircleDot, LLC.
		</p>
	</div>
    </body>
</html>