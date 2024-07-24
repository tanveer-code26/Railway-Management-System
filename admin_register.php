<?php
$Username = $_POST['Username'];
$password = $_POST['password'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'railwaymanagementsystem');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO admin (Username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $Username, $password);
    $execval = $stmt->execute();
    $stmt->close();
    $conn->close();
    if ($execval) {
        header("Location: train.html");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
