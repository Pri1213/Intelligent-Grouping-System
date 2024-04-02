<?php
include_once('db_connect.php');
if(isset($_REQUEST['pwdrst']))
{
  $email = $_REQUEST['email'];
  $new_password = md5($_REQUEST['new_password']);
  $confirm_new_password = md5($_REQUEST['confirm_new_password']);
  if($new_password == $confirm_new_password)
  {
    $reset_pwd = mysqli_query($db_connect,"update user set password='$new_password' where email='$email'");
    if($reset_pwd>0)
    {
      $msg = 'Your password updated successfully <a href="index.php">Click here</a> to login';
    }
    else
    {
      $msg = "Error while updating password.";
    }
  }
  else
  {
    $msg = "Password and Confirm Password do not match";
  }
}

if($_GET['secret'])
{
  $email = base64_decode($_GET['secret']);
  $check_details = mysqli_query($db_connect,"select email from user where email='$email'");
  $res = mysqli_num_rows($check_details);
  if($res>0){}}
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
        <form method="post" id="validate_form" class="form-wrap">
            <h2>Change Password</h2>
            <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
            <br>
            <h6 class="information-text">Enter your new password.</h6>
            <br>
            <div id="alert"></div>

                <label for="email">Email Address</label>
                <input type="hidden" name="email" value="<?php echo $email; ?>" placeholder="email"/>
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