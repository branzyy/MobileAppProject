<?php
session_start();
require 'connection/index.php'; // Ensure correct database connection

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: loginform.php");
    exit();
}

$users = $cars = $purchases = $bookings = [];

// Initialize variables to avoid "undefined variable" warnings
$total_users = $total_cars = $total_purchases = $pending_purchases = 0;
$total_bookings = $pending_bookings = 0;
$top_purchased_cars = [];

// Fetch all users
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all cars
$stmt = $conn->prepare("SELECT * FROM cars");
$stmt->execute();
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all purchases
$stmt = $conn->prepare("SELECT * FROM purchases");
$stmt->execute();
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all bookings
$stmt = $conn->prepare("SELECT * FROM bookings");
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize variables to avoid "undefined variable" warnings
$total_users = $total_cars = $total_purchases = $pending_purchases = 0;
$total_bookings = $pending_bookings = 0;
$top_purchased_cars = [];

// Fetch total number of users
$stmt = $conn->prepare("SELECT COUNT(*) AS total_users FROM users");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_users = $result['total_users'] ?? 0;

// Fetch total number of cars
$stmt = $conn->prepare("SELECT COUNT(*) AS total_cars FROM cars");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_cars = $result['total_cars'] ?? 0;

// Fetch total purchases and pending/completed purchases
$stmt = $conn->prepare("SELECT COUNT(*) AS total_purchases, 
    SUM(CASE WHEN status='Confirmed' THEN 1 ELSE 0 END) AS completed_purchases, 
    SUM(CASE WHEN status='Pending' THEN 1 ELSE 0 END) AS pending_purchases 
    FROM purchases");
$stmt->execute();
$purchases_stats = $stmt->fetch(PDO::FETCH_ASSOC);
$total_purchases = $purchases_stats['total_purchases'] ?? 0;
$pending_purchases = $purchases_stats['pending_purchases'] ?? 0;

// Fetch total bookings and pending/completed bookings
$stmt = $conn->prepare("SELECT COUNT(*) AS total_bookings, 
    SUM(CASE WHEN status='Confirmed' THEN 1 ELSE 0 END) AS completed_bookings, 
    SUM(CASE WHEN status='Pending' THEN 1 ELSE 0 END) AS pending_bookings 
    FROM bookings");
$stmt->execute();
$bookings_stats = $stmt->fetch(PDO::FETCH_ASSOC);
$total_bookings = $bookings_stats['total_bookings'] ?? 0;
$pending_bookings = $bookings_stats['pending_bookings'] ?? 0;

// Fetch top purchased cars
$stmt = $conn->prepare("SELECT vehiclename, COUNT(*) AS purchase_count 
    FROM purchases 
    GROUP BY vehiclename 
    ORDER BY purchase_count DESC 
    LIMIT 5");
$stmt->execute();
$top_purchased_cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ensure $top_purchased_cars is an array before using it in a foreach loop
if (!$top_purchased_cars) {
    $top_purchased_cars = [];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/adminstyles.css"> <!-- Ensure this file styles your table properly -->
</head>
<header>
<nav class="navbar">
        <a href="#" class="logo">
            <img src="images/logo2.png" alt="logo">
            <h2>CruiseMasters</h2>
        </a>
      
        <button class="btn signup-btn"><a href="adminsearch.php">Search Records</a></button>
        <button class="btn signup-btn"><a href="dashboard.php">Log Out</a></button>
        
    </nav>
<header>
<body>

    <h2>Admin Dashboard - Cruise Masters Dealership</h2>

    <!-- Users Table -->
    <h1>Registered Users</h1>

    <div class="analytics-dashboard">
    <div class="stat-box">
        <h3>Total Users</h3>
        <p><?= $total_users ?></p>
    </div>
    <div class="stat-box">
        <h3>Total Cars</h3>
        <p><?= $total_cars ?></p>
    </div>
    <div class="stat-box">
        <h3>Total Purchases</h3>
        <p><?= $purchases_stats['total_purchases'] ?></p>
        <p>Completed: <?= $purchases_stats['completed_purchases'] ?></p>
        <p>Pending: <?= $purchases_stats['pending_purchases'] ?></p>
    </div>
    <div class="stat-box">
        <h3>Total Bookings</h3>
        <p><?= $bookings_stats['total_bookings'] ?></p>
        <p>Completed: <?= $bookings_stats['completed_bookings'] ?></p>
        <p>Pending: <?= $bookings_stats['pending_bookings'] ?></p>
    </div>
</div>

    <table border="1">
        <tr>
            <th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['firstname']) ?></td>
                <td><?= htmlspecialchars($user['lastname']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                    <a href="editdetails.php?id=<?= $user['id'] ?>">Edit</a> |
                    <a href="deletedetails.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    

    <!-- Cars Inventory Table -->
    <h1>Car Inventory</h1>
    <table border="1">
        <tr>
            <th>Car ID</th>
            <th>Model Name</th>
            <th>Year of Make</th>
            <th>Mileage</th>
            <th>Price</th>
            <th>Image</th>
            
        </tr>
        <?php foreach ($cars as $car): ?>
        <tr>
            <td><?= htmlspecialchars($car['carId']) ?></td>
            <td><?= htmlspecialchars($car['name']) ?></td>
            <td><?= htmlspecialchars($car['year_of_make']) ?></td>
            <td><?= htmlspecialchars($car['mileage']) ?></td>
            <td><?= htmlspecialchars($car['price']) ?></td>
            <td>
                <?php if (!empty($car['image'])): ?>
                    <img src="images/<?= htmlspecialchars($car['image']) ?>" alt="Car Image" width="100">
                <?php else: ?>
                    No Image
                <?php endif; ?>
            </td>
            
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Purchases Table -->
    <h1>Purchases</h1>
    <table border="1">
        <tr>
            <th>ID</th><th>Vehicle</th><th>Purchase Date</th><th>Email</th><th>Status</th><th>Actions</th>
        </tr>
        <?php foreach ($purchases as $purchase): ?>
            <tr>
                <td><?= htmlspecialchars($purchase['purchaseID']) ?></td>
                <td><?= htmlspecialchars($purchase['vehiclename']) ?></td>
                <td><?= htmlspecialchars($purchase['purchasedate']) ?></td>
                <td><?= htmlspecialchars($purchase['email']) ?></td>
                <td><?= htmlspecialchars($purchase['status']) ?></td>
                <td>
                    <a href="updatestatus.php?id=<?= $purchase['purchaseID'] ?>&type=purchase">Mark as Shipped</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Bookings Table -->
    <h1>Bookings</h1>
    <table border="1">
        <tr>
            <th>ID</th><th>Vehicle</th><th>Pickup Date</th><th>Return Date</th><th>Email</th><th>Status</th><th>Actions</th>
        </tr>
        <?php foreach ($bookings as $booking): ?>
            <tr>
                <td><?= htmlspecialchars($booking['bookingsID']) ?></td>
                <td><?= htmlspecialchars($booking['vehiclename']) ?></td>
                <td><?= htmlspecialchars($booking['pickupdate']) ?></td>
                <td><?= htmlspecialchars($booking['returndate']) ?></td>
                <td><?= htmlspecialchars($booking['email']) ?></td>
                <td><?= htmlspecialchars($booking['status']) ?></td>
                <td>
                    <a href="updatestatus.php?id=<?= $booking['bookingsID'] ?>&type=booking">Mark as Picked Up</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h1>Top 5 Purchased Cars</h1>
<table border="1">
    <tr>
        <th>Car Name</th>
        <th>Number of Purchases</th>
    </tr>
    <?php foreach ($top_purchased_cars as $car): ?>
        <tr>
            <td><?= htmlspecialchars($car['vehiclename']) ?></td>
            <td><?= htmlspecialchars($car['purchase_count']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Date', 'Purchases'],
            <?php
            $stmt = $conn->prepare("SELECT DATE(purchasedate) AS date, COUNT(*) AS total FROM purchases GROUP BY DATE(purchasedate) ORDER BY date ASC");
            $stmt->execute();
            $purchase_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($purchase_data as $row) {
                echo "['" . $row['date'] . "', " . $row['total'] . "],";
            }
            ?>
        ]);

        var options = {
            title: 'Car Purchases Over Time',
            curveType: 'function',
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('purchase_chart'));
        chart.draw(data, options);
    }
</script>
<div id="purchase_chart" style="width: 100%; height: 400px;"></div>

</body>
</html>


