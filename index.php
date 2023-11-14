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
        <div class="arrows">
            <span class="arrow-left">&lt;</span>
            <span class="arrow-right">&gt;</span>
        </div>
        <div class="thumbnail-container">
    	<div class="arrows">
        	<span class="arrow-left">&lt;</span>
        	<span class="arrow-right">&gt;</span>
    	</div>
    		<img src="imgs/car_test.jpg" alt="Image 1" class="thumbnail">
    		<img src="imgs/car_test2.jpg" alt="Image 2" class="thumbnail">
    		<img src="imgs/car_test.jpg" alt="Image 3" class="thumbnail">
    		<img src="imgs/car_test2.jpg" alt="Image 4" class="thumbnail">
    		<img src="imgs/car_test.jpg" alt="Image 5" class="thumbnail">
		</div>
    	</div>
    <script>
        // JavaScript code for slideshow functionality
let slideIndex = 2; // Start with the 3rd image as selected (0-based index)
const slides = document.querySelectorAll('.thumbnail');
const mainImage = document.querySelector('.main-image img');

function updateMainImage() {
    mainImage.src = slides[slideIndex].src;
}

function prevSlide() {
    slideIndex = (slideIndex - 1 + slides.length) % slides.length;
    updateMainImage();
    reorderThumbnails();
}

function nextSlide() {
    slideIndex = (slideIndex + 1) % slides.length;
    updateMainImage();
    reorderThumbnails();
}

function reorderThumbnails() {
    // Remove the selected class from all thumbnails
    slides.forEach((thumbnail) => thumbnail.classList.remove('selected'));

    // Add the selected class to the current slide
    slides[slideIndex].classList.add('selected');

    // Move the selected thumbnail (3rd image) to the center
    slides[slideIndex].style.order = 2;

    // Move the other thumbnails accordingly
    for (let i = 0; i < slides.length; i++) {
        if (i < slideIndex) {
            slides[i].style.order = i;
        } else if (i > slideIndex) {
            slides[i].style.order = i + 1;
        }
    }
}

document.querySelector('.arrow-left').addEventListener('click', prevSlide);
document.querySelector('.arrow-right').addEventListener('click', nextSlide);

// Initial setup
updateMainImage();
reorderThumbnails();

    </script>
</body>
</html>
