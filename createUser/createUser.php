<?php 
session_start();
include('../dbConn/dbConn.php');
$query = "SELECT MAX(id) AS max_id FROM users";
$result = mysqli_query($conn, $query);

// Check if the query was successful and if there are any existing users
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $next_id = $row['max_id'] + 1; // Increment the highest id by one
} else {
    // If there are no existing users, start with id = 1
    $next_id = 1;
}
$query = "SELECT DISTINCT  facility FROM users";
$result = mysqli_query($conn, $query);

// Check if facilities were fetched successfully
if ($result) {
    $facilities = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    // Handle error if facilities cannot be fetched
    $facilities = array(); // Default to an empty array
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="d-flex justify-content-center align-items-center" style="height: 64vh;">
<form action="userFormUpdate.php" class="col-md-4 border border-2 shadow p-3 mb-5 bg-body rounded" method="post">
    <label for="id"></label>
    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $next_id; ?>">

  <div class="form-group pt-2">
    <label for="firstName">First Name</label>
    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
  </div>
  <div class="form-group pt-2">
    <label for="lastName">Last Name</label>
    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
  </div>
  <div class="form-group pt-2">
    <label for="username">Username</label>
    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
  </div>
  <div class="form-group pt-2">
    <label for="facility">Facility</label>
    <select class="form-control" id="facility" name="facility">
      <?php foreach ($facilities as $facility): ?>
        <option value="<?php echo $facility['facility']; ?>"><?php echo $facility['facility']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="form-group pt-2">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
  </div>
  <div class="pt-2">
  <button type="submit" class="btn btn-primary">Submit</button>
  <div>
</form>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
