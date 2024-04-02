<?php

session_start();
if (isset($_SESSION['email']) && !empty($_SESSION['email'])){
    $email = $_SESSION['email'];
    $userID = $_SESSION['id'];
}else{
    header('Location: loginPageLecturer.php');
    exit();  
}

include('db_connect.php');
//get unit from database
$sql_unit = "SELECT u.UnitName FROM unit u JOIN lec_unit lu ON u.UnitID = lu.UnitID WHERE lu.UserID = :userID;";
$statement = $conn->prepare($sql_unit);
$statement->bindValue(':userID', $userID);
$statement->execute();
$units = $statement->fetchAll(PDO::FETCH_ASSOC);
if(!empty($_REQUEST['request_type'] )){
$request = $_REQUEST['request_type'];
}

if(isset($_GET['unit'])) {
    $selectedUnit = $_GET['unit'];
    // Retrieve the groups for the selected unit from the database
    // Replace 'your_query_here' with your actual query to fetch the groups based on the selected unit
    $groupQuery = "SELECT * FROM create_group WHERE UnitID = :unit";
    $groupStatement = $conn->prepare($groupQuery);
    $groupStatement->execute([':unit' => $selectedUnit]);
    $groups = $groupStatement->fetchAll(PDO::FETCH_ASSOC);
}

  // count total number of students
  $stmt = $conn->prepare("SELECT COUNT(*) AS total_students FROM stu_unit WHERE UserID = 'student'");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $total_students = $result['total_students'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="HandheldFriendly" content="true">
    <meta name="author" content="Gregory Grenouille/ ID - 20384658">
    <meta name="description" content="WEB APPLICATION FOR FORMING STUDNENT GROUPS">
    
    <title>Lecturer Dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/styleLecturerDashboard.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">

    
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
                <li><a href="createGroupPage.php">Create Group</a></li>
                <li><p> Hello <?php echo $email ?></p></li>
                <li><a href="loginPageLecturer.php">Log Out</a></li>
            </ul>
        </nav>

    </header> <!--This is the end of the top most header-->

    <!--This is the second header containing the name of the website-->
    <header class="siteheader">
        <div class="site-identity">
            <h3><a href="#">Lecturer Dashboard</a></h3>
        </div>
    </header>

  
    <!--Below is the dropdown for MODULES-->
    <h1 class="pageHeader">Welcome<img class="image-welcome" src="images/hello.png" alt="Welcome"></h1><br>
    
    <!--Below i will be sectioning the dropdown sections in 3 different parts-->

    <div class="dropDownClass">
        <div class="columns">
            <div class="column">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
                    <div class="row">
                        <div class="moduleDropDown">
                            <div class="dropSelect">
                            <select name="unit" id="unit-select">
                            <?php
                            foreach ($units as $unit){
                                
                                ?>
                            <option value="<?php echo $unit['UnitName']; ?>" <?php if(isset($_GET['unit']) && $_GET['unit'] == $unit['UnitName']) echo 'selected="selected"'; ?>>
                                <?php echo $unit['UnitName']; ?>
                            </option>   
                            <?php
                            }
                            ?>
                        </select>
                        </div>
                        </div>
                    </div><br>
                    <input type="submit" value="Choose Unit" />
                </form>
            </div><!--End of the first column-->

            <div class="column">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
                    <div class="row">
                        <!--Below is the dropdown for GROUPS-->
                        <div class="groupDropDown">
                            <div class="dropSelect">
                                <select name="group" id="group-select">
                                <?php
                                foreach ($groups as $group){
                                    
                                    ?>
                                 <option value="<?php echo $group['CreateID']; ?>">
                                <?php echo $group['CreateID']; ?>
                                </option>    
                                <?php
                                }
                                ?>
                            </select>
                            </div>
                        </div><br>
                        <input type="submit" value="Choose Group" />
                    </div>
                </form>
            </div><!--End of the 2nd column-->

            <div class="column">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
                    <div class="row">
                        <!--Below is the dropdown for STUDENTS NAME-->
                        <div class="studentDropDown">
                            <div class="dropSelect">
                                <select name="student" id="student">
                                <?php
                                foreach ($students as $student){
                                ?>
                                <option value="<?php echo $student['FirstName'] . ' ' . $student['LastName']; ?>">

                                <?php echo $student['FirstName'] . ' ' . $student['LastName']; ?>
                                </option>    
                                <?php
                                }
                                ?>
                                <?php
                                if(isset($_GET['group'])){
                                    foreach($students as $student=>$index){ 
                                        echo "<option value='".($index+1)."'>$student</option>";
                                    } 
                                } else {
                                    echo "<option disabled>Select student</option>";
                                }
                                ?>
                                </select>
                            </div>
                        </div><br>
                        <input type="submit" value="Choose Student" />
                    </div>
                </form>
            </div><!--End of the 3rd column-->
        </div><!--End of class columns-->
    </div><br><br>

 
    <!--Below i am setting the layout of the page's content-->
    <div class="firstRowContent">
        <div class="leftSection">
            <div id="chartContainer" style="height: 600px; width: 100%;"></div>
        </div>

        <div class="rightSection">
            <!--See '.box2' & padding rem in CSS to play with the padding of the small boxes-->
                <div class="smallBox">
                    <h4>Students<img class="image" src="images/student.png" alt="Student"></h4>
                    Total number of students: 
                    <P>
                        <?php echo $total_students; ?><?php echo $selected; ?>
                    </P>
                    
                </div>
            
                <div class="smallBox">
                    <h4>Groups <img class="image" src="images/group.png" alt="Group"></h4>
                    <!--Insert num of groups here (JAVA)-->
                </div>
            
        </div>     
    </div>

    <div class="secondRowContent">

        <div class="secondLeftSection">
            <div class="headerDrop">
                <h3>Group Details</h3>
            </div>

            <div class="groupDropDown">
                <div class="dropSelect">
                    <select name="language" id="language">
                        
                    </select>
                </div>
            </div>
            <br>
            <div class="chart">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>GroupName</th>
                        <th>GroupSize</th>
                        <th>StudentName</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Group 1</td>
                        <td>5</td>
                        <td>Pika Chu</td>
                      </tr>
                      <tr>
                        <td>Group 1</td>
                        <td>5</td>
                        <td>Jane Smith</td>
                      </tr>
                      <tr>
                        <td>Group 1</td>
                        <td>5</td>
                        <td>Bob Johnson</td>
                      </tr>
                      <tr>
                        <td>Group 1</td>
                        <td>5</td>
                        <td>Bobby Johnson</td>
                      </tr>
                      <tr>
                        <td>Group 1</td>
                        <td>5</td>
                        <td>Toby Smith</td>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div><!--here ends the div for the leftmost section of the 2nd row-->
        
        <div class="secondRightSection">
            <div class="headerDropTwo">
                <h3>View your calender</h3>
            </div>
            <!--
            <div class="traitDropDown">
                <div class="dropSelect">
                    <select name="language" id="language">
                        <option value="" >Select traits</option>
                        <option value="1">Leadership</option>
                        <option value="2">Softskills</option>
                        <option value="3">Writing skills</option>
                        <option value="4">Numeracy skills</option>
                        <option value="5">Research skills</option>
                    </select>
                </div>
            </div><br>
             -->
            <div class="calendar-wrapper">
                <button id="btnPrev" type="button">Prev</button>
                <button id="btnNext" type="button">Next</button>
             <div id="divCal"></div>
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

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="js/scriptLecturerDash.js"></script>
</body>
</html>