<?php
require('db.php');

if(isset($_SESSION['username']) && $_SESSION['username'] != 'root' && isset($_SESSION['user_id'])) {
    header("Location: index.php");
}

if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Validate the input
    if(empty($username) || empty($email) || empty($password)) {
        $msg = "Please fill all the fields";
        // echo $msg;
    }
    // Validate the username
    if(!validateUsername($username)) {
        $msg = "Username must be between 5 and 15 characters and can only contain letters and numbers";
        // echo $msg;
    }
    // Validate the password
    if(!validatePassword($password)) {
        $msg = "Password must be between 5 and 15 characters and can only contain letters and numbers";
        // echo $msg;
    }
    // Check if the username is already taken
    $query = "SELECT * FROM `users` WHERE username='$username'";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result) > 0) {
        $msg = "Username already taken";
        // echo $msg;
    }
    // Check if the email is already taken
    $query = "SELECT * FROM `users` WHERE email='$email'";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result) > 0) {
        $msg = "Email already taken, you should try logging in";
        // echo $msg;
    }
    // Insert the user into the database
    $query = "INSERT INTO `users` (username, email, password) VALUES ('$username', '$email', '$password')";
    $result = mysqli_query($conn,$query);
    // Get the id of the user
    
    if($result){
        $msg = "Registration successful";
        $query = "SELECT * FROM `users` WHERE username='$username'";
        $result = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];
        print_r($row);
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user_id;
        // Redirect to home
        header("Location: index.php");
    } else {
        $msg = "Registration failed";
        echo "Error:  . $query . <br> . mysqli_error($conn)";
    }
    mysqli_close($conn);
}

function validateUsername($username) {
    if(!preg_match('/^[a-zA-Z0-9]{5,15}$/', $username)) {
        return false;
    }
    return true;
}


function validatePassword($password) {
    if(!preg_match('/^[a-zA-Z0-9]{5,15}$/', $password)) {
        return false;
    }
    return true;
}
// TODO: Check if session already exists
?>
<html>
    <head>
        <title>Register</title>
        <?php include('header.php'); ?>
        
    </head>
    <body>
    <!-- <div class="container">
		  <form class="form-signin" method="POST">
		  <?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
		  <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
			<h2 class="form-signin-heading">Please Register</h2>
			<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">@</span>
		  <input type="text" name="username" class="form-control" placeholder="Username" required>
		</div>
			<label for="inputEmail" class="sr-only">Email address</label>
			<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
			<div class="checkbox">
			  <label>
				<input type="checkbox" value="remember-me"> Remember me
			  </label>
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Register</button> 
		  </form>
	</div> -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <h1 class="text-center my-4">register</h1>
                <form action="process_registration.php" method="post">
                    <div class="form-group">
                        <label for="username">username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">submit</button>
                </form>
                <p class="text-center mt-2">
                    already have an account? <a href="login.php" class="text-muted">login here</a>
                </p>
            </div>
        </div>
    </div>
    </body>
</html>