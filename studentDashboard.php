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

    $stmt = $conn->prepare("SELECT 
        SUM(d1.q1 + d1.q2 + d1.q3 + d1.q4 + d1.q5 + d1.q6) AS D1,
        SUM(d2.q7 + d2.q8 + d2.q9 + d2.q10 + d2.q11 + d2.q12 + d2.q13 + d2.q14 + d2.q15 + d2.q16) AS D2,
        SUM(d3.q17 + d3.q18 + d3.q19 + d3.q20 + d3.q21 + d3.q22 + d3.q23 + d3.q24) AS D3,
        SUM(d4.q25 + d4.q26 + d4.q27 + d4.q28 + d4.q29 + d4.q30) AS D4,
        SUM(d5.q31 + d5.q32 + d5.q33 + d5.q34 + d5.q35 + d5.q36) AS D5,
        SUM(d6.q37 + d6.q38 + d6.q39 + d6.q40 + d6.q41 + d6.q42) AS D6,
        SUM(d7.q43 + d7.q44 + d7.q45 + d7.q46 + d7.q47) AS D7,
        SUM(d8.q48 + d8.q49 + d8.q50 + d8.q51 + d8.q52 + d8.q53) AS D8,
        SUM(d9.q54 + d9.q55 + d9.q56 + d9.q57) AS D9,
        SUM(d10.q58 + d10.q59 + d10.q60 + d10.q61 + d10.q62 + d10.q63 + d10.q64) AS D10
    FROM stu_survey_d1 d1
    JOIN stu_survey_d2 d2 ON d1.UserID = d2.UserID
    JOIN stu_survey_d3 d3 ON d1.UserID = d3.UserID
    JOIN stu_survey_d4 d4 ON d1.UserID = d4.UserID
    JOIN stu_survey_d5 d5 ON d1.UserID = d5.UserID
    JOIN stu_survey_d6 d6 ON d1.UserID = d6.UserID
    JOIN stu_survey_d7 d7 ON d1.UserID = d7.UserID
    JOIN stu_survey_d8 d8 ON d1.UserID = d8.UserID
    JOIN stu_survey_d9 d9 ON d1.UserID = d9.UserID
    JOIN stu_survey_d10 d10 ON d1.UserID = d10.UserID
    WHERE d1.UserID = ?");
    
    $stmt->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

}  catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styleStudentDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
</head>

