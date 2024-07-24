<?php
if (isset($_GET['Ticket_No']) && isset($_GET['Ticket_Price'])) {
    $Ticket_No = $_GET['Ticket_No'];
    $Ticket_Price = $_GET['Ticket_Price'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'railwaymanagementsystem');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    $getTicketQuery = "SELECT * FROM ticket WHERE Ticket_No = ?";
    $stmtGetTicket = $conn->prepare($getTicketQuery);
    $stmtGetTicket->bind_param("i", $Ticket_No);
    $stmtGetTicket->execute();
    $ticketResult = $stmtGetTicket->get_result();

    if ($ticketResult->num_rows > 0) {
        $ticketRow = $ticketResult->fetch_assoc();
        $Passenger_Name = $ticketRow['Passenger_Name'];
        $payment_status = $ticketRow['payment_status'];

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            $CardNo = $_POST['CardNo'];
            $CVV = $_POST['CVV'];

            if (strlen($CardNo) == 16 && is_numeric($CardNo) && strlen($CVV) == 3 && is_numeric($CVV)) {
                
                $updatePaymentQuery = "UPDATE ticket SET payment_status = 'Confirmed' WHERE Ticket_No = ?";
                $stmtUpdatePayment = $conn->prepare($updatePaymentQuery);
                $stmtUpdatePayment->bind_param("i", $Ticket_No);

                if ($stmtUpdatePayment->execute()) {
                    $payment_status = 'Confirmed';
                    
                    $insertPaymentQuery = "INSERT INTO payment (Ticket_No, Card_No, Ticket_Price) VALUES (?, ?, ?)";
                    $stmtInsertPayment = $conn->prepare($insertPaymentQuery);
                    $stmtInsertPayment->bind_param("isd", $Ticket_No, $CardNo, $Ticket_Price);
                    $stmtInsertPayment->execute();
                    $stmtInsertPayment->close();
                    echo '<script>alert("Payment Successful!");</script>';
                    echo '<script>window.location.href = "ticket_book.php?payment_status='.$payment_status.'";</script>';
                    exit();
                } else {
                    echo "Error updating payment status: " . $stmtUpdatePayment->error;
                }

                $stmtUpdatePayment->close();
            } else {
                echo "Invalid card details. Please enter a valid card number and CVV.";
            }
        }

        ?>
        <!DOCTYPE html>
        <html>
        
        <head>
            <title>Make Payment</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        
        <body>
            <div class="container mt-5">
                <h1 class="text-center mb-4">Make Payment</h1>
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Ticket Details</h2>
                        <p><strong>Passenger Name:</strong> <?php echo $Passenger_Name; ?></p>
                        <p><strong>Ticket Price:</strong> <?php echo $Ticket_Price; ?></p>
                        <p><strong>Payment Status:</strong> <?php echo $payment_status; ?></p>
        
                        <?php if ($payment_status !== 'Confirmed') : ?>
                            <form action="make_payment.php?Ticket_No=<?php echo $Ticket_No; ?>&Ticket_Price=<?php echo $Ticket_Price; ?>" method="POST">
                                <div class="form-group">
                                    <label for="CardNo">Card Number</label>
                                    <input type="text" class="form-control" id="CardNo" name="CardNo" required>
                                </div>
                                <div class="form-group">
                                    <label for="CVV">CVV</label>
                                    <input type="text" class="form-control" id="CVV" name="CVV" required>
                                </div>
                                <div class="form-group">
                                    <label for="Amount">Amount</label>
                                    <input type="text" class="form-control" id="Amount" name="Amount" readonly value="<?php echo $Ticket_Price; ?>">
                                </div>
                                <input type="hidden" name="Ticket_No" value="<?php echo $Ticket_No; ?>">
                                <button type="submit" class="btn btn-primary" name="submit">Pay Now</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </body>
        
        </html>
        <?php

    } else {
        echo "Ticket not found.";
    }

    $stmtGetTicket->close();
    $conn->close();
} else {
    echo "Error: Ticket details not provided.";
}
?>
