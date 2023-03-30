<?php
include 'checkdisabled.php';
include 'header.php';
require('db.php');
// Check if user is logged in using the session variable
if(!isset($_SESSION['username']) || $_SESSION['username'] == 'root' || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
$username = $_SESSION['username'];

if(isset($_POST['title'])) {
    // Check if the title is empty
    $title = $_POST['title'];
    $url = $_POST['url'];
    $text = $_POST['text'];
    $user_id = $_SESSION['user_id'];
    // Insert the post into the database
    $query = 'INSERT INTO `posts` (title, url, text, user_id, username) VALUES (?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssis', $title, $url, $text, $user_id, $username);
    $result = $stmt->execute();

    // Catch errors
    if($result) {
        echo "Post submitted successfully";
        // TODO: Redirect to the new post
        header("Location: index.php");
    } else {
        echo "Failed to submit post";
    }
}
?>
<html>
    <head>
        <title>submit</title>
    </head>
    <!-- Use bootstrap -->
    <body>
        <div class="container">
            <!-- Form -->
            <h2 class="form-signin-heading">Submit a post</h2>
            <br>
            <form class="form-signin" method="POST">
                <?php if(isset($msg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $msg; ?> </div>
                <?php } ?>
                
                <label for="inputTitle" class="sr-only">Title</label>
                <input type="text" name="title" id="inputTitle" class="form-control" placeholder="Title" required>
                <br>
                <label for="inputUrl" class="sr-only">Url</label>
                <input type="text" name="url" id="inputUrl" class="form-control" placeholder="Url (optional)">
                <br>
                <label for="inputText" class="sr-only">Text</label>
                <textarea name="text" id="inputText" class="form-control" placeholder="Text (optional)"></textarea>
                <br>
                <button class="btn btn-primary btn-block" type="submit">Submit</button>
        </div>
    </body>
</html>