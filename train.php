<?php
$conn = new mysqli('localhost', 'root', '', 'railwaymanagementsystem');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
$Train_No = $_POST['TrainNo'];
$TrainName = $_POST['TrainName'];
$Capacity = $_POST['Capacity'];
$ArrivalTime = $_POST['ArrivalTime'];
$DepartureTime = $_POST['DepartureTime'];
$Destination = $_POST['Destination'];
$TicketPrice = $_POST['TicketPrice'];
$start_station = $_POST['Start'];

$sql = "INSERT INTO train (Train_no, Train_Name, Capacity, Arrival_Time, Departure_Time, Destination, ticket_price, start_station) 
        VALUES ( ?, ?, ?, ?, ?, ?,?,?)";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo "Error preparing query: " . $conn->error;
    exit();
}

$stmt->bind_param("isisssis",$Train_No, $TrainName, $Capacity, $ArrivalTime, $DepartureTime, $Destination, $TicketPrice,$start_station);

$execval = $stmt->execute();
if ($execval === false) {
    echo "Error executing query: " . $stmt->error;
    exit();
}

$stmt->close();
$conn->close();

echo "Train Registration successful!";
?>
