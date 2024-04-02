<?php

session_start(); 
//change password
if(isset($_REQUEST['login']))
{
  $email = $_REQUEST['email'];
  $new_password = md5($_REQUEST['new_password']);
  $select_query = mysqli_query($db_connect,"select * from user where email='$email' and password='$new_password'");
  $res = mysqli_num_rows($select_query);
  if($res>0)
  {
    $data = mysqli_fetch_array($select_query);
    $name = $data['name'];
    $_SESSION['name'] = $name;
    header('location:StudentDashboard.php');
  }
  else
  {
    $msg = "Invalid Credentials";
  }
}







// start session before any output
    if (isset($_GET['status']) && $_GET['status'] === "logout" ) {
        session_destroy();
        unset($_SESSION['id']);
        unset($_SESSION['email']);
        unset($_SESSION['type']);
        unset($_SESSION['status']);

    }

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Connect to database using PDO
    require_once('db_connect.php');

    $emailAddress = $_POST['EmailAddress'];
    $password = $_POST['Password']; 

    // Prepare the SQL statement to retrieve the user record
    $stmt = $conn->prepare("SELECT * FROM user WHERE EmailAddress=:emailAddress");
    $stmt->bindParam(':emailAddress', $emailAddress);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($user && password_verify($password, $user['Password'])) {   
        $_SESSION['id'] = $user['UserID'];
        $_SESSION['email'] = $user['EmailAddress'];
        $_SESSION['type'] = $user['UserType'];
        $_SESSION['status'] =$user['Status'];

        if ($user['Status'] !== "active"){
            $msg = "in active";
            header('Location: loginPage.php');
            exit();  
        }

        switch ($user['UserType']) {
          case "admin":
           header('Location: admindashboard.php');
            exit();
            break;
          case "student":
           header('Location: studentDashboard.php');
            exit();
            break;
          default:
            header('Location: loginPage.php');
            exit();
        }

    } else {
        // if password incorrect, show error message
        $passwordErr = "* Invalid password or username";
        echo "<script>alert('Invalid password or username')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    
    <meta name="author" content="Gregory Grenouille /ID - 20384658">
    <meta name="description" content="WEB APPLICATION FOR FORMING STUDENT GROUPS">
    <title>ISGS - Login</title>
    <link rel="stylesheet" type="text/css" href="css/styleLoginLecturerPage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>   
</head>

<body>
    <!--Below I will add a header for the login page-->

    <!--Below is the header containing the curtinlogo-->
    <header class="siteheadertop">
        <div class="site-identity2">
            <div class="logo">
                <img class="curtinlogo" src="images/CTCLOGO.png">
            </div>
        </div>

        <nav class="headernavigation">
            <ul>
                <li><a href="homePage.php">Home</a></li>
                <li><a href="AboutUs.html">About Us</a></li>
            </ul>
        </nav>

    </header> <!--This is the end of the top most header-->

    <!--This is the second header containing the name of the website-->
    <header class="siteheader">
        
        <div class="site-identity">
            <!--
            <div class="logo">
                <img class="curtinlogo" src="images/Logocurtin.png">
            </div>
            -->
            <h3><a href="#">Intelligent Student Grouping System</a></h3>
        </div>
    </header>

    <!--Below is the code for the login box-->
    <div class="form_wrapper">
        <div class="form_container">
            <!--Below is the code for the user icon-->
            <div class="usericon">
                <i class="far fa-user"></i>  
            </div>

            <div class="title_container">
                <br>
                <h1>Student Login</h1>
                <h3>Your gateway to making equal student groups</h3><br>
            </div>
            <div class="signUpForm">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <div class="formgroup">
                        <label for = "idNumber">Enter email address</label><br>
                        <input type="email" placeholder="" name="EmailAddress" id="emailAddress" class="formcontrol"><br>
                        <label for = "password">Password</label><br>
                        <input type="password" placeholder="" id="password" name="Password" class="formcontrol"><br>
                        <label><input type="checkbox" onclick="myFunction()" class="checkbox" >&nbsp Show Password</label><br><br>
                    </div>       
                    <input class="button" type="submit" value="Login" />
                    <p>Not Registered ? <a href="signUpPage.php?formtype=student">Sign Up</a></p>
                    <a href="forgot.php" class="float-end">Forgot Password</a>
                </form>
            </div>
        </div>
    </div><br><br><br>
    
    <!--This class below is the main footer which will contain subfooters-->
    <footer>
        <div class="footercontainer">
            <div class="leftsection">
                <h2>About Us</h2>
                <div class="content">
                    <p>Web Application developped to ease the life of lecturers when making students groups</p>
                    <div class="social">
                        <a href="https://www.facebook.com/CharlesTelfairCentre/"><span class="fab fa-facebook-f"></span></a>  
                        <a href="https://www.instagram.com/curtin.mauritius/?hl=en"><span class="fab fa-instagram"></span></a>
                        <a href="https://www.youtube.com/channel/UCt4BSgts3tDLnnhyD-tJGbQ"><span class="fab fa-youtube"></span></a>
                    </div>
                </div>
            </div> <!--end of footer's left section-->

            <div class="center section">
                <h2>Contact Us</h2>
                <div class="content">
                    <div class="place">
                        <span class="fas fa-map-marker-alt"></span>
                        <span class="text">Moka, Mauritius</span>
                    </div>

                    <div class="phone">
                        <span class="fas fa-phone-alt"></span>
                        <span class="text">+230 4016526</span>
                    </div>

                    <div class="email">
                        <span class="fas fa-envelope"></span>
                        <span class="text"> ctcentre@telfair.ac.mu</span>
                    </div>
                </div>
            </div><!--End of footer's center section-->

            <div class="right section">
                <h2>Teaching Areas</h2>
                <div class="content">
                    <ul>
                        <li>Business and Law</li>
                        <li>Health and Sciences</li>
                        <li>Science and Engineering</li>
                        <li>Humanities</li>
                    </ul>
                </div>
            </div><!--end of footer's right section-->
        </div>

        <div class="footerbottom">
            <div>
                <span><p>© 2023 | All Rights Reserved | Developped by CTC Students</p></span>
            </div>
        </div><!--end of 'footer bottom' class-->
    </footer>

    <!--Below is the code for calling my javaScript code-->
    <script src="js/scriptsLoginPage.js"></script>
</body>
</html> <!--Closing statement of the HTML tag--> 