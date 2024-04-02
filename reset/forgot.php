<?php
include('db_connect.php');
try {
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$conn = null;
if(isset($_REQUEST['pwdrst']))
{
    $email = $_REQUEST['email'];
    $check_email = mysqli_query($db_connect, "SELECT EmailAddress FROM user WHERE EmailAddress='$email'");

    $res = mysqli_num_rows($check_email);
    if($res>0)
  {
    $message = '<div>
     <p><b>Hello!</b></p>
     <p>You are recieving this email because we recieved a password reset request for your account.</p>
     <br>
     <p><button class="btn btn-primary"><a href="http://http://localhost/university-Recent/university-RECENT/password-reset.php?secret='.base64_encode($email).'">Reset Password</a></button></p>
     <br>
     <p>If you did not request a password reset, no further action is required.</p>
    </div>';

    include_once("SMTP/class.phpmailer.php");
    include_once("SMTP/class.smtp.php");
    $email = $email; 
    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->SMTPAuth = true;                 
    $mail->SMTPSecure = "tls";      
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587; 
    $mail->Username = "pika@yopmail.com";   //Enter your username/emailid
    $mail->Password = "123456";   //Enter your password
    $mail->FromName = "Tech Area";
    $mail->AddAddress($email);
    $mail->Subject = "Reset Password";
    $mail->isHTML( TRUE );
    $mail->Body =$message;
    if($mail->send())
    {
    $msg = "We have e-mailed your password reset link!";
    }
    }
    else
    {
    $msg = "We can't find a user with that email address";
    }
    }
?>

<html>  
<head>  
    <title>Forgot Password</title>  
    <link rel="stylesheet" type="text/css" href="password.css">
</head>
<body>
    <div class="container">
        <div class="forget-box">
        <h3> Forgot Password</h3><br/>
            <form id="validate_form" method="post" >
                <div class="form-group">
                    <label for="email">Email Address</label><br>
                    <input type="text" name="email" id="email" placeholder="Enter Email" required data-parsley-type="email" data-parsley-trigger="keyup" class="form-control" />
                </div>
                <div class="form-group">
                    <input type="submit" id="login" name="pwdrst" value="Send Password Reset Link" class="btn btn-sucess" />
                </div>

                <p class="error"><?php if(!empty($msg)){ echo $msg; } ?></p>
            </form>
        </div>
        </div>
    </div>
</body>
</html>