<?php
// establish connection to database using PDO
include('db_connect.php');
try {
  $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  die;
}

$stmt = $conn->prepare("SELECT
    (SELECT SUM(q1 + q2 + q3 + q4 + q5 + q6) FROM stu_survey_d1 WHERE UserID = 1041) AS D1,
    (SELECT SUM(q7 + q8 + q9 + q10 + q11 + q12 + q13 + q14 + q15 + q16) FROM stu_survey_d2 WHERE UserID = 1041) AS D2,
    (SELECT SUM(q17 + q18 + q19 + q20 + q21 + q22 + q23 + q24) FROM stu_survey_d3 WHERE UserID = 1041) AS D3,
    (SELECT SUM(q25 + q26 + q27 + q28 + q29 + q30) FROM stu_survey_d4 WHERE UserID = 1041) AS D4,
    (SELECT SUM(q31 + q32 + q33 + q34 + q35 + q36) FROM stu_survey_d5 WHERE UserID = 1041) AS D5,
    (SELECT SUM(q37 + q38 + q39 + q40 + q41 + q42) FROM stu_survey_d6 WHERE UserID = 1041) AS D6,
    (SELECT SUM(q43 + q44 + q45 + q46 + q47) FROM stu_survey_d7 WHERE UserID = 1041) AS D7,
    (SELECT SUM(q48 + q49 + q50 + q51 + q52 + q53) FROM stu_survey_d8 WHERE UserID = 1041) AS D8,
    (SELECT SUM(q54 + q55 + q56 + q57) FROM stu_survey_d9 WHERE UserID = 1041) AS D9,
    (SELECT SUM(q58 + q59 + q60 + q61 + q62 + q63 + q64) FROM stu_survey_d10 WHERE UserID = 1041) AS D10");

$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


$chart_data = array();
foreach ($data[0] as $dimension => $score) {
    $chart_data[] = array($dimension, $score, '#b87333');
}
echo($score);
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Dimensions', 'Scores', { role: 'style' }],
      <?php 
        foreach ($chart_data as $row) {
            echo "['{$row[0]}', {$row[1]}, '{$row[2]}'],";
        }
      ?>
    ]);

    var options = {
      title: 'Survey Results for User 1041',
      width: 900,
      height: 500,
      bar: {groupWidth: "95%"},
    };

    var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
      chart.draw(view, options);
  }
  </script>
<div id="barchart_values" style="width: 900px; height: 300px;"></div>
