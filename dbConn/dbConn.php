<?php
$servername = "localhost"; // Change this to your database server name if different
$dbUsername = "sdmymzzuhh"; // Change this to your database username
$dbPassword = "8nrqMue9ft"; // Change this to your database password if set
$dbname = "schedule"; // Change this to your database name

// Create a connection to the database
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>