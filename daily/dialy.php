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


// Initialize arrays for each shift time
$morning_shift = [];
$afternoon_shift = [];
$night_shift = [];

// Initialize sub-arrays for each shift for Nurse, LPN, and GNA positions
$morning_shift['Nurse'] = [];
$morning_shift['LPN'] = [];
$morning_shift['GNA'] = [];

$afternoon_shift['Nurse'] = [];
$afternoon_shift['LPN'] = [];
$afternoon_shift['GNA'] = [];

$night_shift['Nurse'] = [];
$night_shift['LPN'] = [];
$night_shift['GNA'] = [];
//number of each that there should be
$num_nurses = 3;
$num_lpns = 3;
$num_gnas = 3;

// Initialize arrays for each shift time
// Check if there are shifts scheduled for today
if ($result->num_rows > 0) {
    // Organize shifts into separate arrays based on shift start time and position
    while ($row = $result->fetch_assoc()) {
        switch ($row["shift_start_time"]) {
            case "07:00:00":
                organizeShift($morning_shift, $row);
                break;
            case "15:00:00":
                organizeShift($afternoon_shift, $row);
                break;
            case "23:00:00":
                organizeShift($night_shift, $row);
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
            organizePosition($shift['Nurse'], $row);
            break;
        case "LPN":
            organizePosition($shift['LPN'], $row);
            break;
        case "GNA":
            organizePosition($shift['GNA'], $row);
            break;
    }
}

// Function to organize shifts for each position within the shift array
function organizePosition(&$position_array, $row)
{
    // Push the shift data into the position array
    $position_array[] = $row;
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
        <!-- Morning Shift Card -->
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Morning Shift</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    // Loop through each position for the morning shift
                    $positions = ['Nurse', 'LPN', 'GNA']; // Add more positions as needed
                    foreach ($positions as $position) {
                        // Display shifts for this position
                        if (isset($morning_shift[$position])) {
                            foreach ($morning_shift[$position] as $shift) {
                                echo "<li class='list-group-item'>{$shift['employeeKey']} - {$shift['position']}</li>";
                            }
                        }
                        // Calculate the number of shifts for this position
                        $shift_count = isset($morning_shift[$position]) ? count($morning_shift[$position]) : 0;
                        // If there are fewer than three shifts for this position, display 'Add' button
                        for ($i = $shift_count; $i < 3; $i++) {
                            echo "<li class='list-group-item d-flex justify-content-between align-items-center' style='background-color: red;'> Add $position <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#{$position}Modul'>Add</button></li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
   
        <!-- afternoon Shift Card -->
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Afternoon Shift</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    // Loop through each position for the morning shift
                    $positions = ['Nurse', 'LPN', 'GNA']; // Add more positions as needed
                    foreach ($positions as $position) {
                        // Display shifts for this position
                        if (isset($afternoon_shift[$position])) {
                            foreach ($afternoon_shift[$position] as $shift) {
                                echo "<li class='list-group-item'>{$shift['employeeKey']} - {$shift['position']}</li>";
                            }
                        }
                        // Calculate the number of shifts for this position
                        $shift_count = isset($afternoon_shift[$position]) ? count($afternoon_shift[$position]) : 0;
                        // If there are fewer than three shifts for this position, display 'Add' button
                        for ($i = $shift_count; $i < 3; $i++) {
                            echo "<li class='list-group-item d-flex justify-content-between align-items-center' style='background-color: red;'> Add $position <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#{$position}Modul'>Add</button></li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
      
        <!-- afternoon Shift Card -->
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Night Shift</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    // Loop through each position for the morning shift
                    $positions = ['Nurse', 'LPN', 'GNA']; // Add more positions as needed
                    foreach ($positions as $position) {
                        // Display shifts for this position
                        if (isset($night_shift[$position])) {
                            foreach ($night_shift[$position] as $shift) {
                                echo "<li class='list-group-item'>{$shift['employeeKey']} - {$shift['position']}</li>";
                            }
                        }
                        // Calculate the number of shifts for this position
                        $shift_count = isset($night_shift[$position]) ? count($night_shift[$position]) : 0;
                        // If there are fewer than three shifts for this position, display 'Add' button
                        for ($i = $shift_count; $i < 3; $i++) {
                            echo "<li class='list-group-item d-flex justify-content-between align-items-center' style='background-color: red;'> Add $position <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#{$position}Modul'>Add</button></li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>



<!--div class="col">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Aftornoon Shift</h5>
        </div>
        <ul class="list-group list-group-flush">
            <?php
            // Display shifts for Shift 1
           /* foreach ($shift2 as $shift) {
                if ($shift === null) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center' style='background-color: red;'> Add  <button class='btn btn-primary btn-sm' data-bs-target='#nurseModel'>Add</button></li>";
                } else {
                    echo "<li class='list-group-item'>{$shift['employeeKey']} - {$shift['position']}</li>";
                }
            }*/
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
            /*foreach ($shift3 as $shift) {
                if ($shift === null) {
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center' style='background-color: red;'> Add  <button class='btn btn-primary btn-sm'>Add</button></li>";
                } else {
                    echo "<li class='list-group-item'>{$shift['employeeKey']} - {$shift['position']}</li>";
                }
            }*/
            ?>
        </ul>
    </div>
</div>

    </div>
</div-->

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
