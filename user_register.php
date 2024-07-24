<?php
session_start(); 
$Name = $_POST['Name'];
$Username = $_POST['Username'];
$password = $_POST['password'];
$HouseNo = $_POST['HouseNo'];
$Street = $_POST['Street'];
$City = $_POST['City'];

$conn = new mysqli('localhost', 'root', '', 'railwaymanagementsystem');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO user (Name, Username, password, House_No, Street, City) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $Name, $Username, $password, $HouseNo, $Street, $City);
    $execval = $stmt->execute();
    $stmt->close();
    $conn->close();
    if ($execval) {
        header("Location: login_user.html");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
