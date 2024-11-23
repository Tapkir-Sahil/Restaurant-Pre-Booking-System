<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'order_id' is set in the POST data
    if (isset($_POST["order_id"])) {
        $order_id = $_POST["order_id"];

        $servername = "localhost";
        $username = "Atharav";
        $password = "Atharav@31";
        $dbname = "project";

        // Create a new database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL statement to retrieve the order status
        $sql = "SELECT status FROM details WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        // Bind the order ID parameter
        

        // Execute the query
       
        // Check if the order with the provided ID exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $status = $row["status"];
            var_dump($status);

            if ($status === 'pending') {
                // Prepare the SQL statement to update the order status to 'confirmed'
                $updateStatusSql = "UPDATE details SET status='confirmed' WHERE id = ?";
                $updateStmt = $conn->prepare($updateStatusSql);

                if ($updateStmt === false) {
                    die("Prepare failed: " . $conn->error);
                }

                // Bind the order ID parameter for the update statement
                $updateStmt->bind_param("i", $order_id);

                // Execute the update query
                $updateStmt->execute();

                if ($updateStmt->error) {
                    echo "Error updating status: " . $updateStmt->error;
                } else {
                    // echo "Order has been confirmed.";
                    header("Location:customerbookinghtml.php");
                    // Close the update statement
                    $updateStmt->close();
                }
            } elseif ($status === 'confirmed') {
                echo "This order is already confirmed.$order_id";
            } else {
                echo "This order cannot be confirmed. Status: $status";
            }
        } else {
            echo "Order not found. Order ID: $order_id";
        }

        // Close the prepared statement and the database connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Order ID not provided.";
    }
}
?>
