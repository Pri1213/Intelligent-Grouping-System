<?php
//start session
session_start();
// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to login page
    // header('Location: changePassword.php');
    // exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to database
    include('db_connect.php');
    
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);

    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }
// Get the user ID from the session
$UserID = $_SESSION['id'];
// Get the user's old password from the database
$sql = "SELECT password FROM user WHERE id = $UserID";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $old_password = $row['password'];
} else {
    die('Error: User not found');
}

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    // Get the old password and new password from the form
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];
}
 // validate inputs
 if(empty($email) || empty($old_password) || empty($new_password) || empty($confirm_new_password)){
    $_SESSION['error'] = "All fields are required";
} elseif($new_password !== $confirm_new_password){
    $_SESSION['error'] = "New password and confirm new password must match";
} else {
    // validate old password against database
    $query = "SELECT * FROM user WHERE email='$email' AND password='$old_password'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 1){
        // update password in database
        $update_query = "UPDATE user SET password='$new_password' WHERE email='$email'";
        mysqli_query($conn, $update_query);
        
        // set success message and redirect to login page lecturer
        $_SESSION['success'] = "Password changed successfully";
        header("Location: homePage.php");
        exit();
    } else {
        // set error message
        $_SESSION['error'] = "Old password is invalid";
    }
}
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
        <form method="POST" id="change-password-form" class="form-wrap" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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