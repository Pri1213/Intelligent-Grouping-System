<?php

session_start();
if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $userID = $_SESSION['id'];
} else {
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
if (!empty($_REQUEST['request_type'])) {
    $request = $_REQUEST['request_type'];
}

if (isset($_GET['choose_unit'])) {

    $selectedUnit = "";
    // Get the selected unit from the form
    $selectedUnit = $_GET['unit'];

    // Query the database to retrieve the student list
    $sql_student = "SELECT s.FirstName, s.LastName, s.UserID
                    FROM Student s 
                    JOIN stu_unit su ON s.UserID = su.UserID 
                    JOIN Unit u ON u.UnitID = su.UnitID 
                    WHERE u.UnitName = :unitName";
    $statement_student = $conn->prepare($sql_student);
    $statement_student->bindValue(':unitName', $selectedUnit);
    $statement_student->execute();
    $students = $statement_student->fetchAll(PDO::FETCH_ASSOC);
    $number_students = count($students);
}

if (isset($_POST['choose_student'])) {
    $selectedUserID = $_POST['student'];
    include('db_connect.php');
    $selectedUnit = "";
    try {
        // Create a new PDO instance
        $dbh = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);

        // Set PDO error mode to exception
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Execute your SQL query using the selected UserID
        $query = "SELECT (d1.Total/320)*100 AS D1, (d2.Total/320)*100 AS D2, (d3.Total/320)*100 AS D3, (d4.Total/320)*100 AS D4, (d5.Total/320)*100 AS D5, (d6.Total/320)*100 AS D6, (d7.Total/320)*100 AS D7, (d8.Total/320)*100 AS D8, (d9.Total/320)*100 AS D9, (d10.Total/320)*100 AS D10 
        FROM stu_survey_d1 d1 JOIN stu_survey_d2 d2 ON d1.UserID = d2.UserID 
        JOIN stu_survey_d3 d3 ON d1.UserID = d3.UserID 
        JOIN stu_survey_d4 d4 ON d1.UserID = d4.UserID 
        JOIN stu_survey_d5 d5 ON d1.UserID = d5.UserID 
        JOIN stu_survey_d6 d6 ON d1.UserID = d6.UserID 
        JOIN stu_survey_d7 d7 ON d1.UserID = d7.UserID 
        JOIN stu_survey_d8 d8 ON d1.UserID = d8.UserID 
        JOIN stu_survey_d9 d9 ON d1.UserID = d9.UserID 
        JOIN stu_survey_d10 d10 ON d1.UserID = d10.UserID 
        WHERE d1.UserID = $selectedUserID;";

        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Close the database connection
        $dbh = null;

        // Convert the data array to JSON
        $jsonData = json_encode($data);
    } catch (PDOException $e) {
        // Handle any errors that occur during the database connection or query execution
        echo "Error: " . $e->getMessage();
    }
}


    // Get groupname from database
    if (!empty($selectedUnit)) {
    $sql_sum = "SELECT SUM(NumberofGroup) AS totalSum FROM create_group WHERE UnitID = (SELECT UnitID FROM Unit WHERE UnitName = :unitName)";
    $statement_sum = $conn->prepare($sql_sum);
    $statement_sum->bindValue(':unitName', $selectedUnit);
    $statement_sum->execute();
    $result = $statement_sum->fetch(PDO::FETCH_ASSOC);
    $number_groups = $result['totalSum'];

    }

if (isset($_GET['unit'])) {
    $selectedUnit = $_GET['unit'];
    $group = "";

    // Query to retrieve the UnitID associated with the selected UnitName
    $sql_unit_id = "SELECT UnitID FROM Unit WHERE UnitName = :unitName";
    $statement_unit_id = $conn->prepare($sql_unit_id);
    $statement_unit_id->bindValue(':unitName', $selectedUnit);
    $statement_unit_id->execute();
    $unitResult = $statement_unit_id->fetch(PDO::FETCH_ASSOC);
    $unitID = $unitResult['UnitID'];

    // Query to fetch data from the group table for the selected UnitName
    $sql_fetch_groups = "SELECT * FROM `group` WHERE UnitName = :unitName";
    $statement_fetch_groups = $conn->prepare($sql_fetch_groups);
    $statement_fetch_groups->bindValue(':unitName', $selectedUnit);
    $statement_fetch_groups->execute();
    $groups = $statement_fetch_groups->fetchAll(PDO::FETCH_ASSOC);


}
/* //get groupname from database
$sql_group = "SELECT `Group_Number` FROM `group`";
$statement_group = $conn->prepare($sql_group);
$statement_group->execute();
$groups = $statement_group->fetchAll(PDO::FETCH_ASSOC);
$number_groups = count($groups); */

/*  // SELECT statement
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
$results = $stmt->fetchAll(PDO::FETCH_ASSOC); */
// // Display the groups
// if (!empty($groups)) {
//     echo "<ul>";
//     foreach ($groups as $group) {
//         echo "<li>" . $group['group_name'] . "</li>";
//     }
//     echo "</ul>";
// } else {
//     echo "No groups found for the selected unit.";
// }



