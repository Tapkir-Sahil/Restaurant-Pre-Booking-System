<?php
// Include your database configuration here
$servername = "localhost";
$username = "Atharav";
$password = "Atharav@31";
$dbname = "project";

// Function to update user information
function updateUser($id, $newUsername) {
    global $servername, $username, $password, $dbname;
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Use prepared statements to prevent SQL injection
    $sql = "SELECT name FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentUsername = $row["name"];
        
        // Check if the new username is different from the current username
        if ($newUsername != $currentUsername) {
            $sql = "UPDATE users SET name=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $newUsername, $id);
            
            if ($stmt->execute()) {
                echo "User information updated successfully.";
            } else {
                echo "Error updating user information: " . $stmt->error;
            }
        }
    }
    
    $conn->close();
}

// Check if the form is submitted
// // Check if the form is submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
// //     if (isset($_POST["save"])) { // Check if the "Save" button is clicked
// //         // Get the updated username and user ID
// //         $newUsername = $_POST["new_username"];
// //         $userId = $_POST["id"];
        
// //         // Call the function to update user information
// //         updateUser($userId, $newUsername);
// //     } else {
// //         // Display a message when no changes are made
// //         echo "No changes were made to User information.";
// //     }
// // }
// // // Check if the 'delete' parameter is set in the URL
// // if (isset($_GET['delete']) && $_GET['delete'] == "success") {
// //     // Display the "User deleted successfully" message
// //     echo "User deleted successfully.";
// // }
// // if (isset($_GET['add']) && $_GET['add'] == "success") {
// //     // Display the "User added successfully" message
// //     echo "User added successfully.";
// // }
// // ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="action.css">
</head>
<body>
    <header id="header">
        <h1>Admin Panel - View Users</h1>
        <!-- Add a navigation menu or user info here -->
    </header>
    <nav id="nav">
        <ul>
            <li><a href="admin1.php?page=home">Home</a></li>
            <li><a href="admin1.php?page=view">View Resturants</a></li>
            <li><a href="admin1.php?page=add">Add Users</a></li>
            <li><a href="admin1.php?page=addr">Add Resturants</a></li>
            <li><a href="admin1.php?page=index">Logout</a></li>
        </ul>
        </nav>
    <main id="main">
        <!-- Add your admin features here -->
        <!-- Example: User List -->
        <section id="user-list">
            <h2>View Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Function to fetch all users
                    function getAllUsers() {
                        global $servername, $username, $password, $dbname;
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $sql = "SELECT * FROM users";
                        $result = $conn->query($sql);
                        $conn->close();
                        return $result;
                    }
                    
                    // Get all users and display them
                    $users = getAllUsers();
                    if ($users->num_rows > 0) {
                        while ($row = $users->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            if (isset($_GET['edit']) && $_GET['edit'] == $row["id"]) {
                                // Display an input field for editing the username
                                echo "<td>
                                    <form method='post' action='action.php'>
                                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                                    <input type='text' name='new_username' value='" . $row["name"] . "'>
                                    <input type='submit' name='save' value='Save' class='action-button'>
                                    <a href='action.php'><button class='action-button'>Cancel</button></a>
                                    </form>
                                </td>";
                            } else {
                                echo "<td>" . $row["name"] . "</td>";
                            }
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["user_type"] . "</td>";
                            echo "<td>
                            <a href='delete_user.php?id=" . $row["id"] . "'><button class='action-button'>Delete</button></a>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>