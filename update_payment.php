<?php
// Retrieve form data
$Ticket_No = $_POST['Ticket_No'];
$CardNo = $_POST['CardNo'];
$CVV = $_POST['CVV'];
$Amount = $_POST['Amount'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'railwaymanagementsystem');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Check if the Ticket_No exists in the ticket table
$checkTicketQuery = "SELECT * FROM ticket WHERE Ticket_No = ?";
$stmtCheckTicket = $conn->prepare($checkTicketQuery);
$stmtCheckTicket->bind_param("i", $Ticket_No);
$stmtCheckTicket->execute();
$result = $stmtCheckTicket->get_result();
if ($result->num_rows == 0) {
    die("Error: Ticket with Ticket_No $Ticket_No does not exist.");
}
$stmtCheckTicket->close();

// Update payment status and insert payment details
$updatePaymentQuery = "UPDATE ticket SET payment_status = 'Paid' WHERE Ticket_No = ?";
$stmtUpdatePayment = $conn->prepare($updatePaymentQuery);
$stmtUpdatePayment->bind_param("i", $Ticket_No);

if ($stmtUpdatePayment->execute()) {
    // Payment status updated, now insert payment details into the payment table
    $insertPaymentQuery = "INSERT INTO payment (Ticket_No, Card_No, Ticket_Price) VALUES (?, ?, ?)";
    $stmtInsertPayment = $conn->prepare($insertPaymentQuery);
    $stmtInsertPayment->bind_param("isd", $Ticket_No, $CardNo, $Amount);

    if ($stmtInsertPayment->execute()) {
        echo "Payment Successful! Ticket booked and payment details recorded.";
    } else {
        echo "Error inserting payment details: " . $stmtInsertPayment->error;
    }
} else {
    echo "Error updating payment status: " . $stmtUpdatePayment->error;
}

$stmtUpdatePayment->close();
$stmtInsertPayment->close();
$conn->close();
?>
