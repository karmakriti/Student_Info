
<?php
// Database connection details
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'ilac';

// Create database connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize user input
    $username = $conn->real_escape_string($_POST['username']);
    // Note: Do not hash the password here; we need the plain text password for verification

    // SQL query to select user
    $sql = "SELECT username, password FROM ilacstudents WHERE username = ?";

    // Prepare the SQL statement to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("s", $username);
        // Execute the statement
        $stmt->execute();
        // Store the result so we can check the number of rows
        $stmt->store_result();

        // Check if a user with the username exists
        if ($stmt->num_rows > 0) {
            // Bind the result to variables
            $stmt->bind_result($dbUsername, $dbPassword);
            // Fetch the result
            $stmt->fetch();


            // Verify the password
            if (password_verify($_POST['password'], $dbPassword)) {
                // Success! Passwords match
                echo "Login successful. Welcome, $dbUsername!";
                // Redirect or start a session here
            } else {
                // Passwords do not match
                echo "Incorrect password. Please try again.";

            }
        } else {
            // No user found with the provided username
            echo "Username not found. Please register.";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }

    // Close connection
    $conn->close();
} else {
    // Not a POST request
    echo "Invalid request method.";
}
?>




