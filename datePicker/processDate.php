<?php 
include("../dbConn/dbConn.php");
if(isset($_POST['selectedDate'])) {
    // Retrieve the selected date from the URL
    $selectedDate = $_POST['selectedDate'];
    // Print out the selected date
    echo "Selected date: " . $selectedDate;
    $sql = "SELECT * FROM daily WHERE  dateOfSched = ?";
       $stmt = $conn->prepare($sql);
       $stmt->bind_param("s", $selectedDate );
       $stmt->execute();
       $result = $stmt->get_result();
       if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<p>ID: " . $row["id"] . ", Date of Schedule: " . $row["dateOfSched"] . ", Employee Key: " . $row["employeeKey"] . ", Day of Schedule: " . $row["dayOfSched"] . ", Week Number: " . $row["weekNum"] . ", Shift Start Time: " . $row["shift_start_time"] . ", Shift End Time: " . $row["shift_end_time"] . ", Unit: " . $row["unit"] . ", Position: " . $row["position"] . ", Facility: " . $row["facility"] . "</p>";
        }
    } else {
        echo "0 results";
    }
} else {
    // If the selectedDate parameter is not present in the URL, print an error message
    echo "No date selected";
}
?>