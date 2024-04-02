<?php
session_start();

$page_title = "Password Reset Form";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Form</title>
    <link rel="stylesheet" type="text/css" href="password.css">
</head>
<body>
    <div class="form-container">
        <div class="col-md-6">
            <?phpif(isset($_SESSION['status']))
            {
                ?>
                <div class="alert arlet-success">
                    <h5><?=$_SESSION['status']; ?></h5>
                </div>
                <?php
                unset($_SESSION['status']);
            }
        ?>
        <form action="password-reset-code.php" method="POST" class="form-wrap">
            <h2>Reset Password</h2>
            <br>
            <h6 class="information-text">Enter your registered email to reset your password.</h6>
            <br>
            <div class="form-box">
                <input type="text" placeholder="Enter Email Address"/>
            </div>
            <br>
            <div class="form-submit">
                <input type="submit" placeholder="send"/>
            </div>
        </form>
    </div>
</body>
</html>