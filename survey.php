<?php

// establish connection to database using PDO
include('db_connect.php');
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // select all units from from database
    $stmt = $conn->prepare("SELECT * FROM unit WHERE UnitName = 'UnitName'");
    $stmt->execute();
    $lecturer = $stmt->fetchAll(PDO::FETCH_ASSOC);

session_start();
if (isset($_SESSION['email']) && !empty($_SESSION['email'])){
    $email = $_SESSION['email'];
}else{
    echo($_SESSION['id']);
    header('Location: loginPage.php');
    exit();  
}

$sql_unit = "SELECT * FROM `unit`";
$statement = $conn->prepare($sql_unit);
$statement->execute();
$units = $statement->fetchAll(PDO::FETCH_ASSOC);
if(!empty($_REQUEST['request_type'] )){
$request = $_REQUEST['request_type'];}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   include('db_connect.php');
   // get values from the form
   $gender = $_POST["gender"];
   $major = $_POST["major"];
   $nationality = $_POST["nationality"];
   $q1 = $_POST["q1"];
   $q2 = $_POST["q2"];
   $q3 = $_POST["q3"];
   $q4 = $_POST["q4"];
   $q5 = $_POST["q5"];
   $q6 = $_POST["q6"];
   $q7 = $_POST["q7"];
   $q8 = $_POST["q8"];
   $q9 = $_POST["q9"];
   $q10 = $_POST["q10"];
   $q11 = $_POST["q11"];
   $q12 = $_POST["q12"];
   $q13 = $_POST["q13"];
   $q14 = $_POST["q14"];
   $q15 = $_POST["q15"];
   $q16 = $_POST["q16"];
   $q17 = $_POST["q17"];
   $q18 = $_POST["q18"];
   $q19 = $_POST["q19"];
   $q20 = $_POST["q20"];
   $q21 = $_POST["q21"];
   $q22 = $_POST["q22"];
   $q23 = $_POST["q23"];
   $q24 = $_POST["q24"];
   $q25 = $_POST["q25"];
   $q26 = $_POST["q26"];
   $q27 = $_POST["q27"];
   $q28 = $_POST["q28"];
   $q29 = $_POST["q29"];
   $q30 = $_POST["q30"];
   $q31 = $_POST["q31"];
   $q32 = $_POST["q32"];
   $q33 = $_POST["q33"];
   $q34 = $_POST["q34"];
   $q35 = $_POST["q35"];
   $q36 = $_POST["q36"];
   $q37 = $_POST["q37"];
   $q38 = $_POST["q38"];
   $q39 = $_POST["q39"];
   $q40 = $_POST["q40"];
   $q41 = $_POST["q41"];
   $q42 = $_POST["q42"];
   $q43 = $_POST["q43"];
   $q44 = $_POST["q44"];
   $q45 = $_POST["q45"];
   $q46 = $_POST["q46"];
   $q47 = $_POST["q47"];
   $q48 = $_POST["q48"];
   $q49 = $_POST["q49"];
   $q50 = $_POST["q50"];
   $q51 = $_POST["q51"];
   $q52 = $_POST["q52"];
   $q53 = $_POST["q53"];
   $q54 = $_POST["q54"];
   $q55 = $_POST["q55"];
   $q56 = $_POST["q56"];
   $q57 = $_POST["q57"];
   $q58 = $_POST["q58"];
   $q59 = $_POST["q59"];
   $q60 = $_POST["q60"];
   $q61 = $_POST["q61"];
   $q62 = $_POST["q62"];
   $q63 = $_POST["q63"];
   $q64 = $_POST["q64"];
   $UserID = $_SESSION['id'];



    if(!empty($gender) && !empty($major) && !empty($nationality) && !empty($UserID)){
        $sql = "INSERT INTO stu_survey_personal_data (gender, module, nationality, UserID)
        VALUES (:gender, :module, :nationality, :UserID)";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ':gender' => $gender,
            ':module'     => $major,
            ':nationality'     => $nationality,
            ':UserID'       => $UserID
            ],);
    }else{
        echo 'Error occrured';
    }

   //results d1
   if (!empty($UserID) && is_numeric($UserID) && is_numeric($q1) && is_numeric($q2) && is_numeric($q3) && is_numeric($q4) && is_numeric($q5) && is_numeric($q6)) {
    // Retrieve existing sum for this user, if any
    $sql_1 = "SELECT SUM(q1 + q2 + q3 + q4 + q5 + q6) as total FROM stu_survey_d1 WHERE UserID = :UserID";
    $statement = $conn->prepare($sql_1);
    $statement->execute([':UserID' => $UserID]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $sum_d1 = $result['total'] + ($q1 + $q2 + $q3 + $q4 + $q5 + $q6);
 
    // Update sum for this user
    $sql_1 = "INSERT INTO stu_survey_d1 (UserID, q1, q2, q3, q4, q5, q6, total) VALUES (:UserID, :q1, :q2, :q3, :q4, :q5, :q6, :total)
            ON DUPLICATE KEY UPDATE q1 = :q1, q2 = :q2, q3 = :q3, q4 = :q4, q5 = :q5, q6 = :q6, total = :total";
    $statement = $conn->prepare($sql_1);
    $statement->execute([
        ':UserID' => $UserID,
        ':q1' => $q1,
        ':q2' => $q2,
        ':q3' => $q3,
        ':q4' => $q4,
        ':q5' => $q5,
        ':q6' => $q6,
        ':total' => $sum_d1
    ]);
    } else {
        echo 'Error occurred stu_survey_d1';
    }

    //results d2
    if (!empty($UserID) && is_numeric($UserID) && is_numeric($q7) && is_numeric($q8) && is_numeric($q9) && is_numeric($q10) && is_numeric($q11) && is_numeric($q12) && is_numeric($q13) && is_numeric($q14) && is_numeric($q15) && is_numeric($q16)) {
    // Retrieve existing sum for this user, if any
    $sql_2 = "SELECT SUM(q7 + q8 + q9 + q10 + q11 + q12 + q13 + q14 + q15 + q16) as total FROM stu_survey_d2 WHERE UserID = :UserID";
    $statement = $conn->prepare($sql_2);
    $statement->execute([':UserID' => $UserID]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $sum_d2 = $result['total'] + ($q7 + $q8 + $q9 + $q10 + $q11 + $q12 + $q13 + $q14 + $q15 + $q16);
 
    // Update sum for this user
    $sql_2 = "INSERT INTO stu_survey_d2 (UserID, q7, q8, q9, q10, q11, q12, q13, q14, q15, q16, total) VALUES (:UserID, :q7, :q8, :q9, :q10, :q11, :q12, :q13, :q14, :q15, :q16, :total)
            ON DUPLICATE KEY UPDATE q7 = :q7, q8 = :q8, q9 = :q9, q10 = :q10, q11 = :q11, q12 = :q12, q13 = :q13, q14 = :q14, q15 = :q15, q16 = :q16, total = :total";
    $statement = $conn->prepare($sql_2);
    $statement->execute([
        ':UserID' => $UserID,
        ':q7' => $q7,
        ':q8' => $q8,
        ':q9' => $q9,
        ':q10' => $q10,
        ':q11' => $q11,
        ':q12' => $q12,
        ':q13' => $q13,
        ':q14' => $q14,
        ':q15' => $q15,
        ':q16' => $q16,
        ':total' => $sum_d2
        ]);
   }else{
      echo 'Error occurred stu_survey_d2';
   }

    //results d3
    if (!empty($UserID) && is_numeric($UserID) && is_numeric($q17) && is_numeric($q18) && is_numeric($q19) && is_numeric($q20) && is_numeric($q21) && is_numeric($q22) && is_numeric($q23) && is_numeric($q24)) {
    // Retrieve existing sum for this user, if any
    $sql_3 = "SELECT SUM(q17 + q18 + q19 + q20 + q21 + q22 + q23 + q24) as total FROM stu_survey_d3 WHERE UserID = :UserID";
    $statement = $conn->prepare($sql_3);
    $statement->execute([':UserID' => $UserID]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $sum_d3 = $result['total'] + ($q17 + $q18 + $q19 + $q20 + $q21 + $q22 + $q23 + $q24);
    
    // Update sum for this user
    $sql_3 = "INSERT INTO stu_survey_d3 (UserID, q17, q18, q19, q20, q21, q22, q23, q24, total) VALUES (:UserID, :q17, :q18, :q19, :q20, :q21, :q22, :q23, :q24, :total)
            ON DUPLICATE KEY UPDATE q17 = :q17, q18 = :q18, q19 = :q19, q20 = :q20, q21 = :q21, q22 = :q22, q23 = :q23, q24 = :q24, total = :total";
    $statement = $conn->prepare($sql_3);
    $statement->execute([
        ':UserID' => $UserID,
        ':q17'     => $q17,
        ':q18'     => $q18,
        ':q19'     => $q19,
        ':q20'     => $q20,
        ':q21'     => $q21,
        ':q22'     => $q22,
        ':q23'     => $q23,
        ':q24'     => $q24,
        ':total' => $sum_d3
        ]);
    }else{
        echo 'Error occurred stu_survey_d3';
    }

    //results d4
    if (!empty($UserID) && is_numeric($UserID) && is_numeric($q25) && is_numeric($q26) && is_numeric($q27) && is_numeric($q28) && is_numeric($q29) && is_numeric($q30)) {
    // Retrieve existing sum for this user, if any
    $sql_4 = "SELECT SUM(q25 + q26 + q27 + q28 + q29 + q30) as total FROM stu_survey_d4 WHERE UserID = :UserID";
    $statement = $conn->prepare($sql_4);
    $statement->execute([':UserID' => $UserID]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $sum_d4 = $result['total'] + ($q25 + $q26 + $q27 + $q28 + $q29 + $q30);
    
    // Update sum for this user
    $sql_4 = "INSERT INTO stu_survey_d4 (UserID, q25, q26, q27, q28, q29, q30, total) VALUES (:UserID, :q25, :q26, :q27, :q28, :q29, :q30, :total)
            ON DUPLICATE KEY UPDATE q25 = :q25, q26 = :q26, q27 = :q27, q28 = :q28, q29 = :q29, q30 = :q30, total = :total";
    $statement = $conn->prepare($sql_4);
    $statement->execute([
        ':UserID' => $UserID,
        ':q25'     => $q25,
        ':q26'     => $q26,
        ':q27'     => $q27,
        ':q28'     => $q28,
        ':q29'     => $q29,
        ':q30'     => $q30,
        ':total' => $sum_d4
        ]);
    }else{
        echo 'Error occurred stu_survey_d4';
    }

    //results d5
    if (!empty($UserID) && is_numeric($UserID) && is_numeric($q31) && is_numeric($q32) && is_numeric($q33) && is_numeric($q34) && is_numeric($q35) && is_numeric($q36)) {
    // Retrieve existing sum for this user, if any
    $sql_5 = "SELECT SUM(q31 + q32 + q33 + q34 + q35 + q36) as total FROM stu_survey_d5 WHERE UserID = :UserID";
    $statement = $conn->prepare($sql_5);
    $statement->execute([':UserID' => $UserID]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $sum_d5 = $result['total'] + ($q31 + $q32 + $q33 + $q34 + $q35 + $q36);

    // Update sum for this user
    $sql_5 = "INSERT INTO stu_survey_d5 (UserID, q31, q32, q33, q34, q35, q36, total) VALUES (:UserID, :q31, :q32, :q33, :q34, :q35, :q36, :total)
            ON DUPLICATE KEY UPDATE q31 = :q31, q32 = :q32, q33 = :q33, q34 = :q34, q35 = :q35, q36 = :q36, total = :total";
    $statement = $conn->prepare($sql_5);
    $statement->execute([
        ':UserID' => $UserID,
        ':q31'     => $q31,
        ':q32'     => $q32,
        ':q33'     => $q33,
        ':q34'     => $q34,
        ':q35'     => $q35,
        ':q36'     => $q36,
        ':total' => $sum_d5
    ]);
    }else{
        echo 'Error occurred stu_survey_d5';
        }

    
    //results d6
    if (!empty($UserID) && is_numeric($UserID) && is_numeric($q37) && is_numeric($q38) && is_numeric($q39) && is_numeric($q40) && is_numeric($q41) && is_numeric($q42)) {
    // Retrieve existing sum for this user, if any
    $sql_6 = "SELECT SUM(q37 + q38 + q39 + q40 + q41 + q42) as total FROM stu_survey_d6 WHERE UserID = :UserID";
    $statement = $conn->prepare($sql_6);
    $statement->execute([':UserID' => $UserID]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $sum_d6 = $result['total'] + ($q37 + $q38 + $q39 + $q40 + $q41 + $q42);

    // Update sum for this user
    $sql_6 = "INSERT INTO stu_survey_d6 (UserID, q37, q38, q39, q40, q41, q42, total) VALUES (:UserID, :q37, :q38, :q39, :q40, :q41, :q42, :total)
            ON DUPLICATE KEY UPDATE q37 = :q37, q38 = :q38, q39 = :q39, q40 = :q40, q41 = :q41, q42 = :q42, total = :total";
    $statement = $conn->prepare($sql_6);
    $statement->execute([
        ':UserID' => $UserID,
        ':q37'     => $q37,
        ':q38'     => $q38,
        ':q39'     => $q39,
        ':q40'     => $q40,
        ':q41'     => $q41,
        ':q42'     => $q42,
        ':total' => $sum_d6
    ]);
    }else{
        echo 'Error occurred stu_survey_d6';
        }

    //results d7
    if (!empty($UserID) && is_numeric($UserID) && is_numeric($q43) && is_numeric($q44) && is_numeric($q45) && is_numeric($q46) && is_numeric($q47)) {
    // Retrieve existing sum for this user, if any
    $sql_7 = "SELECT SUM(q43 + q44 + q45 + q46 + q47) as total FROM stu_survey_d7 WHERE UserID = :UserID";
    $statement = $conn->prepare($sql_7);
    $statement->execute([':UserID' => $UserID]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $sum_d7 = $result['total'] + ($q43 + $q44 + $q45 + $q46 + $q47);

    // Update sum for this user
    $sql_7 = "INSERT INTO stu_survey_d7 (UserID, q43, q44, q45, q46, q47, total) VALUES (:UserID, :q43, :q44, :q45, :q46, :q47, :total)
            ON DUPLICATE KEY UPDATE q43 = :q43, q44 = :q44, q45 = :q45, q46 = :q46, q47 = :q47, total = :total";
    $statement = $conn->prepare($sql_7);
    $statement->execute([
        ':UserID' => $UserID,
        ':q43'     => $q43,
        ':q44'     => $q44,
        ':q45'     => $q45,
        ':q46'     => $q46,
        ':q47'     => $q47,
        ':total' => $sum_d7
    ]);
    }else{
        echo 'Error occurred stu_survey_d7';
        }

    //results d8
    if (!empty($UserID) && is_numeric($UserID) && is_numeric($q48) && is_numeric($q49) && is_numeric($q50) && is_numeric($q51) && is_numeric($q52) && is_numeric($q53)) {
    // Retrieve existing sum for this user, if any
    $sql_8 = "SELECT SUM(q48 + q49 + q50 + q51 + q52 + q53) as total FROM stu_survey_d8 WHERE UserID = :UserID";
    $statement = $conn->prepare($sql_8);
    $statement->execute([':UserID' => $UserID]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $sum_d8 = $result['total'] + ($q48 + $q49 + $q50 + $q51 + $q52 + $q53);

    // Update sum for this user
    $sql_8 = "INSERT INTO stu_survey_d8 (UserID, q48, q49, q50, q51, q52, q53, total) VALUES (:UserID, :q48, :q49, :q50, :q51, :q52, :q53, :total)
            ON DUPLICATE KEY UPDATE q48 = :q48, q49 = :q49, q50 = :q50, q51 = :q51, q52 = :q52, q53 = :q53, total = :total";
    $statement = $conn->prepare($sql_8);
    $statement->execute([
        ':UserID' => $UserID,
        ':q48'     => $q48,
        ':q49'     => $q49,
        ':q50'     => $q50,
        ':q51'     => $q51,
        ':q52'     => $q52,
        ':q53'     => $q53,
        ':total' => $sum_d8
    ]);
    }else{
        echo 'Error occurred stu_survey_d8';
        }

    //results d9
    if (!empty($UserID) && is_numeric($UserID) && is_numeric($q54) && is_numeric($q55) && is_numeric($q56) && is_numeric($q57)) {
    // Retrieve existing sum for this user, if any
    $sql_9 = "SELECT SUM(q54 + q55 + q56 + q57) as total FROM stu_survey_d9 WHERE UserID = :UserID";
    $statement = $conn->prepare($sql_9);
    $statement->execute([':UserID' => $UserID]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $sum_d9 = $result['total'] + ($q54 + $q55 + $q56 + $q57);

    // Update sum for this user
    $sql_9 = "INSERT INTO stu_survey_d9 (UserID, q54, q55, q56, q57, total) VALUES (:UserID, :q54, :q55, :q56, :q57, :total)
            ON DUPLICATE KEY UPDATE q54 = :q54, q55 = :q55, q56 = :q56, q57 = :q57, total = :total";
    $statement = $conn->prepare($sql_9);
    $statement->execute([
    ':UserID' => $UserID,
    ':q54'     => $q54,
    ':q55'     => $q55,
    ':q56'     => $q56,
    ':q57'     => $q57,
    ':total' => $sum_d9
    ]);
    }else{
        echo 'Error occurred stu_survey_d9';
        }


    //results d10
    if (!empty($UserID) && is_numeric($UserID) && is_numeric($q58) && is_numeric($q59) && is_numeric($q60) && is_numeric($q61) && is_numeric($q62) && is_numeric($q63) && is_numeric($q64)) {
    // Retrieve existing sum for this user, if any
    $sql_10 = "SELECT SUM(q58 + q59 + q60 + q61 + q62 + q63 + q64) as total FROM stu_survey_d10 WHERE UserID = :UserID";
    $statement = $conn->prepare($sql_10);
    $statement->execute([':UserID' => $UserID]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $sum_d10 = $result['total'] + ($q58 + $q59 + $q60 + $q61 + $q62 + $q63 + $q64);
    
    // Update sum for this user
    $sql_10 = "INSERT INTO stu_survey_d10 (UserID, q58, q59, q60, q61, q62, q63, q64, total) VALUES (:UserID, :q58, :q59, :q60, :q61, :q62, :q63, :q64, :total)
            ON DUPLICATE KEY UPDATE q58 = :q58, q59 = :q59, q60 = :q60, q61 = :q61, q62 = :q62, q63 = :q63, q64 = :q64, total = :total";
    $statement = $conn->prepare($sql_10);
    $statement->execute([
    ':UserID' => $UserID,
    ':q58'     => $q58,
    ':q59'     => $q59,
    ':q60'     => $q60,
    ':q61'     => $q61,
    ':q62'     => $q62,
    ':q63'     => $q63,
    ':q64'     => $q64,
    ':total' => $sum_d10
    ]);
    }else{
        echo 'Error occurred stu_survey_d10';
    }


//sum_d1 to sum_d10
$sum1 = 320;
$sum = $sum_d1 + $sum_d2 + $sum_d3 + $sum_d4 + $sum_d5 + $sum_d6 + $sum_d7 + $sum_d8 + $sum_d9 + $sum_d10;

$ratio = round(($sum / $sum1), 2); // round to 2 decimal places
// $ratio2 = round(($sum_d2 / $sum) * 100, 2);
// $ratio3 = round(($sum_d3 / $sum) * 100, 2);
// $ratio4 = round(($sum_d4 / $sum) * 100, 2);
// $ratio5 = round(($sum_d5 / $sum) * 100, 2);
// $ratio6 = round(($sum_d6 / $sum) * 100, 2);
// $ratio7 = round(($sum_d7 / $sum) * 100, 2);
// $ratio8 = round(($sum_d8 / $sum) * 100, 2);
// $ratio9 = round(($sum_d9 / $sum) * 100, 2);
// $ratio10 = round(($sum_d10 / $sum) * 100, 2);

// output the ratios
//echo "Ratio 1: $ratio% <br>";


// echo "Ratio 2: $ratio2% <br>";
// echo "Ratio 3: $ratio3% <br>";
// echo "Ratio 4: $ratio4% <br>";

// Update sum and ratio for this user in result table
$update = "INSERT INTO ratio (UserID, ratio) VALUES (:UserID, :ratio1) ON DUPLICATE KEY UPDATE ratio = :ratio1";
$statement = $conn->prepare($update);
$statement->execute([
    ':UserID' => $UserID,
    ':ratio1' => $ratio
]);
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width,minimum-scale=1">
      <title>Survey Form</title>
      <link rel="stylesheet"
         href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
      <link rel="stylesheet" href="CSS/style-survey.css">
      <link rel="stylesheet"
         href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
         />
      <link rel="stylesheet" href="CSS/styleSurvey.css">
   </head>
   <header class="siteheadertop">
      <div class="site-identity2">
         <div class="logo">
            <img class="ctilogo" src="images/CTC-LOGO.png">
         </div>
      </div>
   </header>
   <!--This is the end of the top most header-->
   <!--This is the second header containing the name of the website-->
   <header class="siteheader">
      <div class="site-identity">
         <h3><a href="#">Intelligent Students Grouping System</a></h3>
      </div>
      <nav class="headernavigation">
            <ul>
                <li><p> Hello <?php echo $email ?></p></li>
                <li class="back"><a href="studentDashboard.php">Back</a></li>
            </ul>
        </nav>
   </header>
   <br><br>
   <body>
      <form class="survey-form" method="post" action="">
         <div class="step-content current" data-step="1">
            <div class="fields">
               <h1>Dimension Survey<img class="icon1" src="images/puzzle.png"
                     alt="Icon"></h1>
               <div class="question">
                  <label for="gender">
                     <h3>Please state your gender</h3>
                  </label>
                  <div class="gender-options">
                     <input type="radio" id="gender-female" name="gender"
                        value="female">
                     <label for="gender-female">Female</label>
                     <input type="radio" id="gender-male" name="gender"
                        value="male">
                     <label for="gender-male">Male</label>
                  </div>
                  <div id="gender-selection"></div>
               </div>
               <div class="question">
                  <h3>Please state your unit</h3>
                  <div class="options">
                     <select name="major" id="major-select">
                        <option value="" disabled selected>Select Unit</option>
                        <?php
                        foreach ($units as $unit){
                            
                            ?>
                        <option value="<?php echo $unit['UnitName'];
                        ?>">
                        <?php echo $unit['UnitName'];
                        ?>
                        </option>    
                        <?php
                        }
                        ?>
                        <!--<option value="Accounting and Finance">Accounting and
                           Finance</option>
                        <option value="Banking and Finance">Banking and Finance</option>
                        <option value="Business Information technology and
                           systems">Business Information Technology and Systems
                        </option>
                        <option value="Business Law">Business Law</option>
                        <option value="Logistics and Supply Chain Management">Logistics
                           and Supply Chain Management</option>
                        <option value="Business Information Systems">Business
                           Information Systems</option>
                        <option value="Management and Marketing">Management and
                           Marketing</option>
                        <option value="Management and Human Resource
                           Management">Management and Human Resource Management
                        </option>
                        <option value="Marketing">Marketing</option>
                        <option value="Management">Management</option>
                        <option value="Web Media and Marketing Communications">Web
                           Media and Marketing Communications</option>
                        <option value="Information Technology">Information
                           Technology</option>
                        <option value="Psychological Sciences">Psychological
                           Sciences</option>
                        <option value="Web Media and Graphic Communications">Web
                           Media and Graphic Communications</option>
                        <option value="Logistics,Supply Chain Management and
                           Marketing">Logistics,Supply Chain Management and
                           Marketing</option>
                        <option value="Tourism,Hospitality and Marketing">Tourism,Hospitality
                           and Marketing</option>
                        <option value="Digital Experience And Interaction Design
                           Major with Creative Advertising Design Minor">
                           Digital Experience And Interaction Design Major with
                           Creative Advertising Design Minor</option>
                        <option value="Corporate Screen Communications and
                           Digital Experience Communications ">Corporate Screen
                           Communications and Digital Experience Communications
                        </option>-->
                     </select>
                  </div>
                  <div class="selection-display">
                     You selected: <span id="major-display"></span>
                  </div>
               </div>
               <div class="question">
                  <h3>Please indicate your country</h3>
                  <div class="options">
                     <select name="nationality" id="nationality-select">
                        <option value="" disabled selected>Select a Nationality</option>
                        <option value="AF">Afghanistan</option>
                        <option value="AL">Albania</option>
                        <option value="DZ">Algeria</option>
                        <option value="AD">Andorra</option>
                        <option value="AO">Angola</option>
                        <option value="AG">Antigua and Barbuda</option>
                        <option value="AR">Argentina</option>
                        <option value="AM">Armenia</option>
                        <option value="AU">Australia</option>
                        <option value="AT">Austria</option>
                        <option value="AZ">Azerbaijan</option>
                        <option value="BS">Bahamas</option>
                        <option value="BH">Bahrain</option>
                        <option value="BD">Bangladesh</option>
                        <option value="BB">Barbados</option>
                        <option value="BY">Belarus</option>
                        <option value="BE">Belgium</option>
                        <option value="BZ">Belize</option>
                        <option value="BJ">Benin</option>
                        <option value="BT">Bhutan</option>
                        <option value="BO">Bolivia</option>
                        <option value="BA">Bosnia and Herzegovina</option>
                        <option value="BW">Botswana</option>
                        <option value="BR">Brazil</option>
                        <option value="BN">Brunei</option>
                        <option value="BG">Bulgaria</option>
                        <option value="BF">Burkina Faso</option>
                        <option value="BI">Burundi</option>
                        <option value="KH">Cambodia</option>
                        <option value="CM">Cameroon</option>
                        <option value="CA">Canada</option>
                        <option value="CV">Cape Verde</option>
                        <option value="CF">Central African Republic</option>
                        <option value="TD">Chad</option>
                        <option value="CL">Chile</option>
                        <option value="CN">China</option>
                        <option value="CO">Colombia</option>
                        <option value="KM">Comoros</option>
                        <option value="CG">Congo - Brazzaville</option>
                        <option value="CD">Congo - Kinshasa</option>
                        <option value="CR">Costa Rica</option>
                        <option value="HR">Croatia</option>
                        <option value="CU">Cuba</option>
                        <option value="CY">Cyprus</option>
                        <option value="DJ">Djibouti</option>
                        <option value="EG">Egypt</option>
                        <option value="GQ">Equatorial Guinea</option>
                        <option value="ER">Eritrea</option>
                        <option value="ET">Ethiopia</option>
                        <option value="GA">Gabon</option>
                        <option value="GM">Gambia</option>
                        <option value="GH">Ghana</option>
                        <option value="GN">Guinea</option>
                        <option value="GW">Guinea-Bissau</option>
                        <option value="KE">Kenya</option>
                        <option value="LS">Lesotho</option>
                        <option value="LR">Liberia</option>
                        <option value="LY">Libya</option>
                        <option value="MG">Madagascar</option>
                        <option value="MW">Malawi</option>
                        <option value="ML">Mali</option>
                        <option value="MR">Mauritania</option>
                        <option value="MU">Mauritius</option>
                        <option value="YT">Mayotte</option>
                        <option value="MA">Morocco</option>
                        <option value="MZ">Mozambique</option>
                        <option value="NA">Namibia</option>
                        <option value="NE">Niger</option>
                        <option value="NG">Nigeria</option>
                        <option value="RW">Rwanda</option>
                        <option value="RE">Réunion</option>
                        <option value="SH">Saint Helena</option>
                        <option value="SN">Senegal</option>
                        <option value="SC">Seychelles</option>
                        <option value="SL">Sierra Leone</option>
                        <option value="SO">Somalia</option>
                        <option value="ZA">South Africa</option>
                        <option value="SS">South Sudan</option>
                        <option value="SD">Sudan</option>
                        <option value="SZ">Swaziland</option>
                        <option value="ST">São Tomé and Príncipe</option>
                        <option value="TZ">Tanzania</option>
                        <option value="TG">Togo</option>
                        <option value="TN">Tunisia</option>
                        <option value="UG">Uganda</option>
                        <option value="EH">Western Sahara</option>
                        <option value="Wallis and Futuna">Wallis and Futuna</option>
                        <option value="Yemen">Yemen</option>
                        <option value="Zambia">Zambia</option>
                        <option value="Zimbabwe">Zimbabwe</option>
                     </select>
                  </div>
                  <div class="selection-display">
                     You selected: <span id="nationality-display"></span>
                  </div>
               </div>
               <div class="buttons">
                  <a href="#" class="btn" data-set-step="2">Next</a>
               </div>
            </div>
         </div>
         <!-- page 2 -->
         <div class="step-content" data-step="2">
            <div class="fields">
               <h4>On a scale of 1 to 5, rate how far you agree with the
                  following statements</h4>
               <h2><img class="icon2" src="images/reward.png" alt="Icon">Part 1:</h2>
               <div class="question">
                  <h3>I want to perform well in class</h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q1" value="1">
                        <span>1</span>
                     </label>
                     <label for ="radio2">
                        <input type="radio" name="q1" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q1" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q1" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q1" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I want to get a high grade in this unit</h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q2" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q2" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q2" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q2" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q2" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I want to maximise my learning outcomes from this unit</h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q3" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q3" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q3" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q3" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q3" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I want to improve my skill set and expertise via the
                     assessments in this unit
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q4" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q4" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q4" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q4" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q4" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I am hoping to learn from others </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q5" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q5" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q5" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q5" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q5" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I am hoping to share my knowledge with others</h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q6" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q6" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q6" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q6" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q6" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="buttons">
                  <a href="#" class="btn alt" data-set-step="1">Prev</a>
                  <a href="#" class="btn" data-set-step="3">Next</a>
               </div>
            </div>
         </div>
         <!--page 3-->
         <div class="step-content" data-step="3">
            <div class="fields">
               <h2><img class="icon2" src="images/personality.png" alt="Icon">Part 2:</h2>
               <div class="question">
                  <h3>I enjoy being part of a group </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q7" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q7" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q7" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q7" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q7" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I get upset easily</h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q8" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q8" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q8" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q8" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q8" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I have a low opinion of myself</h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q9" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q9" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q9" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q9" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q9" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I believe that other have good intentions</h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q10" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q10" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q10" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q10" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q10" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I have a natural talent for influencing people</h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q11" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q11" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q11" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q11" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q11" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I am always prepared</h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q12" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q12" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q12" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q12" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q12" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I try to anticipate the needs of other</h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q13" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q13" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q13" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q13" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q13" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I can be trusted to keep my promises
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q14" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q14" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q14" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q14" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q14" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I love to help others</h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q15" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q15" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q15" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q15" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q15" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I set high standards for myself
                     and others
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q16" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q16" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q16" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q16" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q16" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="buttons">
                  <a href="#" class="btn alt" data-set-step="2">Prev</a>
                  <a href="#" class="btn" data-set-step="4">Next</a>
               </div>
            </div>
         </div>
         <!--page 4-->
         <div class="step-content" data-step="4">
            <div class="fields">
               <h2><img class="icon2" src="images/leadership.png" alt="Icon">Part 3:</h2>
               <div class="question">
                  <h3> I set up goals and targets
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q17" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q17" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q17" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q17" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q17" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I respond fairly to the
                     issues in a team
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q18" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q18" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q18" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q18" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q18" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I am open to
                     suggestions from team members
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q19" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q19" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q19" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q19" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q19" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I am willing to
                     take responsibility when a
                     team member fails to deliver
                     against expectations
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q20" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q20" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q20" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q20" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q20" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I believe
                     that providing guidance
                     without any pressure is
                     a good trait of a good
                     leader
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q21" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q21" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q21" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q21" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q21" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3> I think
                     that a leader must
                     not hold grudges
                     against anyone in
                     the team
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q22" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q22" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q22" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q22" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q22" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I am
                     good at adapting
                     to different
                     situations
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q23" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q23" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q23" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q23" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q23" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I love
                     helping
                     other people
                     to develop
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q24" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q24" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q24" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q24" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q24" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="buttons">
                  <a href="#" class="btn alt" data-set-step="3">Prev</a>
                  <a href="#" class="btn" data-set-step="5">Next</a>
               </div>
            </div>
         </div>
         <!--page 5-->
         <div class="step-content" data-step="5">
            <div class="fields">
               <h2><img class="icon2" src="images/writing.png" alt="Icon">Part 4:</h2>
               <div class="question">
                  <h3> I
                     find
                     that I
                     can
                     express
                     my
                     thoughts
                     well in
                     writing
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q25" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q25" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q25" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q25" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q25" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>
                     I
                     review
                     my
                     writing
                     for
                     grammatical
                     errors
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q26" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q26" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q26" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q26" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q26" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>
                     I
                     have
                     someone
                     else
                     read
                     my
                     written
                     work
                     and
                     consider
                     their
                     suggestions
                     for
                     improved
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q27" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q27" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q27" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q27" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q27" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     am
                     comfortable
                     using
                     library
                     resources
                     for
                     research.
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q28" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q28" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q28" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q28" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q28" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>
                     I
                     can
                     narrow
                     a
                     topic
                     for
                     an
                     essay,
                     research
                     paper,
                     etc.
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q29" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q29" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q29" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q29" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q29" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I allow sufficient time to collect information, organize
                     material, and write the assignment.
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q30" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q30" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q30" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q30" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q30" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="buttons">
                  <a href="#" class="btn alt" data-set-step="4">Prev</a>
                  <a href="#" class="btn" data-set-step="6">Next</a>
               </div>
            </div>
         </div>
         <!--page 6-->
         <div class="step-content" data-step="6">
            <div class="fields">
               <h2> <img class="icon2" src="images/software.png" alt="Icon">
                 Part 5:
               </h2>
               <div class="question">
                  <h3>
                     I
                     have
                     a
                     strong
                     knowledge
                     of
                     word
                     processing
                     applications
                     such
                     as
                     Word
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q31" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q31" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q31" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q31" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q31" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     have
                     a
                     strong
                     knowledge
                     of
                     spreadsheets
                     such
                     as
                     Excel
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q32" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q32" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q32" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q32" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q32" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     have
                     a
                     strong
                     knowledge
                     of
                     graphic
                     applications
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q33" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q33" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q33" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q33" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q33" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     have
                     a
                     strong
                     knowledge
                     of
                     statistics
                     applications
                     such
                     as
                     SPSS.
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q34" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q34" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q34" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q34" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q34" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     have
                     a
                     strong
                     knowledge
                     of
                     presentation
                     applications
                     such
                     as
                     PowerPoint.
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q35" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q35" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q35" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q35" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q35" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     have
                     a
                     strong
                     knowledge
                     of
                     electronic
                     presentations.
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q36" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q36" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q36" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q36" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q36" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="buttons">
                  <a href="#" class="btn alt" data-set-step="5">Prev</a>
                  <a href="#" class="btn" data-set-step="7">Next</a>
               </div>
            </div>
         </div>
         <!--page 7-->
         <div class="step-content" data-step="7">
            <div class="fields">
               <h2><img class="icon2" src="images/planning.png" alt="Icon">Part 6:
               </h2>
               <div class="question">
                  <h3>
                     I
                     arrive
                     at
                     classes
                     and
                     other
                     meetings
                     on
                     time.
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q37" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q37" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q37" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q37" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q37" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     devote
                     sufficient
                     study
                     time
                     to
                     each
                     of
                     my
                     courses.
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q38" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q38" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q38" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q38" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q38" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>
                     I
                     schedule
                     definite
                     times
                     and
                     outline
                     specific
                     goals
                     for
                     my
                     study
                     time.
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q39" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q39" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q39" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q39" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q39" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     prepare
                     a
                     “to
                     do”
                     list
                     daily.
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q40" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q40" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q40" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q40" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q40" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     avoid
                     activities
                     which
                     tend
                     to
                     interfere
                     with
                     my
                     planned
                     schedule.
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q41" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q41" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q41" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q41" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q41" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     begin
                     major
                     course
                     assignments
                     well
                     in
                     advance
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q42" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q42" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q42" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q42" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q42" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="buttons">
                  <a href="#" class="btn alt" data-set-step="6">Prev</a>
                  <a href="#" class="btn" data-set-step="8">Next</a>
               </div>
            </div>
         </div>
         <!--page 8-->
         <div class="step-content" data-step="8">
            <div class="fields">
               <h2><img class="icon2" src="images/number.png" alt="Icon">
               Part 7:
               </h2>
               <div class="question">
                  <h3>I
                     feel
                     comfortable
                     to
                     perform
                     simple
                     calculations
                     (additions,
                     subtractions..)
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q43" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q43" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q43" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q43" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q43" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     feel
                     comfortable
                     to
                     perform
                     calculations
                     that
                     require
                     multiple
                     steps
                     and
                     operations
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q44" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q44" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q44" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q44" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q44" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     feel
                     comfortable
                     to
                     create
                     and
                     balance
                     a
                     budget
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q45" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q45" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q45" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q45" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q45" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     can
                     make
                     accurate
                     estimations
                     when
                     information
                     is
                     limited
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q46" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q46" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q46" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q46" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q46" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     feel
                     comfortable
                     to
                     perform
                     advanced
                     calculations
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q47" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q47" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q47" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q47" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q47" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="buttons">
                  <a href="#" class="btn alt" data-set-step="7">Prev</a>
                  <a href="#" class="btn" data-set-step="9">Next</a>
               </div>
            </div>
         </div>
         <!--page 9-->
         <div class="step-content" data-step="9">
            <div class="fields">
               <h2><img class="icon2" src="images/research.png" alt="Icon">
               Part 8:
               </h2>
               <div class="question">
                  <h3>
                     I
                     am
                     aware
                     I
                     can
                     get
                     information
                     via
                     various
                     sources
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q48" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q48" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q48" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q48" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q48" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>
                     I
                     use
                     other
                     sources
                     (for
                     research)
                     beyond
                     the
                     ones
                     provided
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q49" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q49" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q49" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q49" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q49" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     evaluate
                     accuracy
                     of
                     content
                     by
                     reading
                     other
                     sources
                     mentioned
                     by
                     the
                     author
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q50" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q50" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q50" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q50" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q50" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     can
                     combine
                     ideas
                     from
                     one
                     source
                     or
                     more
                     to
                     form
                     a
                     new
                     idea
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q51" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q51" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q51" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q51" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q51" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     can
                     find
                     information
                     online
                     easily
                     via
                     multiple
                     sources
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q52" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q52" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q52" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q52" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q52" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     will
                     review
                     my
                     research
                     strategy
                     when
                     I
                     do
                     not
                     find
                     the
                     right
                     information
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q53" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q53" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q53" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q53" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q53" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="buttons">
                  <a href="#" class="btn alt" data-set-step="8">Prev</a>
                  <a href="#" class="btn" data-set-step="10">Next</a>
               </div>
            </div>
         </div>
         <!--page 10-->
         <div class="step-content" data-step="10">
            <div class="fields">
               <h2><img class="icon2" src="images/knowledge.png" alt="Icon">
               Part 9:
               </h2>
               <div class="question">
                  <h3>I
                     am
                     familiar
                     with
                     the
                     key
                     topics
                     in
                     this
                     unit
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q54" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q54" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q54" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q54" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q54" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     am
                     confident
                     on
                     my
                     skills
                     and
                     expertise
                     in
                     this
                     field
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q55" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q55" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q55" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q55" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q55" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>
                     I
                     have
                     worked
                     on
                     a
                     similar
                     unit/topic
                     before
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q56" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q56" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q56" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q56" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q56" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     feel
                     I
                     have
                     sufficient
                     knowledge
                     on
                     this
                     topic
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q57" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q57" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q57" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q57" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q57" value="5">
                        <span>5</span>
                     </label>
                  </div>
                  <div class="buttons">
                     <a href="#" class="btn alt" data-set-step="9">Prev</a>
                     <a href="#" class="btn" data-set-step="11">Next</a>
                  </div>
               </div>
            </div>
         </div>
         <!--page 11-->
         <div class="step-content" data-step="11">
            <div class="fields">
               <h2> <img class="icon2" src="images/creativity.png" alt="Icon">Part 10:
               </h2>
               <div class="question">
                  <h3>
                     I
                     can
                     easily
                     come
                     up
                     with
                     new
                     ideas
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q58" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q58" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q58" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q58" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q58" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>
                     I
                     can
                     think
                     out
                     of
                     the
                     box
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q59" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q59" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q59" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q59" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q59" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>
                     I
                     like
                     to
                     be
                     unconventional
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q60" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q60" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q60" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q60" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q60" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>I
                     am
                     curious
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q61" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q61" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q61" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q61" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q61" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>
                     I
                     like
                     to
                     ask
                     questions
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q62" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q62" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q62" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q62" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q62" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>
                     I
                     view
                     failure
                     as
                     an
                     opportunity
                     to
                     learn
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q63" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q63" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q63" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q63" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q63" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="question">
                  <h3>
                     I
                     like
                     to
                     experiement
                     and
                     try
                     new
                     things
                  </h3>
                  <div class="options">
                     <label>
                        <input type="radio" name="q64" value="1">
                        <span>1</span>
                     </label>
                     <label>
                        <input type="radio" name="q64" value="2">
                        <span>2</span>
                     </label>
                     <label>
                        <input type="radio" name="q64" value="3">
                        <span>3</span>
                     </label>
                     <label>
                        <input type="radio" name="q64" value="4">
                        <span>4</span>
                     </label>
                     <label>
                        <input type="radio" name="q64" value="5">
                        <span>5</span>
                     </label>
                  </div>
               </div>
               <div class="buttons">
                  <a href="studentDashboard.php" class="btn alt" data-set-step="10">Prev</a>
                  <input type="submit" class="btn" name="submit" value="Submit" onclick="popUp()">
               </div>
            </div>
         </div>
         <!-- page 12 -->
         <div class="step-content" data-step="12">
            <div class="result"><?=$response?></div>
            </div>
      </form>

      <script src="js/scriptSurvey.js"></script>
      <script src="js/scriptSurvey-php.js"></script>

      <!--Greg script below -->
      <!-- <script src="js/scriptPopUpRatio.js">var ratio = "<?= $ratio ?>"</script> -->
      <script>
      var ratio = "<?= $ratio ?>";
      alert("Thank you for completing the survey!");
      </script>

   </body>
   </html>