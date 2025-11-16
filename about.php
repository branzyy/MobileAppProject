<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Cruise Masters Dealership</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 50px;
            background: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            margin-top: 100px; /* Push content down */
        }

        h1,h2 {
            text-align: center;
            color: #275360;
        }

        

        p {
            font-size: 18px;
            line-height: 1.6;
            color: #555;
            text-align: justify;
        }

        .mission {
            background: white;
            color: black;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            margin-top: 30px;
        }
        

        .footer {
            text-align: center;
            padding: 20px;
            background: #333;
            color: white;
            margin-top: 40px;
        }
    </style>
</head>
<body style="margin-top: 90px;">

<header>
        <nav class="navbar">
            <span class="hamburger-btn material-symbols-rounded">menu</span>
            <a href="#" class="logo">
                <img src="images/logo2.png" alt="logo">
                <h2>CruiseMasters</h2>
            </a>
            <ul class="links">
                
                <li><a href="home.php">Home</a></li>
                <li><a href="models.php">Models</a></li>
                <li><a href="about.php">About us</a></li>
                <li><a href="contact.php">Contact us</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
            <form action="logout.php" method="POST" style="display: inline;">
            <button class="btn signup-btn">Log Out</a></button>
            <button class="hamburger-btn" onclick="toggleNavbar()"></button>
        </form>
        </nav>
    </header>

    <div class="container">
        <h1>About Cruise Masters Dealership</h1>
        <p>
            Welcome to <strong>Cruise Masters Dealership</strong>, your trusted partner in the automobile industry.
            We specialize in providing top-quality vehicles for purchase and rental, ensuring customer satisfaction and
            reliability. Our goal is to make car ownership and rental a seamless and enjoyable experience.
        </p>

        <div class="mission">
            <h2>Our Mission</h2>
            <p>To provide the best automotive solutions through quality vehicles, excellent customer service, and affordable pricing.</p>
        </div>

        <div class="mission">
        <h2>Why Choose Us?</h2>
        <up>
            <li>Wide range of vehicles for purchase and rental</li>
            <li>Affordable pricing and flexible financing options</li>
            <li>Reliable and well-maintained cars</li>
            <li>Excellent customer service</li>
        </ul>
    </div>
    </div>

    <script src="js/script.js"></script>


    <div class="footer">
        &copy; <?php echo date("Y"); ?> Cruise Masters Dealership. All Rights Reserved.
    </div>

</body>
</html>


