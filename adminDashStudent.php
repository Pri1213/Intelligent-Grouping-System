<?php
session_start();
if (isset($_SESSION['email']) && !empty($_SESSION['email'])){
    $email = $_SESSION['email'];
}else{
    header('Location: loginPage.php');
    exit();  
}

// establish connection to database using PDO
include('db_connect.php');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //select all students from database
    $stmt = $conn->prepare("SELECT * FROM user WHERE UserType = 'student'");
    $stmt->execute();
    $student = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Retrieve the count of active users
    $sql_active = "SELECT COUNT(*) AS active_count FROM user WHERE Status = 'active' AND UserType = 'student'";
    $statement_active = $conn->prepare($sql_active);
    $statement_active->execute();
    $active_count = $statement_active->fetch(PDO::FETCH_ASSOC)['active_count'];

    // Retrieve the count of inactive users
    $sql_inactive = "SELECT COUNT(*) AS inactive_count FROM user WHERE Status = 'inactive' AND UserType = 'student'";
    $statement_inactive = $conn->prepare($sql_inactive);
    $statement_inactive->execute();
    $inactive_count = $statement_inactive->fetch(PDO::FETCH_ASSOC)['inactive_count'];

   
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$conn = null;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <meta name="author" content="Gregory Grenouille/ ID - 20384658">
    <meta name="description" content="WEB APPLICATION FOR FORMING STUDNENT GROUPS">
    
    <title>Admin Dash Student</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/styleAdminDashStudent.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- Optional Bootstrap theme CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap-theme.min.css">

    <!-- jQuery for Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
    <!--Below is my code for the page header-->
    <header class="siteheadertop">
        <div class="site-identity2">
            <div class="logo">
                <img class="curtinlogo" src="images/CTCLOGO.png">
            </div>
        </div>

        <nav class="headernavigation">
            <ul>
                <li><a href="AboutUs.html">About Us</a></li>
                <li><p> Hello <?php echo $email ?></p></li>
                <li class="logout"><a href="loginPageAdmin.php?status=logout">Log out</a></li>
            </ul>
        </nav>

    </header> <!--This is the end of the top most header-->

    <!--This is the second header containing the name of the website-->
    <header class="siteheader">   
        <div class="site-identity">
            <h3><a href="#">Intelligent Student Grouping System</a></h3>
        </div>
    </header>

    <!--Below is my code for the main content of the page-->
    <div class="pageContainer">
        <!--THIS IS THE CODE SECTION FOR SIDE BAR SECTION OF THE WEBPAGE-->
        <div class="sideBar">
            <h1>Select what you want to see</h1>
                       
            <!--The class 'containerButons will be used to move all the buttons at once'-->
            <div class="containerButtons">
                <div class="buttonContainer">
                    <!--By default the overview will be display on the admin dashboard-->
                    <form action="adminDashboard.php">
                        <button class="button" role="button">Overview</button>
                    </form>
                </div><br><br>

                <div class="buttonContainer">
                    <!--By default the overview will be display on the admin dashboard-->
                        <button class="button" onclick="redirect()" role="button">Add Lecturer</button>
                </div><br><br>

                <div class="buttonContainer">
                    <form action="adminDashStudent.php">
                        <button class="button" role="button">Student</button>
                    </form>
                </div><br><br>

                <div class="buttonContainer">
                    <form action="adminDashLecturer.php">
                        <button class="button" role="button">Lecturer</button>
                    </form>
                </div><br><br>

                <div class="buttonContainer">
                    <form action="adminDashGroups.php">
                        <button class="button" role="button">Groups</button>
                    </form>   
                </div><br><br>
            </div>
        </div>

        <!--THIS IS THE CODE SECTION FOR THE MAIN CONTENT OF THE WEBPAGE-->
        <div class="mainContent"> 
            <h1>Student</h1>   
            <!--Below is the code for the textbox-->

            <!--The code below is for the first 1 boxes-->
            <div class="box1">
            
                <div style="display: flex;  justify-content: center; align-items: center; height: 40vh;">
                    <canvas id="userChart" style="max-width: 600px; height: 300px;"></canvas>
                </div>
            </div>
            <br>
            <div class="box1">
                 <?php
                   // display list of students in a table
                   if (count($student) > 0) {
                   echo "<table class='table table-striped table-hover animate__animated animate__fadeIn'>";
                   echo "<thead class='thead-lighter'><tr><th scope='col'>Email Address</th><th scope='col'>User ID</th><th scope='col'>User Type</th><th scope='col'>Status</th><th scope='col'>Action</th></tr></thead>";
                   echo "<tbody>";
                   foreach ($student as $student) {
                   echo "<tr><td>" . $student["EmailAddress"] . "</td><td>" . $student["UserID"] . "</td><td>" . $student["UserType"] . "</td><td>" . $student["Status"] . "</td>" . "</td><td><a href ='adminStudentEdit.php?id=" . $student["UserID"] . "'>Edit</a></td></tr>";
                   }
                   echo "</tbody>";
                   echo "</table>";
                 } else {
                   echo "0 results";
                 }
                ?>
            </div>
            </div><br>

        </div>
    </div>
    <!--Below is my code for the footer of the webpage-->
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
    <!--Below is the space reserved for inserting my scripts source-->
    <script src=""></script>
    <script>
    // Retrieve the active and inactive counts from PHP variables
    var activeCount = <?php echo $active_count; ?>;
    var inactiveCount = <?php echo $inactive_count; ?>;

    // Create the chart
    var ctx = document.getElementById('userChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Active', 'Inactive'],
            datasets: [{
                label: 'User Status',
                data: [activeCount, inactiveCount],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 99, 132, 0.5)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    precision: 0,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        zeroLineColor: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
</body>
</html>