<?php
session_start();
$_SESSION['id'];
if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    $email = $_SESSION['email'];
} else {
    echo ($_SESSION['id']);
    header('Location: loginPageLecturer.php');
    exit();
}

$show = false;
include('db_connect.php');
$conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//select all unit from database
$sql_unit = "SELECT * FROM `unit`";
$statement = $conn->prepare($sql_unit);
$statement->execute();
$units = $statement->fetchAll(PDO::FETCH_ASSOC);
if (!empty($_REQUEST['request_type'])) {
    $request = $_REQUEST['request_type'];
}

// Check if form is submitted
$total_students = 0;
$selected_unit = 0;
if (isset($_POST['studentlist'])) {
    // Get form data
    $unitID = $_POST['unitID'];
    //$stmt = $conn->prepare('INSERT INTO create_group (UnitID) VALUES (:unit_id)');
    //$stmt->execute(array('unit_id' => $unitID));
    $selected_unit = $unitID;
    // Retrieve student list based on selected UnitID
    $sql_students = "SELECT student.StudentID, student.FirstName, student.LastName
                     FROM stu_unit
                     INNER JOIN student ON student.UserID = stu_unit.UserID
                     WHERE stu_unit.UnitID = :unitID";
    $statement_students = $conn->prepare($sql_students);
    $statement_students->bindParam(':unitID', $unitID);
    $statement_students->execute();
    $students = $statement_students->fetchAll(PDO::FETCH_ASSOC);

    // Retrieve total number of students
    $sql_total_students = "SELECT COUNT(UserID) AS total_students
    FROM stu_unit
    WHERE UnitID = :unitID";
    $statement_total_students = $conn->prepare($sql_total_students);
    $statement_total_students->bindParam(':unitID', $unitID);
    $statement_total_students->execute();
    $total_students = $statement_total_students->fetchColumn();

}

// Generate Excel file
if (isset($_POST["export"])) {
   header('Content-Type: application/xls');
   header('Content-Disposition: attachment; filename=create_groups.xls');
   echo "<table border='1'>";
   echo "<tr><th>FirstName</th><th>LastName</th><th>Group_Number</th><th>survey_ratio</th><th>Type</th><th>UnitName</th>";
    // Retrieve create_group data
    // $sql = "SELECT * FROM `group` WHERE ";
    // $stmt = $conn->prepare($sql);
    // $stmt->execute();
    // $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // echo '<td>' . $value['FirstName'] . '</td>';
    // echo '<td>' . $value['LastName'] . '</td>';
    // echo '<td>' . $value['Group_Number'] . '</td>';
    // echo '<td>' . $value['survey_ratio'] . '</td>';
    // echo '<td>' . $value['UnitName'] . '</td>';
    // echo '<td>' . $value['Type'] . '</td>';
    // Check if any groups exist

    if (!empty($_POST['export_value'])) {
        $array = json_decode(base64_decode($_POST['export_value']),true);
     // Output the table rows
     foreach ($array as $group_1) {
        echo "<tr><td>" . $group_1['FirstName'] . "</td><td>" . $group_1['LastName'] . "</td><td>" . $group_1['Group_Number'] . "</td><td>" . $group_1['survey_ratio'] . "</td><td>" . $group_1['Type'] . "</td><td>" . $group_1['UnitName'];
    }}
    echo "</table>";
    exit();
}

