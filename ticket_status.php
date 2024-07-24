<?php
session_start();
$userId = $_SESSION['ID'] ?? '';

$conn = new mysqli('localhost', 'root', '', 'railwaymanagementsystem');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$fetchDataQuery = "INSERT INTO ticket_status (Ticket_No, Waiting, Confirmed)
                SELECT Ticket_No,
                       SUM(CASE WHEN payment_status = 'Pending' THEN 1 ELSE 0 END) AS Waiting,
                       SUM(CASE WHEN payment_status = 'Confirmed' THEN 1 ELSE 0 END) AS Confirmed
                FROM ticket
                WHERE ID = '$userId'
                GROUP BY Ticket_No
                ON DUPLICATE KEY UPDATE
                    Waiting = VALUES(Waiting),
                    Confirmed = VALUES(Confirmed)";
if ($conn->query($fetchDataQuery) === TRUE) {
} else {
    echo "Error transferring data: " . $conn->error . "<br>";
}
$fetchTrainStatusQuery = "SELECT * FROM ticket_status WHERE Ticket_No IN (SELECT Ticket_No FROM ticket WHERE ID = '$userId')";
$result = $conn->query($fetchTrainStatusQuery);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Ticket No</th>
                <th>Waiting</th>
                <th>Confirmed</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Ticket_No"] . "</td>";
        echo "<td>" . $row["Waiting"] . "</td>";
        echo "<td>" . $row["Confirmed"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No data found for the logged-in user.";
}

$conn->close();
?>
