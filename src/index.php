<?php
	require('db.php');
	// Start the session
	session_start();
	include 'header.php';
	// Check if user is logged in using the session variable
	$credential_are_set = false;
	$user_id = 'no user id';
	$username = 'no username';
	if(isset($_SESSION['username']) && $_SESSION['username'] != 'root' && isset($_SESSION['user_id'])) {
		$username = $_SESSION['username'];
		$user_id = $_SESSION['user_id'];
		$credential_are_set = true;
	}
	echo "<center><h3>Hello  $username  with  $user_id  !</h3></center>";
	echo '<center><div>New user? Please <a href="login.php">Login</a> or <a href="register.php">Register</a> </div></center>';
	// Logout button
	if($credential_are_set) {
		// Submit post button
		echo '<center><div><a href="submit.php">Submit a post</a></div></center>';
		echo '<center><div><a href="logout.php">Logout</a></div></center>';
	}
	// Get all posts
	$query = "SELECT * FROM `posts` ORDER BY `creation_date` DESC";
	$result = mysqli_query($conn,$query) or die(mysql_error());
	$count = mysqli_num_rows($result);
	// Get all posts
	$posts = array();
	while($row = mysqli_fetch_assoc($result)) {
		$posts[] = $row;
	}
	// Check if there are any posts
	if($count == 0) {
		echo '<center><div>No posts yet</div></center>';
	}
	// Display all posts
	for($i = 0; $i < $count; $i++) {
		echo "<div><a href='post.php?id=" . $posts[$i]['id'] . "'>";
		echo "Post title: " . $posts[$i]['title'] . "<br>";
		echo "Post url: " . $posts[$i]['url'] . "<br>";
		echo "Post text: " . $posts[$i]['text'] . "<br>";
		echo "Post creation time: " . $posts[$i]['creation_date'] . "<br>";
		echo "Post username: " . $posts[$i]['username'] . "<br>";
		echo "</a></div>";
		echo "<br>";
	}
	include 'footer.php';
?>