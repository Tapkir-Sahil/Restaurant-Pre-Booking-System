<?php
// Include your database configuration here
$servername = "localhost";
$username = "Atharav";
$password = "Atharav@31";
$dbname = "project";

// Check if the 'delete' parameter is set in the URL
if (isset($_GET['delete']) && $_GET['delete'] == "success") {
    // Display the "User deleted successfully" message
    echo "Hotel deleted successfully.";
}

// Function to update hotel information
function updateHotel($id, $name, $type, $rating, $location) {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $sql = "UPDATE hotel SET name=?, type=?, rating=?, location=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsi", $name, $type, $rating, $location, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Hotel information updated successfully.";
        } else {
            echo "No changes were made to hotel information.";
        }
    } else {
        echo "Error updating hotel information: " . $stmt->error;
    }

    $conn->close();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && isset($_POST["save"])) {
    // Get the updated hotel information
    $hotelId = $_POST["id"];
    $hotelName = $_POST["name"];
    $hotelType = $_POST["type"];
    $hotelRating = $_POST["rating"];
    $hotelLocation = $_POST["location"];

    // Call the function to update hotel information
    updateHotel($hotelId, $hotelName, $hotelType, $hotelRating, $hotelLocation);
}
if (isset($_GET['add']) && $_GET['add'] == "success") {
    // Display the "User added successfully" message
    echo "Hotel added successfully.";
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
        <h1>Admin Panel - Edit Hotels</h1>
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
        <!-- Example: Hotel List -->
        <section id="user-list">
            <h2>Edit Hotels</h2>
            
            <?php
            // Display the delete success message if set
            if (!empty($deleteSuccessMessage)) {
                echo "<p class='success-message'>$deleteSuccessMessage</p>";
            }
            ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Rating</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Function to fetch all hotels
                    function getAllHotels() {
                        global $servername, $username, $password, $dbname;
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $sql = "SELECT * FROM hotel";
                        $result = $conn->query($sql);
                        $conn->close();
                        return $result;
                    }
                    
                    // Get all hotels and display them
                    $hotels = getAllHotels();
                    if ($hotels->num_rows > 0) {
                        while ($row = $hotels->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            if (isset($_GET['edit']) && $_GET['edit'] == $row["id"]) {
                                // Display a form for editing the hotel information
                                echo "<td>
                                    <form method='post' action='edit_rest.php'>
                                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                                    <input type='text' name='name' value='" . $row["name"] . "'>
                                    </td>";
                                echo "<td><input type='text' name='type' value='" . $row["type"] . "'></td>";
                                echo "<td><input type='number' name='rating' value='" . $row["rating"] . "'></td>";
                                echo "<td><input type='text' name='location' value='" . $row["location"] . "'></td>";
                                echo "<td>
                                    <input type='submit' name='save' value='Save' class='action-button'>
                                    <a href='edit_rest.php'><button class='action-button'>Cancel</button></a>
                                    </form>
                                </td>";
                            } else {
                                // Display hotel information without form
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row["type"] . "</td>";
                                echo "<td>" . $row["rating"] . "</td>";
                                echo "<td>" . $row["location"] . "</td>";
                                echo "<td>
                                <a href='edit_rest.php?edit=" . $row["id"] . "'><button class='action-button'>Edit</button></a>
                                <a href='delete_hotel.php?id=" . $row["id"] . "'><button class='action-button'>Delete</button></a>
                                </td>";
                            }
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No hotels found</td></tr>";
                    }
                    ?>
                </tbody>
                </table>
        </section>
    </main>
</body>
</html>