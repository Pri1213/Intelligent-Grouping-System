<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!--css link-->
    <link rel="stylesheet" type="text/css" href="styleHomePage.css">

    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <!-- font link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@900&family=Poppins:wght@700;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

    <!--Font Awesome cdn font icons css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


</head>

<body>
    <!--Header section-->
    <!-- Contains a navbar which allows the user to navigate through the website: home page, about me page, projects page and contact me page and reflection page -->
    <!-- Navigation bar -->
    <header class="header">
        <!-- Logo -->
        <a href="#" class="logo">ISGS</a>
        <!-- Hamburger icon -->
        <input class="side-menu" type="checkbox" id="side-menu">
        <label class="hamb" for="side-menu"><span class="hamb-line"></span></label>
        <!-- Menu -->
        <nav class="nav">
            <ul class="menu">
                <li><a class="login">Login &nbsp</a></li>
                <li><a href="loginPage.php">Student</a></li>
                <li><a href="loginPageLecturer.php">Lecturer</a></li>
                <li><a href="loginPageAdmin.php">Admin</a></li>
            </ul>
        </nav>
    </header>

    <!--Home Page section-->
    <section class="mainContent">
        <section class="home" id="home">
            <div class="home-text">
                <h5>WELCOME TO</h5>
                <h1>Intelligent Student Grouping System</h1>
                <h6>YOUR <span>GATEWAY</span> TO</h6>
                <p>Intelligent Student Grouping System's purpose is to help lecturers to form groups for their modules
                    based on an innovative student dimension analysis. Hence, using this AI integrated web application
                    will allow the effective formation of groups using
                    key student insights.</p>

             
            </div>


            <div class="home-img">
                <div class="staffPortal">
                    <h2>You a new student here?<h2>
                            <h2>Sign-Up <a class="here" href="signUpPage.php?formtype=student">HERE</a></h2><br>
                            <p>
                                If you are a first-time user, you can sign up here to gain access.
                                By signing up, you will be able to explore a variety of resources and tools,
                                including your own student dashboard and other useful information.
                            </p>
                </div>
            </div>
        </section><br><br>

        <div class="columns">
            <div class="column">
                <!--<div class="row">
                    <h2>Values</h2><br>
                    <p>Our five core values are integrity, respect, courage, excellence and impact.</p>
                </div>
            </div>

            <div class="column">
                <div class="row">
                    <h2>Vision</h2><br>
                    <p>A recognised global leader in research, education and engagement, Curtin will be a beacon for positive change, 
                        embracing the challenges and opportunities of our times to advance understanding and change lives for the better.</p>
                </div>
            </div>

            <div class="column">
                <div class="row">
                    <h2>Top 1 percent</h2><br>
                    <p>With Curtin ranked in the top one per cent of universities worldwide in the 
                        highly regarded Academic Ranking of World Universities (ARWU) 2021,
                    you’ll experience high-quality teaching alongside world-class research.</p>
                </div>
            </div>-->
            </div>
    </section><br><br><br><br><br><br><br>
    <!--Home page section ends-->

    <hr class="hr">

    <!--Here is the footer section for the webpage-->
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

    <!--ScrollReveal link-->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!-- Js link-->
    <script src="script.js"></script>
</body>

</html>