<!DOCTYPE html>
<html>

<head>
    <title>Available Trains</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Available Trains</h1>
        <div class="row">
            <?php
            // Database connection
            $conn = new mysqli('localhost', 'root', '', 'railwaymanagementsystem');
            if ($conn->connect_error) {
                die("Connection Failed: " . $conn->connect_error);
            }

            // Retrieve user input
            $start = $_POST['start'];
            $destination = $_POST['destination'];

            // SQL query to get train information based on start and destination
            $sql = "SELECT * FROM train WHERE Start_Station LIKE '%$start%' AND Destination LIKE '%$destination%'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['Train_Name']; ?></h5>
                                <p class="card-text"><strong>Train Number:</strong> <?php echo $row['Train_No']; ?></p>
                                <p class="card-text"><strong>Capacity:</strong> <?php echo $row['Capacity']; ?></p>
                                <p class="card-text"><strong>Arrival Time:</strong> <?php echo $row['Arrival_Time']; ?></p>
                                <p class="card-text"><strong>Departure Time:</strong> <?php echo $row['Departure_Time']; ?></p>
                                <p class="card-text"><strong>Destination:</strong> <?php echo $row['Destination']; ?></p>
                                <p class="card-text"><strong>Ticket Price:</strong> <?php echo $row['ticket_price']; ?></p>
                                <a href="ticket_book.php?Train_No=<?php echo $row['Train_No']; ?>&Ticket_Price=<?php echo $row['ticket_price']; ?>" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<div class='col-md-12'><div class='alert alert-warning'>No trains found for the given route.</div></div>";
            }

            // Close database connection
            $conn->close();
            ?>
        </div>
    </div>
</body>

</html>
