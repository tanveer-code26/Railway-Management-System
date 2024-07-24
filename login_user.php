<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'railwaymanagementsystem');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Admin_Username = $_POST['Admin_Username'];
    $Admin_Password = $_POST['Admin_Password'];

    $stmt = $conn->prepare("SELECT ID FROM user WHERE Username=? AND password=?");
    $stmt->bind_param("ss", $Admin_Username, $Admin_Password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['ID'] = $row['ID'];
        $stmt->close();
        $conn->close();
        header("Location: option.php");
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>