/* //get student names from database
if(!empty($_REQUEST['UnitName'])) {
    $unitName = $_REQUEST['UnitName'];
    $sql_student = "SELECT s.FirstName, s.LastName FROM Student s JOIN stu_unit su ON s.UserID = su.UserID JOIN Unit u ON u.UnitID = su.UnitID WHERE u.UnitName = :UnitName;";
    //$sql_student = "SELECT s.FirstName, s.LastName FROM Student s JOIN stu_unit su ON s.UserID = su.UserID JOIN Unit u ON u.UnitID = su.UnitID WHERE u.UnitName = :UnitName;";
    $statement = $conn->prepare($sql_student);
    $statement->bindValue(':unitName', $unitName);
} else {
   echo"error";
} */


// // //get student names from database
// if(!empty($_REQUEST['unit_name'])) {
//     $unitName = $_REQUEST['unit_name'];
//     $sql_student = "SELECT s.FirstName, s.LastName FROM Student s JOIN stu_unit su ON s.UserID = su.UserID JOIN Unit u ON u.UnitID = su.UnitID WHERE u.UnitName = :UnitName;";
//     //$sql_student = "SELECT s.FirstName, s.LastName FROM Student s JOIN stu_unit su ON s.UserID = su.UserID JOIN Unit u ON u.UnitID = su.UnitID WHERE u.UnitName = :UnitName;";
//     $statement = $conn->prepare($sql_student);
//     $statement->bindValue(':unitName', $unitName);
// } else {
//    echo"error";
// }

/* $statement->execute();
$students = $statement->fetchAll(PDO::FETCH_ASSOC);
if(!empty($_REQUEST['request_type'] )){
    $request = $_REQUEST['request_type'];
}
 */
/* // count total number of students
    $stmt = $conn->prepare("SELECT COUNT(*) AS total_students FROM user WHERE UserType = 'student'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_students = $result['total_students']; */

