<html>
<body>
<?php
	include 'db_utils.php';
 	session_start();
  	
  	$post_id = 0;
  	
  	$isByPost = isset($_GET["post"]);
	if ($isByPost) {
		$post_id = $_GET["post"];
	}
	
	function blogDelete($post_id) {
		$mysqli = blog_db_connect();
		
		if ($stmt = $mysqli->prepare("DELETE FROM BlogEntry WHERE id = ? AND uid = ?")) {
      			$numPostId = intval($post_id);
			$stmt->bind_param("is", $numPostId, $_SESSION["username"]);
			
			if($stmt->execute()) {
			        header('Location: ./');
			        $stmt->close();
			        die();
			} else {
				echo "Failed to execute statement";
			}
		}
		
		echo "Error 1";
		$mysqli->close();
	}
  
  $isLoggedIn = isset($_SESSION["login"]) && $_SESSION["login"];
  if ($isLoggedIn && $isByPost) {
	  blogDelete($post_id);
  } else {
    echo "Invalid parameters or not logged in";
  }
	

?>

</body>
</html>