// Check if form is submitted
if (isset($_POST['submit_create'])) {
    // Get form data
    $studentNumber = $_POST['StudentNumber'];
    $numberOfGroup = $_POST['NumberofGroup'];
    $groupSize = $_POST['GroupSize'];
    $groupType = $_POST['GroupType'];
    $unitID = $_POST['UnitID'];

    // Insert form data into database
    $sql = "INSERT INTO create_group (StudentNumber, NumberofGroup, GroupSize, GroupType, UnitID) VALUES ('$studentNumber', '$numberOfGroup', '$groupSize', '$groupType','$unitID')";
    $conn->query($sql);
    echo "Group created successfully.";
    // Connect to the database
    include('db_connect.php');
    //$selected_unit= 0;
    $latestUnitID = 0;
    $number_students = $_POST['StudentNumber'];
    $number_groups = $_POST['NumberofGroup'];
    $size_groups = $_POST['GroupSize'];
    $trait = $_POST['GroupType'];

    try {
        // Retrieve the latest entry from the create_group table
        $sql_2 = "SELECT * FROM create_group ORDER BY CreationDate DESC LIMIT 1";
        $stmt = $conn->query($sql_2);
        ;

        if ($stmt && $stmt->rowCount() > 0) {
            // Fetch the latest entry
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Access the values of the latest entry
            $CreateID = $row['CreateID'];
            $latestStudentNumber = $row['StudentNumber'];
            $latestNumberOfGroup = $row['NumberofGroup'];
            $latestGroupSize = $row['GroupSize'];
            $latestGroupType = $row['GroupType'];
            $latestUnitID = $row['UnitID'];

            // Retrieve ratios based on the latest UnitID
            $sql_3 = "SELECT r.ratio
                    FROM ratio AS r
                    JOIN stu_unit AS u ON r.UserID = u.UserID
                    WHERE u.UnitID = :latestUnitID";
            $stmt = $conn->prepare($sql_3);
            $stmt->bindValue(':latestUnitID', $latestUnitID);
            $stmt->execute();
            $ratios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $ratio_array = [];
            foreach ($ratios as $value) {
                $ratio_array['ratio'][] = $value['ratio'];
                // echo '<pre>'.print_r($value['ratio'],true).'</pre>';
                }
                
            // Use the values and ratios as needed
            // ...
            // Return the result in JSON format
            
            // Call the generate function with the latest student number
            $student_ratio = json_encode($ratio_array);

            // Call the function to get the groups

            $response = callGetGroups($latestStudentNumber, $latestNumberOfGroup, $latestGroupSize, $latestGroupType, $student_ratio);
            // Update the create_group table with the response data
            $sql_5 = "UPDATE create_group
            SET ratio = :response, CreationDate = NOW()
            WHERE CreateID = :CreateID";
            $stmt = $conn->prepare($sql_5);
            $stmt->bindValue(':response',  json_encode($response));
            $stmt->bindValue(':CreateID', $CreateID);
            $stmt->execute();
            $show = true;

        } else {
            // No entries found in the create_group table
        }
    } catch (PDOException $e) {
        // Handle any database errors
        echo "Error: " . $e->getMessage();
    }
}

function callGetGroups($latestStudentNumber, $latestNumberOfGroup, $latestGroupSize, $latestGroupType, $student_ratio)
{
    // Prepare the data for the API call
    $data = array(
        'num_students' => $latestStudentNumber,
        'num_groups' => $latestNumberOfGroup,
        'group_size' => $latestGroupSize,
        'group_preference' => $latestGroupType,
        'ratios' => $student_ratio
    );

    $url = 'http://127.0.0.1:5000/getgroups?' . http_build_query($data);
    $curl = curl_init();


    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => $student_ratio,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        )
    );

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}
// // Retrieve group data
// $sql = "SELECT * FROM `group`";
// $stmt = $conn->prepare($sql);
// $stmt->execute();
// $create_groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

