<?php
session_start();
include 'connection/index.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model_name = trim($_POST['model_name']);
    $year_of_make = trim($_POST['year_of_make']);
    $mileage = trim($_POST['mileage']);
    $price = trim($_POST['price']);

    // Check if an image file was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['image']['name']);
        $target_dir = "images/";
        $target_file = $target_dir . $image_name;

        // Move uploaded file to the images folder
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Insert new car into the database
            $stmt = $conn->prepare("INSERT INTO cars (name, year_of_make, mileage, price, image) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$model_name, $year_of_make, $mileage, $price, $image_name])) {
                echo "<script>alert('Car added successfully!'); window.location.href='admin.php';</script>";
            } else {
                echo "<script>alert('Failed to add car.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Image upload failed.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Please upload an image.'); window.history.back();</script>";
    }
} else {
    header("Location: admin.php");
    exit();
}
?>
