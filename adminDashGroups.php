<?php
session_start();
if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    $email = $_SESSION['email'];
} else {
    header('Location: loginPage.php');
    exit();
}
include('db_connect.php');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SELECT statement
    $stmt = $conn->prepare("
        SELECT
            GroupID,
            Group_Number AS Assigned_Group_Name,
            FirstName AS Student_FirstName,
            LastName AS Student_LastName,
            survey_ratio AS Survey_Results,
            UnitName
        FROM
            `group`
    ");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <title>Admin Dash Groups</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="css/styleAdminDashGroups.css">
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
                <li>
                    <p> Hello
                        <?php echo $email ?>
                    </p>
                </li>
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
        <div class="container">
            <div class="mainContent">
                <h1>Groups</h1>
                <!-- Below is the code for the textbox -->

                <!-- The code below is for the first 1 boxes -->
                <div class="box1">
                    <p>Group and Student Details</p>

                    <!-- Display the table -->
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Group ID</th>
                                <th>Assigned Group Name</th>
                                <th>Student First Name</th>
                                <th>Student Last Name</th>
                                <th>Survey Results</th>
                                <th>Unit Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $row): ?>
                                <tr>
                                    <td>
                                        <?php echo $row['GroupID']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['Assigned_Group_Name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['Student_FirstName']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['Student_LastName']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['Survey_Results']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['UnitName']; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div><br>
            </div>
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
                        <a href="https://www.facebook.com/CharlesTelfairCentre/"><span
                                class="fab fa-facebook-f"></span></a>
                        <a href="https://www.instagram.com/curtin.mauritius/?hl=en"><span
                                class="fab fa-instagram"></span></a>
                        <a href="https://www.youtube.com/channel/UCt4BSgts3tDLnnhyD-tJGbQ"><span
                                class="fab fa-youtube"></span></a>
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
                <span>
                    <p>© 2023 | All Rights Reserved | Developped by CTC Students</p>
                </span>
            </div>
        </div><!--end of 'footer bottom' class-->
    </footer>
    <!--Below is the space reserved for inserting my scripts source-->
    <script src=""></script>
</body>

</html>