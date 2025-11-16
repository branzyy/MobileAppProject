<?php
session_start(); // Start the session if needed
include 'connection/index.php';

// Fetch cars from the database
try {
    $stmt = $conn->prepare("SELECT * FROM cars ORDER BY carId ASC");
    $stmt->execute();
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Fetch purchased cars
    $stmt = $conn->prepare("SELECT vehiclename FROM purchases");
    $stmt->execute();
    $purchasedCars = $stmt->fetchAll(PDO::FETCH_COLUMN); // Fetch as an array of vehicle names
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Models</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin-top : 1000px;
            padding: 20px;
        }
        
        h1 {
            color: #275360;
            text-align: center;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3 cars per row */
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .car {
            position: relative;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s;
        }

        .car:hover {
            transform: translateY(-5px);
        }

        .car img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .desc {
            padding: 15px;
            text-align: center;
        }

        .desc h3 {
            margin: 0 0 10px;
        }

        .desc p {
            margin: 5px 0;
            color: #555;
        }

        /* Sold Icon */
        .sold-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: red;
            color: white;
            padding: 5px 10px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .gallery {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .gallery {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar">
        <a href="#" class="logo">
            <img src="images/logo2.png" alt="logo">
            <h2>CruiseMasters</h2>
        </a>
        <ul class="links">
            <li><a href="home.php">Home</a></li>
            <li><a href="models.php">Models</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact Us</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
        <button class="btn signup-btn"><a href="Home.php">Back</a></button>
        <button class="hamburger-btn" onclick="toggleNavbar()">☰</button>
    </nav>
</header>

<div class="container">
    <h1>Our Car Models</h1>
    <div class="gallery">
        <?php
        if ($cars && count($cars) > 0) {
            foreach ($cars as $car) {
                $isSold = in_array($car["name"], $purchasedCars); // Check if the car has been purchased

                echo '<div class="car">';
                echo '<a href="details.php?car_id=' . urlencode($car["carId"]) . '">';
                
                // Display "SOLD" badge if the car is purchased
                if ($isSold) {
                    echo '<div class="sold-badge">SOLD</div>';
                }

                echo '<img src="images/' . htmlspecialchars($car["image"]) . '" alt="' . htmlspecialchars($car["name"]) . '">';
                echo '<div class="desc">';
                echo '<h3>' . htmlspecialchars($car["name"]) . '</h3>';
                echo '<p>Year: ' . htmlspecialchars($car["year_of_make"]) . '</p>';
                echo '<p>Mileage: ' . htmlspecialchars($car["mileage"]) . '</p>';
                echo '<p>Price: ' . htmlspecialchars($car["price"]) . '</p>';
                echo '</div>';
                echo '</a>';
                echo '</div>';
            }
        } else {
            echo "<p>No cars available.</p>";
        }
        ?>
    </div>
</div>

<footer>
    <p>&copy; 2024 CruiseMasters. All Rights Reserved.</p>
</footer>

</body>
</html>
