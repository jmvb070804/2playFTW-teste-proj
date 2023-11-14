<?php
require_once 'DB_connection.php';

$sql = "SELECT * FROM carros";
$result = $conn->query($sql);

// Check for errors
if (!$result) {
    die("Database query failed: " . $conn->error);
}

$carData = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $carData[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slideshow</title>
	
    <link rel="stylesheet" href="css_geral.css">
    <link rel="stylesheet" href="css_car_details.css">

    <link rel="stylesheet" href="https://use.typekit.net/nap8sij.css">
		
</head>
<body>
    <?php include_once 'header.php'; ?>
    
    <div class="slideshow-container">
        <div class="main-image">
            <img src="imgs/car_test.jpg" alt="Image 1">
        </div>
        <div class="thumbnail-container">
            <img src="imgs/car_test.jpg" alt="Image 1" class="thumbnail">
            <img src="imgs/car_test2.jpg" alt="Image 2" class="thumbnail">
            <img src="imgs/car_test.jpg"alt="Image 3" class="thumbnail">
            <img src="imgs/car_test2.jpg" alt="Image 4" class="thumbnail">
            <img src="imgs/car_test.jpg" alt="Image 5" class="thumbnail">
        </div>
        <div class="arrows">
    <img src="imgs/arrow_left.png" alt="Left Arrow" class="arrow-left">
    <img src="imgs/arrow_right.png" alt="Right Arrow" class="arrow-right">
        </div>
    </div>
    <script>
// JavaScript code for slideshow functionality
let slideIndex = 0;
const slides = document.querySelectorAll('.thumbnail');
const mainImage = document.querySelector('.main-image img');

function updateMainImage() {
    mainImage.src = slides[slideIndex].src;
}

function prevSlide() {
    slides[slideIndex].classList.remove('selected'); // Remove the 'selected' class from the current thumbnail
    slideIndex = (slideIndex - 1 + slides.length) % slides.length;
    slides[slideIndex].classList.add('selected'); // Add the 'selected' class to the new thumbnail
    updateMainImage();
    reorderThumbnails(); // Call the function to reorder thumbnails
}

function nextSlide() {
    slides[slideIndex].classList.remove('selected'); // Remove the 'selected' class from the current thumbnail
    slideIndex = (slideIndex + 1) % slides.length;
    slides[slideIndex].classList.add('selected'); // Add the 'selected' class to the new thumbnail
    updateMainImage();
    reorderThumbnails(); // Call the function to reorder thumbnails
}

function reorderThumbnails() {
    const thumbnailContainer = document.querySelector('.thumbnail-container');
    const selectedThumbnail = document.querySelector('.thumbnail.selected');

    // Calculate the index of the selected thumbnail in the middle (3rd position)
    const middleIndex = Math.floor(slides.length / 2);

    // Calculate the index difference between the selected thumbnail and the middle
    const indexDiff = middleIndex - Array.from(thumbnailContainer.children).indexOf(selectedThumbnail);

    // Move the selected thumbnail to the middle
    thumbnailContainer.style.transform = `translateX(${indexDiff * -20}%)`; // Assuming each thumbnail is 20% wide
}

document.querySelector('.arrow-left').addEventListener('click', prevSlide);
document.querySelector('.arrow-right').addEventListener('click', nextSlide);

    </script>
</body>
</html>
