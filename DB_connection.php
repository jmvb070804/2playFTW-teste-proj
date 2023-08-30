
<!-- PHP MySQL connection -->
<?php
$conn = mysqli_connect("localhost", "myideas_2playtesteproj", "2playteste", "myideas_2playtesteproj");

if ($conn === false) {
    die("ERROR: Could not connect. "
        . mysqli_connect_error());
}
?>