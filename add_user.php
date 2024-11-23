<?php
// Include your database configuration here
$servername = "localhost";
$dbUsername = "Atharav"; // Use a different variable name here
$dbPassword = "Atharav@31";
$dbname = "project";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user input
    $newUsername = $_POST["new_username"];
    $newEmail = $_POST["new_email"];
    $userType = $_POST["user_type"]; // Added user_type

    // Set the default password
    $defaultUserPassword = "admin";

    // Perform input validation here if needed

    // Function to add a new user
    function addUser($username, $email, $password, $userType) { // Added user_type parameter
        global $servername, $dbUsername, $dbPassword, $dbname; // Update this variable name as well

        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname); // Update this variable name

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert the new user into the database with the default password and user_type
        $sql = "INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $email, $password, $userType); // Added user_type here

        if ($stmt->execute()) {
            // Redirect back to action.php with a success message or flag
            header("Location: action.php?add=success");
            exit();
        } else {
            echo "Error adding user: " . $stmt->error;
        }

        $conn->close();
    }

    // Call the function to add the new user with the default password and user_type
    addUser($newUsername, $newEmail, $defaultUserPassword, $userType);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="action.css">
</head>
<body>
        <header id="header">
            <h1>Admin Panel - Add Users</h1>
        </header>
        <nav id="nav">
            <ul id="a1">
               <li><a href="admin1.php?page=home">Home</a></li>
               <li><a href="admin1.php?page=view">View Resturants</a></li>
               <li><a href="admin1.php?page=add">Add Users</a></li>
               <li><a href="admin1.php?page=addr">Add Resturants</a></li>
               <li><a href="admin1.php?page=index">Logout</a></li>
        </ul>
        </nav>
        <main id="main">
        <section id="add-user-form">
    <h2>Add User</h2>
    <form method="post" action="add_user.php">
        <label for="new_username">Username:</label>
        <input type="text" id="new_username" name="new_username" required style="width: 300px;font-size: 16px;">
        <br>
        <label for="new_email">Email:</label>
        <input type="email" id="new_email" name="new_email" required style="width: 300px; font-size: 16px;">
        <br>
        <!-- Use radio buttons for user_type -->
        <label>User Type:</label>
        <div class="radio-container">
            <input type="radio" id="admin_type" name="user_type" value="business" required>
            <label for="admin_type" class="checkmark"></label>
            <span>Business</span>
        </div>
        <div class="radio-container">
            <input type="radio" id="user_type" name="user_type" value="customer" required>
            <label for="user_type" class="checkmark"></label>
            <span>Customer</span>
        </div>
        <br>
        <input type="submit" value="Add User" class="action-button">
    </form>
</section>
</main>
</body>
</html>
