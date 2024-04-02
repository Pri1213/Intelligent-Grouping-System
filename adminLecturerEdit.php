<?php
$userID = $_GET['id'];
// establish connection to database using PDO
include('db_connect.php');

$conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// select all units from from database
$sql_unit = "SELECT * FROM `unit`";
$statement = $conn->prepare($sql_unit);
$statement->execute();
$units = $statement->fetchAll(PDO::FETCH_ASSOC);
// select unit names for the UserID currently in session
$sql = "SELECT u.UnitName FROM unit u JOIN lec_unit lu ON u.UnitID = lu.UnitID WHERE lu.UserID = :userID;";
$statement = $conn->prepare($sql);
$statement->bindParam(":userID", $userID);
$statement->execute();
$unitNames = $statement->fetchAll(PDO::FETCH_COLUMN);
if (isset($_GET['add_unit'])) {
  $userID = $_GET['id'];
  $unitID = $_GET['unit'];
  // Check if the user has already added this unit
  $sql_check = "SELECT COUNT(*) FROM lec_unit WHERE UserID = :userID AND UnitID = :unitID";
  $statement_check = $conn->prepare($sql_check);
  $statement_check->bindParam(":userID", $userID);
  $statement_check->bindParam(":unitID", $unitID);
  $statement_check->execute();
  $count = $statement_check->fetchColumn();

  if ($count == 0) {
    $sql = "INSERT INTO lec_unit (UserID, UnitID) VALUES (:userID, :unitID)";
    $statement = $conn->prepare($sql);
    $statement->bindParam(":userID", $userID);
    $statement->bindParam(":unitID", $unitID);
    $statement->execute();
    $unitName = $_GET['unitName'];
    $selected_units = "<ul><li>$unitName</li></ul>";
  }
  header('Location:adminLecturerEdit.php?id=' . $userID);
  ;
}
if (isset($_GET['remove_unit'])) {
  $userID = $_GET['id'];
  $unitID = $_GET['unit'];

  $sql = "DELETE FROM lec_unit WHERE UserID = :userID AND UnitID = :unitID";
  $statement = $conn->prepare($sql);
  $statement->bindParam(":userID", $userID);
  $statement->bindParam(":unitID", $unitID);
  $statement->execute();

  header('Location:adminLecturerEdit.php?id=' . $userID);
  ;
}
if (isset($_GET['edit_status'])) {
  $status = $_GET['status'];

  // Update the status in the database
  $sql_update = "UPDATE user SET Status = :status WHERE UserID = :userID";
  $statement_update = $conn->prepare($sql_update);
  $statement_update->bindParam(":status", $status);
  $statement_update->bindParam(":userID", $userID);
  $statement_update->execute();

  // Redirect back to the page
  header('Location:adminLecturerEdit.php?id=' . $userID);
  exit();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>edit lecturer module </title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/styleAdminDashboard.css">
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
          <p> Modifying Lecturer
            <?php echo $userID ?>
          </p>
        </li>
        <li><a href="adminDashLecturer.php">Back</a></li>
        <li class="logout"><a href="loginPageAdmin.php?status=logout">Log out</a></li>
      </ul>
    </nav>

  </header> <!--This is the end of the top most header-->

  <!--This is the second header containing the name of the website-->
  <header class="siteheader">
    <div class="site-identity">
      <h3><a href="#">Admin Dashboard</a></h3>
    </div>
  </header>
  <div class="container">
    <br>
    <h1>Lecturer Unit Selection Form</h1>
    <form method="GET" action="adminLecturerEdit.php">
      <div class="form-group">
        <label for="unit">Select a unit:</label>
        <select class="form-control" id="unit" name="unit">
          <?php
          foreach ($units as $unit) {
            ?>
            <option value="<?php echo $unit['UnitID']; ?>">
              <?php echo $unit['UnitName']; ?>
            </option>
            <?php
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="user-units">Units:</label>
        <div class="border p-2" id="user-unitss">
          <?php
          // display unit names in a box
          if (count($unitNames) > 0) {
            echo "<ul>";
            foreach ($unitNames as $unitName) {
              echo "<li>$unitName</li>";
            }
            echo "</ul>";
          } else {
            echo "No units found for this user.";
          }
          ?>
        </div>
      </div>
      <input type="hidden" name="id" value="<?php echo $userID; ?>">
      <button type="submit" class="btn btn-primary" name="add_unit">Add Unit</button>
      <button type="submit" class="btn btn-danger" name="remove_unit">Remove Unit</button>
      <div class="form-group">
        <label for="status">Status:</label>
        <select class="form-control" id="status" name="status">
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
      </div>
      <button type="submit" class="btn btn-danger" name="edit_status">Change Status</button>
    </form>
  </div>
  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
</body>

</html>