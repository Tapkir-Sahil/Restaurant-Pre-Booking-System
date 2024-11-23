<?php
// Include your database configuration here
$servername = "localhost";
$dbUsername = "Atharav";
$dbPassword = "Atharav@31";
$dbname = "project";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the hotel details
    $hotelName = $_POST["hotel_name"];
    $hotelType = $_POST["hotel_type"];
    $hotelRating = floatval($_POST["hotel_rating"]);
    $hotelLocation = $_POST["hotel_location"];

    // Validate the rating (0-10)
    if ($hotelRating < 0 || $hotelRating > 10) {
        echo "Invalid rating. Rating should be between 0 and 10.";
        exit();
    }

    // Function to add a new hotel
    function addHotel($name, $type, $rating, $location) {
        global $servername, $dbUsername, $dbPassword, $dbname;

        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert the new hotel into the database
        $sql = "INSERT INTO hotel (name, type, rating, location) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssds", $name, $type, $rating, $location);

        if ($stmt->execute()) {
            // Redirect back to the page with a success message
            header("Location: edit_rest.php?add=success");
            exit();
        } else {
            echo "Error adding hotel: " . $stmt->error;
        }

        $conn->close();
    }

    // Call the function to add the new hotel
    addHotel($hotelName, $hotelType, $hotelRating, $hotelLocation);
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
        <h1>Admin Panel - Add Hotel</h1>
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
            <h2>Add Hotel</h2>
            <form method="post" action="add_hotel.php">
                <label for="hotel_name">Hotel Name:</label>
                <input type="text" id="hotel_name" name="hotel_name" required style="width: 300px; font-size: 16px;">
                <br>
                <label for="hotel_type">Hotel Type:</label>
                <input type="text" id="hotel_type" name="hotel_type" required style="width: 300px; font-size: 16px;">
                <br>
                <label for="hotel_rating">Hotel Rating</label>
                <input type="number" id="hotel_rating" name="hotel_rating" step="0.1" min="0" max="10" required style="width: 300px; font-size: 16px;">
                <br>
                <label for="hotel_location">Hotel Location:</label>
                <input type="text" id="hotel_location" name="hotel_location" required style="width: 300px; font-size: 16px;">
                <br>
                <input type="submit" value="Add Hotel" class="action-button">
            </form>
        </section>
    </main>
</body>
</html>