<body>
    <!--Below I will add a header for the login page-->
    <!--Below is the header containing the curtinlogo-->
    <header class="siteheadertop">
        <div class="site-identity2">
            <div class="logo">
                <img class="ctilogo" src="images/CTC-LOGO.png">
            </div>
        </div>

        <nav class="headernavigation">
            <ul>
                <li><a href="AboutUs.html">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><p> Hello <?php echo $email ?></p></li>
                <li class="logout"><a href="loginPage.php?status=logout">Log out</a></li>
            </ul>
        </nav>

    </header> <!--This is the end of the top most header-->
    <!--This is the second header containing the name of the website-->
    <header class="siteheader">
        <div class="site-identity">
            <h3><a href="#">Student Dashboard</a></h3>
        </div>
    </header>
    <!-- Add the welcome message here -->
    <div class="welcome-message">
        <br>
        <h2> Welcome to your dashboard! <img class="image-dashboard" src="images/dashboard.png" alt="Dashboard"></h2>
    </div>

    <div class="bottom-container">  

        <div class="box3">
          <canvas id="line-chart" width="500" height="400"></canvas>
        </div>

        <div class="box4">
            <img class="img1" src="images/survey.png" alt="Survey pic">
            <h4>Know yourself more! Learn about your different Dimensions.</h4>
            <h4>A better grouping system with ISGS.</h4>
            <!--Below is the code to click sipaki-->
            <form action="">
                <a href="survey.php" class="button">Take Survey</a>
            </form>
        </div>

        <div class="box3">
        <canvas id="radar-chart"></canvas>
        </div>
    </div>

    <div class="container">
        <div class="title">Dimensions</div>
        <div class="box1">
            <div class="round-box motivation" onclick="window.location='https://www.curtin.edu.au/news/media-release/no-pain-no-gain-not-answer-exercise-motivation/';">
                <img class="img"  src="images/reward.png" alt="Motivation">
                <div class="text">Motivation</div>
            </div>

            <div class="round-box personality" onclick="window.location='https://www.curtin.edu.au/news/media-release/curtin-research-shows-personality-traits-influence-investment-decisions/';">
                <img class="img" src="images/personality.png" alt="Personality">   
                <div class="text">Personality</div>
            </div>

            <div class="round-box leadership" onclick="window.location='https://www.curtin.edu.au/students/experience/leadership/curtin-leaders-program/';">
                <img class="img" src="images/leadership.png" alt="Leadership">
                <div class="text">Leadership Preferences</div>
            </div>

            <div class="round-box writing" onclick="window.location='https://uniskills.library.curtin.edu.au/assignment/writing/introduction/';">
                <img class="img" src="images/writing.png" alt="Writing Skills">  
                <div class="text">Writing Skills</div>
            </div>

            <div class="round-box software" onclick="window.location='https://23things.library.curtin.edu.au/';">
                <img class="img" src="images/software.png" alt="Software Skills">
                <div class="text">Software Skills</div>
            </div>

            <div class="round-box planning" onclick="window.location='https://www.youtube.com/watch?v=PrdbZMYiEY8';">
                <img class="img" src="images/planning.png" alt="Planning Skills">
                <div class="text">Organisation and Planning Skills</div>
            </div>

            <div class="round-box numeracy" onclick="window.location='https://uniskills.library.curtin.edu.au/numeracy/numeracy-fundamentals/introduction/';">
                <img class="img" src="images/number.png" alt="Numeracy Skills">
                <div class="text">Numeracy Skills</div>
            </div>

            <div class="round-box research" onclick="window.location='https://www.youtube.com/watch?v=KteXhdNujhw';">
                <img class="img" src="images/research.png" alt="Research Skills">
                <div class="text">Research Skills</div>
            </div>

            <div class="round-box knowledge" onclick="window.location='https://challenge.curtin.edu.au/';">
                <img class="img" src="images/knowledge.png" alt="Knowledge Skills">
                <div class="text">Knowledge Skills</div>
            </div>

            <div class="round-box creativity" onclick="window.location='https://youtu.be/i1E1rU4zOHU';">
                <img class="img" src="images/creativity.png" alt="Creativity">
                <div class="text">Creativity</div>
            </div>
        </div>
    </div>
    <br><br>


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
                        <span class="text1">Moka, Mauritius</span>
                    </div>

                    <div class="phone">
                        <span class="fas fa-phone-alt"></span>
                        <span class="text1">+230 4016526</span>
                    </div>

                    <div class="email">
                        <span class="fas fa-envelope"></span>
                        <span class="text1"> ctcentre@telfair.ac.mu</span>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
</body>
<script>
        var ctx = document.getElementById('line-chart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Motivation', 'Personality', 'Leadership Preferences', 'Writing Skills', 'Software Skills', 'Organisation Skills', 'Numeracy Skills', 'Research Skills', 'Knowledge Skills', 'Creativity Skills'],
                datasets: [{
                    label: 'Survey Results',
                    data: [<?php echo $result['D1']; ?>, <?php echo $result['D2']; ?>, <?php echo $result['D3']; ?>, <?php echo $result['D4']; ?>, <?php echo $result['D5']; ?>, <?php echo $result['D6']; ?>, <?php echo $result['D7']; ?>, <?php echo $result['D8']; ?>, <?php echo $result['D9']; ?>, <?php echo $result['D10']; ?>],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    pointBackgroundColor: function(context) {
                        var index = context.dataIndex;
                        var value = context.dataset.data[index];
                        return value > 50 ? 'green' : 'red'; // change color based on data value
                    },
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    pointHitRadius: 10
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                animation: {
                    duration: 2000, // animate for 2 seconds
                    easing: 'easeInOutQuart' // use easeInOutQuart animation
                }
            }
        });
    </script>
     <script>
        var ctx = document.getElementById('radar-chart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['D1', 'D2', 'D3', 'D4', 'D5', 'D6', 'D7', 'D8', 'D9', 'D10'],
                datasets: [{
                    label: 'Dimension Analysis',
                    data: [<?php echo $result['D1']; ?>, <?php echo $result['D2']; ?>, <?php echo $result['D3']; ?>, <?php echo $result['D4']; ?>, <?php echo $result['D5']; ?>, <?php echo $result['D6']; ?>, <?php echo $result['D7']; ?>, <?php echo $result['D8']; ?>, <?php echo $result['D9']; ?>, <?php echo $result['D10']; ?>],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                scale: {
                    ticks: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</html>