// // Generate Excel file
// if (isset($_POST["export"])) {
//     header('Content-Type: application/xls');
//     header('Content-Disposition: attachment; filename=create_groups.xls');
//     echo "<table border='1'>";
//     echo "<tr><th>FirstName</th><th>LastName</th><th>Group_Number</th><th>survey_ratio</th><th>Type</th><th>";
//     foreach ($groups as $group) {
//         echo "<tr><td>" . $group['FirstName'] . "</td><td>" . $group['LastName'] . "</td><td>" . $group['Group_Number'] . "</td><td>" . $group['survey_ratio'] . "</td><td>" . $group['Type'] . "</td><td>";
//     }
//     echo "</table>";
//     exit();}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Create Group</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">

    <meta name="author" content="Gregory Grenouille /ID - 20384658">
    <meta name="description" content="WEB APPLICATION FOR FORMING STUDENT GROUPS">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="css/styleCreateGroupPage.css">
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
                <li><a href="AboutUs.html">About Us</a></li>
                <li><a href="lecturerDashboard.php">Back</a></li>
            </ul>
        </nav>

    </header> <!--This is the end of the top most header-->

    <!--This is the second header containing the name of the website-->
    <header class="siteheader">
        <div class="site-identity">
            <h3><a href="homePage.php">Intelligent Student Grouping System</a></h3>
        </div>
    </header>

    <!--Main content below-->
    <!--Below is the codes for the main content of the page-->
    <div class="pageContainer">

        <div class="pageTitle"> <!--This will basically holds the container for the page-->
        
        </div>

        <!--Below ia the container for the first box-->
        <div class="firstContainer">
            <h3>Students</h3>

            <form method="POST" action="">
                <label for="unitID">Select Unit:</label>
                <select name="unitID" id="unitID">
                    <?php foreach ($units as $unit): ?>
                        <?php $selected = ($unit['UnitID'] == $_POST['unitID']) ? 'selected' : ''; ?>
                        <option value="<?php echo $unit['UnitID']; ?>" <?php echo $selected; ?>><?php echo $unit['UnitName']; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="studentlist">Get Student List</button>
            </form>


            <div class="boxContainer">
                <section>
                    <p>Total number of students:</p>
                    <div class="box">
                        <P>
                            <?php echo $total_students; ?>
                        </P>
                    </div>
                </section>

                <section>
                    <?php if (isset($students)): ?>
                        <h2>Student List:</h2>
                        <table>
                            <tr>
                                <th>Student ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                            </tr>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td>
                                        <?php echo $student['StudentID']; ?>
                                    </td>
                                    <td>
                                        <?php echo $student['FirstName']; ?>
                                    </td>
                                    <td>
                                        <?php echo $student['LastName']; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                   <?php endif; ?>
                </section>
            </div>
            </section>
        </div>
    </div><!--End of 1st container-->

    <hr>

    <form method="POST" action="">
        <input type="hidden" name="UnitID" value="<?php echo $selected_unit; ?>">
        <div class="secondContainer">
            <h3>Create groups</h3>
            <div class="boxContainerTwo">
                <!--Below i will be separating the box in 3 different section-->
                <div class="columns">
                    <!--1st column-->
                    <div class="column">
                        <div class="row">
                            <div class="containerh4">
                                <label class="labelBox2"> Number of students:</label>
                            </div><br><br>
                            <input class="numericUpDown" readonly type="number" value="<?php echo $total_students; ?>" id="StudentNumber" name="StudentNumber">
                        </div>
                    </div>

                    <!--2nd column-->
                    <div class="column">
                        <div class="row">
                            <div class="containerh4">
                                <label class="labelBox2"> Number of groups:</label>
                            </div><br><br>
                            <input class="numericUpDown" type="number" value="" id="NumberofGroup" name="NumberofGroup"
                                min="1" max="10">
                        </div>
                    </div>

                    <!--3rd column-->
                    <div class="column">
                        <div class="row">
                            <div class="containerh4">
                                <label class="labelBox2"> Group Size:</label>
                            </div><br><br>
                            <input class="numericUpDown" type="number" value="" id="GroupSize" name="GroupSize" min="1"
                                max="10">
                        </div>
                    </div>

                    <!--4rd column-->
                    <div class="column">
                        <div class="row">
                            <div class="containerh4">
                                <label class="labelBox2"> Select Group Type:</label><br><br><br>
                                <select id="GroupType" name="GroupType">
                                    <option value="similar">Similar</option>
                                    <option value="dissimilar">Dissimilar</option>
                                </select>
                            </div><br>
                        </div>
                    </div>

                    <div class="column">
                        <div class="buttonContainer">
                            <!-- <input type="submit" name="submit" value="Submit"> -->
                            <input class="button" type="submit" name="submit_create" value="Create groups">
                        </div>
                    </div>

                </div><br><br> <!--End of the div 'columns'-->
            </div><!--End of the container-->
        </div><!--End of 2nd container-->
    </form>

    <hr>

    <div class="thirdContainer">
        <h3>Groups created as per unit selected</h3>
        <div class="lastBoxContainer">
            <div class="lastBox">
            <h2>Create Groups Table</h2>
                <?php
                if ($show) {
                    $sql_group = "SELECT
                    cg.ratio,
                    cg.StudentNumber AS 'Number of Students in this Group',
                    cg.UnitID,
                    cg.GroupType AS 'Type',
                    s.FirstName,
                    s.LastName,
                    s.UserID,
                    r.ratio AS survey_ratio,
                    u.UnitName
                    FROM
                    create_group cg
                    JOIN Unit u ON cg.UnitID = u.UnitID
                    JOIN stu_unit su ON cg.UnitID = su.UnitID
                    JOIN Student s ON su.UserID = s.UserID
                    JOIN ratio r ON s.UserID = r.UserID
                    WHERE
                    cg.CreationDate = (
                        SELECT MAX(CreationDate)
                        FROM create_group
                    );";
                    $stmt = $conn->prepare($sql_group);
                    //$stmt->bindValue(':latestUnitID', $latestUnitID);
                    $stmt->execute();
                    $result_group = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $group =[];
                    $group_ratio =[];
                    foreach ($result_group as $key => $value) {
                        $ratio_array1 = json_decode($value['ratio'],true);
                        $ratio_array2 = json_decode($ratio_array1,true);
                        $group[$key]['FirstName'] = $value['FirstName'];
                        $group[$key]['LastName'] = $value['LastName'];
                        $group[$key]['survey_ratio']= $value['survey_ratio'];
                        $group[$key]['UnitName'] = $value['UnitName'];
                        $group[$key]['Type'] = $value['Type'];
                        foreach($ratio_array2 as $key_1 => $value_1){
                            $incremental = intval($key_1) +1;
                            $group_ratio['Group_'.$incremental] = $value_1;
                            if((array_search($value['survey_ratio'],$value_1) !== false)){
                                $group[$key]['Group_Number'] = $incremental;
                            }
                        } 
                    }

                    // Prepare the INSERT statement
                    $sql_insert = "INSERT INTO `group` (FirstName, LastName, survey_ratio, UnitName, Type, Group_Number) VALUES (:FirstName, :LastName, :survey_ratio, :UnitName, :Type, :Group_Number)";
                    $stmt_insert = $conn->prepare($sql_insert);

                    // Iterate through the $group array and insert each row
                    foreach ($group as $value) {
                        // Bind the values to the prepared statement
                        $stmt_insert->bindValue(':FirstName', $value['FirstName']);
                        $stmt_insert->bindValue(':LastName', $value['LastName']);
                        $stmt_insert->bindValue(':Group_Number', $value['Group_Number']);
                        $stmt_insert->bindValue(':survey_ratio', $value['survey_ratio']);
                        $stmt_insert->bindValue(':UnitName', $value['UnitName']);
                        $stmt_insert->bindValue(':Type', $value['Type']);

                        // Execute the statement
                        $stmt_insert->execute();
                    }

                    // Prepare the INSERT statement
                    $sql_insert = "INSERT INTO group_ratio (group_name, ratio) VALUES (:group_name, :ratio)";
                    $stmt_insert = $conn->prepare($sql_insert);

                    // Iterate through the group_ratio array and insert each row
                    foreach ($group_ratio as $group_name => $ratio) {
                        // Bind the values to the prepared statement
                        $stmt_insert->bindValue(':group_name', $group_name);
                        $stmt_insert->bindValue(':ratio', implode(", ", $ratio));

                        // Execute the statement
                        $stmt_insert->execute();
                    }

                    // Construct Group view
                    //echo '<table>';
                    //echo "<table border='1' style='margin: 0 auto;'>";
                    echo "<div style='margin-bottom: 20px; text-align: center;'>";
                    echo "<table border='1' style='margin: 0 auto;'>";
                    echo '<tr>';
                    echo '<th>First Name</th>';
                    echo '<th>Last Name</th>';
                    echo '<th>Group Number</th>';
                    echo '<th>Survey Ratio</th>';
                    echo '<th>Unit Name</th>';
                    echo '<th>Type</th>';
                    echo '</tr>';

                    foreach ($group as $key => $value) {
                        echo '<tr>';
                        echo '<td>' . $value['FirstName'] . '</td>';
                        echo '<td>' . $value['LastName'] . '</td>';
                        echo '<td>' . $value['Group_Number'] . '</td>';
                        echo '<td>' . $value['survey_ratio'] . '</td>';
                        echo '<td>' . $value['UnitName'] . '</td>';
                        echo '<td>' . $value['Type'] . '</td>';
                        echo '</tr>';

                        // Retrieve group data
                        $sql = "SELECT * FROM `group`";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $create_groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    echo '</table>';


                    //construct student view
                   // echo '<pre>'.print_r($group,true).'</pre>';
                    // Construct Group Ratio view
                    //echo "<table border='1' style='margin: 0 auto;'>";
                    echo "<div style='margin-top: 20px; text-align: center;'>";
                    echo "<table border='1' style='margin: 0 auto;'>";
                    echo '<tr>';
                    echo '<th>Group Name</th>';
                    echo '<th>Ratio</th>';
                    echo '</tr>';
                   // echo '<pre>'.print_r($group_ratio,true).'</pre>';

                    foreach ($group_ratio as $group_name => $ratio) {
                        echo '<tr>';
                        echo '<td>' . $group_name . '</td>';
                        echo '<td>' . implode(", ", $ratio) . '</td>'; // Convert array to string
                        //echo '<td>' . $ratio . '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                }
                ?>
                <br><br>
                <form method="post" action="">
                 <?php
                 if(!empty($group)){
                    $postvalue = base64_encode(json_encode($group));
                 }
                // Client side
                //$array = json_decode(base64_decode($_POST['result'])); // Server side
                 ?>   
                    <input type="hidden" name="export_value" value="<?php echo $postvalue ?>">
                    <input type="submit" name="export" value="Export to Excel">    
                </form>
            </div>
        </div>
    </div><!--End of third Container-->
    </div>

    <!--FOOTER BELOW-->
    <!--This class below is the main footer which will contain subfooters-->
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
</body>
</html>