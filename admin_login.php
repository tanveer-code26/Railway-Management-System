<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'railwaymanagementsystem');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Admin_Username = $_POST['Admin_Username'];
    $Admin_Password = $_POST['Admin_Password'];

    $sql = "SELECT * FROM admin WHERE Username='$Admin_Username' AND password='$Admin_Password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['admin_username'] = $Admin_Username;
        header("Location: train.html");
        exit();
    } else {
        // Admin login failed
        echo "Invalid username or password.";
    }
}

$conn->close();
?>
