<?php
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
// Include the database.php file (assuming it contains your database connection and SQL query)
include ("../dbConn/dbConn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tables from Database</title>
    <link rel="stylesheet" href="pageOne.css">
</head>
<body>
    
<?php
//slect from the daily pulling week one first and then week two to make the table
$theSql = "SELECT * FROM `daily` where facility = ? ORDER BY weekNum ASC;";
$stmt = $conn->prepare($theSql);
$stmt->bind_param("s", $facility);
$stmt->execute();
$result = $stmt->get_result();

// Initialize an array to store rows grouped by week number
$weeks = array();

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Group the rows by week number
    while ($row = $result->fetch_assoc()) {
        $weekNumber = $row["weekNum"];
        $weeks[$weekNumber][] = $row;
    }

    // Display each week's data in a separate table
    foreach ($weeks as $weekNumber => $weekData) {
        echo "<div class='table-container'>";
        echo "<table>";
        echo "<caption>Week $weekNumber</caption>";
        echo "<tr><th>ID</th><th>Date of Schedule</th><th>Day of Schedule</th><th>Shift Start</th><th>Shift End</th><th>Unit</th><th>Position</th></tr>";
        foreach ($weekData as $rowData) {
            //change the time from 24 to 12 hours
            $shift_start_time = date("g:i A", strtotime($rowData["shift_start_time"]));
            $shift_end_time = date("g:i A", strtotime($rowData["shift_end_time"]));
            echo "<tr>";
            echo "<td>" . $rowData["id"] . "</td>";
            echo "<td>" . $rowData["dateOfSched"] . "</td>";
            echo "<td>" . $rowData["dayOfSched"] . "</td>";
            echo "<td>" . $shift_start_time . "</td>";
            echo "<td>" . $shift_end_time . "</td>";
            echo "<td>" . $rowData["unit"] . "</td>";
            echo "<td>" . $rowData["position"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }
} else {
    echo "0 results";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
</body>
</html>