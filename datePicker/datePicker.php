<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Picker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
    </style>
</head>
<body>
    <form action="../datePicker/processDate.php" method="post">
        <!-- Hidden input field to store the selected date -->
        <input type="hidden" id="selectedDate" name="selectedDate">
        
        <!-- Flatpickr input field -->
        <input type="text" class="form-control" id="datepicker">

        <!-- Submit button -->
        <button type="submit">Submit</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize Flatpickr on the input field with id "datepicker"
            flatpickr("#datepicker", {
                dateFormat: "Y-m-d", // Set the date format as needed
                onChange: function(selectedDates, dateStr) {
                    // Update the hidden input field with the selected date value
                    document.getElementById("selectedDate").value = dateStr;
                }
            });
        });
    </script>
</body>
</html>
