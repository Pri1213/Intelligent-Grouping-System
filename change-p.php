<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    // Redirect to login page
    header('Location: change-p.php');
    exit();
}

// Connect to the database
$servername = "127.0.0.1:3308";
$username = "root"; 
$password = ""; 
$db_name = "isgs";

$conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Get the user ID from the session
$UserID = $_SESSION['id'];

// Get the old password and new password from the form
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
$confirm_new_password = $_POST['confirm_new_password'];

// Validate the inputs
$errors = array();

if (empty($old_password)) {
    $errors[] = 'Please enter your old password';
}

if (empty($new_password)) {
    $errors[] = 'Please enter a new password';
}

if (empty($confirm_new_password)) {
    $errors[] = 'Please confirm your new password';
}

if ($new_password != $confirm_new_password) {
    $errors[] = 'Your new password and confirmation password do not match';
}

// Check if the old password is correct
if (empty($errors)) {
    $query = "SELECT password FROM user WHERE UserID = '$UserID'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $password_hash = $row['password'];

        if (password_verify($old_password, $password_hash)) {
            // Update the password in the database
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

            $query = "UPDATE user SET password = '$new_password_hash' WHERE UserID = '$UserID'";
            mysqli_query($conn, $query);

            // Redirect to success page
            header('Location: success.php');
            exit();
        } else {
            $errors[] = 'Your old password is incorrect';
        }
    }
}

//If there are errors, display them
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: change-p.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" type="text/css" href="password.css">
</head>
<body>
    <div class="form-container">
        <form action="changePassword.php" method="POST" id="change-password-form" class="form-wrap">
            <h2>Change Password</h2>
            <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
            <br>
            <h6 class="information-text">Enter your new password.</h6>
            <br>
            <div id="alert"></div>

                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" placeholder="email"/>
                <br>
                <label for="old_password">Old Password</label>
                <input type="password" name="old_password" id="old_password" placeholder="old password"/>
                <br>
                <label for="new_password"> New password</label>
                <input type="password"  name="new_password" id="new_password" placeholder="new password"/>
                <br>
                <label for="confirm_new_password">Confirm New password</label>
                <input type="password" name="confirm_new_password" id="confirm_new_password" placeholder="confirm new password"/>
                <br>
                <div class="button">
                    <button type="submit" name="submit" >Submit</button>
                </div>
        </form>
    </div>

    <!--js link-->
    <script src="reset.js"></script>
    <script src="script.js"></script>
</body>
</html>