/* if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Connect to database using PDO
    require_once('db_connect.php');
    try {
        $pdo = new PDO($dsn, $username, $password);
         // count total number of students
        $stmt = $conn->prepare("SELECT COUNT(*) AS total_students FROM user WHERE UserType = 'student'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_students = $result['total_students'];
        //select all students from database
        $stmt = $conn->prepare("SELECT * FROM user WHERE UserType = 'student'");
        $stmt->execute();
        $student = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

} */
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="css/styleLecturerDashboard.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



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
                <li>
                    <p> Hello
                        <?php echo $email ?>
                    </p>
                </li>
                <li>
                    <p> Selected Unit:
                        <?php
                        if (!empty($selectedUnit)) {
                            echo $selectedUnit;
                        }

                        ?>
                    </p>
                </li>
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
                <form method="GET" action="">
                    <div class="row">
                        <div class="moduleDropDown">
                            <div class="dropSelect">
                                <select name="unit" id="unit-select">
                                    <?php
                                    foreach ($units as $unit) {

                                        ?>
                                        <option value="<?php echo $unit['UnitName']; ?>" <?php if (isset($_GET['unit']) && $_GET['unit'] == $unit['UnitName'])
                                               echo 'selected="selected"'; ?>>
                                            <?php echo $unit['UnitName']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div><br>
                    <input type="submit" name="choose_unit" value="Choose Unit" />
                </form>
            </div><!--End of the first column-->

            <div class="column">
                <div class="row">
                    <form method="POST" action=""> <!-- Submit the form to process.php -->
                        <!-- Below is the dropdown for STUDENTS NAME -->
                        <div class="studentDropDown">
                            <div class="dropSelect">
                                <select name="student" id="student">
                                    <?php foreach ($students as $student): ?>
                                        <option value="<?php echo $student['UserID']; ?>">
                                            <?php echo $student['FirstName'] . ' ' . $student['LastName']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div><br>
                        <input type="submit" name="choose_student" value="Choose Student" />
                    </form>
                </div>
            </div>

            <!-- End of the 3rd column -->


        </div><!--End of class columns-->
    </div><br><br>


    <!--Below i am setting the layout of the page's content-->
    <div class="firstRowContent">
        <div class="leftSection">
            <canvas id="myChart" width="300" height="600"></canvas>
        </div>

        <div class="rightSection">
            <!--See '.box2' & padding rem in CSS to play with the padding of the small boxes-->
            <div class="smallBox">
                <h4>Students<img class="image" src="images/student.png" alt="Student"></h4>
                Total number of students:
                <?php
                if (!empty($number_students)) {
                    echo $number_students;
                }
                ?>
            </div>

            <div class="smallBox">
                <h4>Groups <img class="image" src="images/group.png" alt="Group"></h4>
                Total number of groups:
                <?php
                if (!empty($number_groups)) {
                    echo $number_groups;
                }
                ?>

            </div>

        </div>
    </div>

    <div class="secondRowContent">

        <div class="secondLeftSection" style="overflow: auto;">
            <div class="headerDrop">
                <h3>Group Details</h3>
            </div>
            <div class="groupDropDown">
                <div class="dropSelect">
                    <form method="GET" action="">
                        <select name="unit" id="unit-select" onchange="this.form.submit()">
                            <?php
                            foreach ($units as $unit) {
                                $selected = (isset($_GET['unit']) && $_GET['unit'] == $unit['UnitName']) ? 'selected="selected"' : '';
                                echo '<option value="' . $unit['UnitName'] . '" ' . $selected . '>' . $unit['UnitName'] . '</option>';
                            }
                            ?>
                        </select>
                    </form>
                </div>
            </div>
            <br>
            <div class="chart">
                <style>
                    table {
                        border-collapse: separate;
                        border-spacing: 10px;
                        height: 100px;
                        /* Adjust the spacing as desired */
                    }

                    th,
                    td {
                        padding: 10px;
                        /* Adjust the padding as desired */
                    }
                </style>
                <?php
                if (!empty($groups)) {
                    echo '<table>';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>GroupID</th>';
                    echo '<th>Group_Number</th>';
                    echo '<th>FirstName</th>';
                    echo '<th>LastName</th>';
                    echo '<th>survey_ratio</th>';
                    echo '<th>UnitName</th>';
                    echo '<th>Type</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    foreach ($groups as $group) {
                        echo '<tr>';
                        echo '<td>' . $group['GroupID'] . '</td>';
                        echo '<td>' . $group['Group_Number'] . '</td>';
                        echo '<td>' . $group['FirstName'] . '</td>';
                        echo '<td>' . $group['LastName'] . '</td>';
                        echo '<td>' . $group['survey_ratio'] . '</td>';
                        echo '<td>' . $group['UnitName'] . '</td>';
                        echo '<td>' . $group['Type'] . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo '<p>No groups found for the selected unit.</p>';
                }
                ?>

            </div>
        </div>
        <!--here ends the div for the leftmost section of the 2nd row--><!--here ends the div for the leftmost section of the 2nd row-->

        <div class="secondRightSection">
            <div class="headerDropTwo">
                <h3>Student Details</h3>
            </div>
            <div class="chart">
                <canvas id="mychart2" width="500" height="400"></canvas>
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
    <script src="js/scriptLecturerDash.js"></script>

    <script>
        var jsonData = <?php echo $jsonData; ?>;

        var ctx = document.getElementById('myChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Motivation', 'Personality', 'Leadership preferences', 'Writing skills', 'Software skills', 'Organisation and planning skills', 'Numeracy Skills', 'Research Skills', 'Knowledge skills', 'Creativity'],
                datasets: [{
                    label: 'Dimension Analysis',
                    data: Object.values(jsonData),
                    backgroundColor: [
                        'rgba(204, 153, 204)',
                        '#68ecea',
                        '#BDBEEC',
                        '#ECBDBE ',
                        '#1CD8D2',
                        '#0099c6',
                        '#dd4477',
                        '#aaaa11',
                        '#96AED0',
                        '#96D09B'
                    ],
                    borderColor: [
                        'rgba(204, 153, 204)',
                        '#68ecea',
                        '#BDBEEC',
                        '#ECBDBE',
                        '#1CD8D2',
                        '#0099c6',
                        '#dd4477',
                        '#aaaa11',
                        '#96AED0',
                        '#96D09B'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%', // Adjust the value to make the doughnut slimmer
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                var label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed && context.parsed.toFixed) {
                                    label += context.parsed.toFixed(2) + '%';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
    <script>
        var jsonData = <?php echo $jsonData; ?>;

        var ctx = document.getElementById('mychart2').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Motivation', 'Personality', 'Leadership preferences', 'Writing skills', 'Software skills', 'Organisation and planning skills', 'Numeracy Skills', 'Research Skills', 'Knowledge skills', 'Creativity'],
                datasets: [{
                    label: 'Dimension Analysis',
                    data: Object.values(jsonData),
                    backgroundColor: [
                        'rgba(204, 153, 204)',
                        '#68ecea',
                        '#BDBEEC',
                        '#ECBDBE ',
                        '#1CD8D2',
                        '#0099c6',
                        '#dd4477',
                        '#aaaa11',
                        '#96AED0',
                        '#96D09B'
                    ],
                    borderColor: [
                        'rgba(204, 153, 204)',
                        '#68ecea',
                        '#BDBEEC',
                        '#ECBDBE',
                        '#1CD8D2',
                        '#0099c6',
                        '#dd4477',
                        '#aaaa11',
                        '#96AED0',
                        '#96D09B'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            stepSize: 10 // Adjust the step size as desired
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                var label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed && context.parsed.toFixed) {
                                    label += context.parsed.toFixed(2) + '%';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>


</body>


</html>