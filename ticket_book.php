<!DOCTYPE html>
<html>

<head>
    <title>Book Ticket</title>
</head>

<body>
    <?php
    session_start();
    $userId = $_SESSION['ID'] ?? '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_GET['Train_No']) && isset($_GET['Ticket_Price'])) {
            $Train_No = $_GET['Train_No'];
            $Ticket_Price = $_GET['Ticket_Price'];

            $Passenger_Name = $_POST['Passenger_Name'] ?? '';
            $ID = uniqid();

            $conn = new mysqli('localhost', 'root', '', 'railwaymanagementsystem');
            if ($conn->connect_error) {
                die("Connection Failed: " . $conn->connect_error);
            }

            $checkUserQuery = "SELECT ID FROM user WHERE Name = ?";
            $stmtCheckUser = $conn->prepare($checkUserQuery);
            $stmtCheckUser->bind_param("s", $Passenger_Name);
            $stmtCheckUser->execute();
            $result = $stmtCheckUser->get_result();
            $userExists = $result->num_rows > 0;

            // if ($userExists) {
                $userRow = $result->fetch_assoc();
                $ID = $userRow['ID'];

                $Date_Time = date('Y-m-d H:i:s');
                $Seat_No = mt_rand(1, 100);
                $payment_status = 'Pending'; 

                $insertTicketQuery = "INSERT INTO ticket (ID, Date_Time, Ticket_Price, Train_No, Seat_No, Passenger_Name, payment_status) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmtInsertTicket = $conn->prepare($insertTicketQuery);
                $stmtInsertTicket->bind_param("isdiiss", $userId, $Date_Time, $Ticket_Price, $Train_No, $Seat_No, $Passenger_Name, $payment_status);

                if ($stmtInsertTicket->execute()) {
                    header("Location: make_payment.php?Ticket_No=$stmtInsertTicket->insert_id&Ticket_Price=$Ticket_Price");
                    exit();
                } else {
                    echo "Error booking ticket: " . $stmtInsertTicket->error;
                }

                $stmtInsertTicket->close();
            // } else {
            //     echo "Error: User with Name $Passenger_Name does not exist.";
            // // }

            $stmtCheckUser->close();
            $conn->close();
        } else {
            echo "Error: Train details not provided.";
        }
    } else {
    ?>
        <h2>Book Ticket</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?Train_No=<?php echo $_GET['Train_No'] ?? ''; ?>&Ticket_Price=<?php echo $_GET['Ticket_Price'] ?? ''; ?>" method="POST">
            <label for="Passenger_Name">Passenger Name:</label>
            <input type="text" id="Passenger_Name" name="Passenger_Name" required>
            <input type="submit" value="Book Now">
        </form>
    <?php
    }
    ?>
</body>

</html>
