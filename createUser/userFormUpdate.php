<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $facility = $_POST['facility'];
    $password = $_POST['password'];

    // Database connection
    include('../dbConn/dbConn.php'); // Include your database connection file

    // SQL INSERT statement
    $sql = "INSERT INTO users (id, first_name, last_name, username, password, facility) VALUES ('$id', '$firstName', '$lastName', '$username', '$password', '$facility')";


    // Execute the INSERT statement
    if (mysqli_query($conn, $sql)) {
       // echo "New user added successfully.";
       header("Location: createUser.php");
       exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // If form is not submitted, display an error message or redirect the user
    echo "Error: Form not submitted!";
}
?>
