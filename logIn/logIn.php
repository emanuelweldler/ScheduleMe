<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!--link rel="stylesheet" href="logIn.css"-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="d-flex justify-content-center align-items-center" style="height: 64vh;">
<form action="login.php" method="post" class="col-md-4 border border-2 shadow p-3 mb-5 bg-body rounded">
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
  </div>
  <div class="form-group mb-3">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
  <!-- build this page at some point-->
  <a href="forgotPassword.php" class="btn btn-link mt-2 center">Forgot Username or Password?</a>
</form>


<?php
session_start();
include("../dbConn/dbConn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Check if username and password are set and not empty
   if (isset($_POST["username"]) && isset($_POST["password"]) && !empty($_POST["username"]) && !empty($_POST["password"])) {
       // Grab the username and password from the form
       $formUsername   = $_POST["username"];
       $formPassword  = $_POST["password"];

       // Query the database to check if the provided username and password match
       $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
       $stmt = $conn->prepare($sql);
       $stmt->bind_param("ss", $formUsername, $formPassword );
       $stmt->execute();
       $result = $stmt->get_result();

       // Check if a matching record was found
       if ($result->num_rows == 1) {
           // Fetch the user data
           $row = $result->fetch_assoc();

           // Store user data in session variables

           $_SESSION["username"] = $row["username"];
           $_SESSION["facility"] = $row["facility"];

           // Redirect to the desired page
           header('Location: ../files/pageOne.php');
           exit();
       } else {
           // Login failed
           echo "Invalid username or password.";
       }
   } else {
       echo "Username and password are required.";
   }
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
