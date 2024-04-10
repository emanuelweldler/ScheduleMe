<?php
include ('../dbConn/dbConn.php');
include ('../theHead/header.php');
//include('../datePicker/datePicker.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION["username"])) {
    // Redirect to the login page
    header("Location: ../logIn/logIn.php");
    exit; // Stop execution to prevent the rest of the script from running
}
if (isset($_SESSION["facility"]) && isset($_SESSION['username'])) {
    // Grab the facility value from the session variable
    $username = $_SESSION['username'];
    $facility = $_SESSION["facility"];
    //echo $facility;
} else {
    // Facility not set in session
    echo "Facility information not available.";
}
$today_date = date("Y-m-d");

// Retrieve shifts for today from the database
$sql = "SELECT * FROM daily WHERE dateOfSched = '$today_date'";
$result = $conn->query($sql);

// Define the required number of slots for each position
$num_nurses = 3;
$num_lpns = 3;
$num_gnas = 3;

// Initialize arrays for each shift time
$shift1 = array_fill(0, $num_nurses + $num_lpns + $num_gnas, null);
$shift2 = array_fill(0, $num_nurses + $num_lpns + $num_gnas, null);
$shift3 = array_fill(0, $num_nurses + $num_lpns + $num_gnas, null);

// Check if there are shifts scheduled for today
if ($result->num_rows > 0) {
    // Organize shifts into separate arrays based on shift start time and position
    while ($row = $result->fetch_assoc()) {
        switch ($row["shift_start_time"]) {
            case "07:00:00":
                organizeShift($shift1, $row);
                break;
            case "15:00:00":
                organizeShift($shift2, $row);
                break;
            case "23:00:00":
                organizeShift($shift3, $row);
                break;
        }
    }
} else {
    echo "No shifts scheduled for today.";
}

// Function to organize shifts based on position
function organizeShift(&$shift, $row)
{
    switch ($row["position"]) {
        case "Nurse":
            organizePosition($shift, $row, 0);
            break;
        case "LPN":
            organizePosition($shift, $row, 3);
            break;
        case "GNA":
            organizePosition($shift, $row, 6);
            break;
    }
}

// Function to organize shifts for each position within the shift array
function organizePosition(&$shift, $row, $startIndex)
{
    for ($i = $startIndex; $i < $startIndex + 3; $i++) {
        if ($shift[$i] === null) {
            $shift[$i] = $row;
            return;
        }
    }
}

// Now you can display these shifts in your HTML
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daily Scheduler</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row">
    <div class="col">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Morning Shift</h5>
        </div>
        <ul class="list-group list-group-flush">
            <?php
            // Display shifts for Shift 1
            foreach ($shift1 as $shift) {
                if ($shift === null) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center' style='background-color: red;'> Add  <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#nurseModul' data-position='Nurse'>Add</button></li>";

                } else {
                    echo "<li class='list-group-item'>{$shift['employeeKey']} - {$shift['position']}</li>";
                }
            }
            ?>
        </ul>
    </div>
</div>

<div class="col">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Aftornoon Shift</h5>
        </div>
        <ul class="list-group list-group-flush">
            <?php
            // Display shifts for Shift 1
            foreach ($shift2 as $shift) {
                if ($shift === null) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center' style='background-color: red;'> Add  <button class='btn btn-primary btn-sm' data-bs-target='#nurseModel'>Add</button></li>";
                } else {
                    echo "<li class='list-group-item'>{$shift['employeeKey']} - {$shift['position']}</li>";
                }
            }
            ?>
        </ul>
    </div>
</div>

<div class="col">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Night Shift</h5>
        </div>
        <ul class="list-group list-group-flush">
            <?php
            // Display shifts for Shift 1
            foreach ($shift3 as $shift) {
                if ($shift === null) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center' style='background-color: red;'> Add  <button class='btn btn-primary btn-sm'>Add</button></li>";
                } else {
                    echo "<li class='list-group-item'>{$shift['employeeKey']} - {$shift['position']}</li>";
                }
            }
            ?>
        </ul>
    </div>
</div>

    </div>
</div>

<!-- Modal for adding-->
<div class="modal fade" id="nurseModul" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Nurse</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

   
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#dailyModul').on('shown.bs.modal', function () {
        console.log("hi there");
        console.log("hi there!!");
      });
    });
  </script>
 
</body>
</html>
