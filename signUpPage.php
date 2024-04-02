<?php
$err="";
    if (isset($_GET['formtype'])) {
            $form = $_GET['formtype'];
    }

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to database
    include('db_connect.php');
    

    $FirstName = $_POST["FirstName"];
    $LastName = $_POST['LastName'];
    $EmailAddress = $_POST["EmailAddress"];
    $Password = $_POST['Password'];
    $formtype = $_POST['formtype'];
    $confirmPassword = $_POST['confirmPassword'];

    if($Password !== $confirmPassword){
        $newURL = "signUpPage.php?formtype=".$formtype;
        echo '<script>alert("Password does not match")</script>';
    } else{
  
    // encrypting password
    $Password = password_hash($Password,PASSWORD_DEFAULT);

    $user = getuser($EmailAddress);

    // if user exist then redirect to login page
    if($user) {
        header("Location: loginPage.php");
    }
    // else insert user into database
    else {
        $UserType = ($formtype === "student") ? "student" : "lecturer";
        $sql = "INSERT INTO user (EmailAddress, Password, UserType, Status)
        VALUES (:EmailAddress, :Password, :UserType, :Status)";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ':EmailAddress' => $EmailAddress,
            ':Password'     => $Password,
            ':UserType'     => $UserType,
            ':Status'       => "active"
            ],);
       
        $user_created = getuser($EmailAddress);
        if($formtype === "lecturer"){
            $sql1 = "INSERT INTO lecturer (FirstName, LastName, EmailAddress, UserID)
            VALUES (:FirstName, :LastName, :EmailAddress, :UserID)";
            $statement_1 = $conn->prepare($sql1);
            $statement_1->execute([
                ':FirstName' => $FirstName,
                ':LastName' => $LastName,
                ':EmailAddress' => $EmailAddress,
                ':UserID' => $user_created['UserID']    
                ]);
       
        }else{
            $sql1 = "INSERT INTO student (FirstName, LastName, UserID)
            VALUES (:FirstName, :LastName, :UserID)";
            $statement_1 = $conn->prepare($sql1);
            $statement_1->execute([
                ':FirstName' => $FirstName,
                ':LastName' => $LastName,
                ':UserID' => $user_created['UserID']    
                ]);
        }
        if($formtype === "student"){
          header("Location: loginPage.php");
        }elseif($formtype === "lecturer"){
            header("Location: adminDashboard.php");
        }else{
          header("Location: adminDashboard.php");
        }
    }      
}   

}
function getuser($EmailAddress){
    include('db_connect.php');
    $sql1 = "SELECT * FROM user WHERE EmailAddress = :EmailAddress";
    $statement = $conn->prepare($sql1);
    $statement->execute([':EmailAddress' => $EmailAddress]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    return $user;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Gregory Grenouille /ID - 20384658">
    <meta name="description" content="WEB APPLICATION FOR FORMING STUDENT GROUPS">
    <title>ISGS - Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/styleSignUpPage.css">
</head>
<body>
    <header class="siteheadertop">
        <div class="site-identity2">
            <div class="logo">
                <img class="curtinlogo" src="images/CTCLOGO.png">
            </div>
        </div>

        <nav class="headernavigation">
            <ul>
                <li><a href="homePage.php">Home</a></li>
                <li><a href="#">ISGS Help</a></li>
                <li><a href="#">About Us</a></li>
            </ul>
        </nav>

    </header> <!--This is the end of the top most header-->

    <!--This is the second header containing the name of the website-->
    <header class="siteheader">
        
        <div class="site-identity">
            <h3><a href="#">Intelligent Student Grouping System</a></h3>
        </div>
    </header> <!--This is the end of the header for the sign up page-->


    <!--Below is the code for the sign up form-->
    <div class="form_wrapper">
        <div class="form_container">
            <!--Below is the code for the user icon-->
            <div class="usericon">
                <i class="far fa-user"></i>  
            </div>

            <div class="title_container">
                <br>
                <h1>Sign Up</h1>
                <h3>Your gateway to making equal student groups</h3><br>
            </div>

            <div class="signUpForm">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="formtype" value="<?php echo $form; ?>">
                <form>
                    <div class="formgroup">
                        <label for = "firstName">First Name</label><br>
                        <input type="text" placeholder="" id="firstname"  name="FirstName" class="formcontrol"><br>
                        
                        <label for = "lastName">Last Name</label><br>
                        <input type="text" placeholder="" id="lastname" name="LastName" class="formcontrol"><br>

                        <label for = "id">Email Address</label><br>
                        <input type="email" placeholder="" id="emailAddress" name="EmailAddress" class="formcontrol"><br>
                        
                        <label for = "password">Password</label><br>
                        <input type="password" placeholder="" id="password" name="Password" class="formcontrol"><br>
                        <label><input type="checkbox" onclick="myFunction()" class="checkbox" >&nbsp Show Password</label><br><br>

                        <label for = "confirmPassword">Confirm Password</label><br>
                        <input type="password" placeholder="" id="confirmPassword" name="confirmPassword" class="formcontrol"><br>

                        <!--Below i will be displaying an error message for incorrect passwords match-->
                        <span id='message'><?php echo $err; ?></span>

                        <label><input type="checkbox" onclick="myFunction2()" class="checkbox" >&nbsp Show Password</label><br><br>
                    </div>

                    <div class="input_field checkbox_option">
                        <input type="checkbox" id="cb1">
                        <label for="cb1">I agree with terms and conditions</label>
                    </div><br>
                   
                    <input class="button" type="submit" value="Sign Up" /> <!--Here through the 'onclick, i am calling the function to validate the password entered'-->
                </form>
            </div>
            
        </div>
    </div><br><br><br>

    <!--Below is the code for the footer-->
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
    <script src="js/scriptsSignUpPage.js"></script>
</body>
</html>