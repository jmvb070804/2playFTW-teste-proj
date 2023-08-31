<?php
    require_once 'DB_connection.php';
    $sql = "SELECT * FROM carros";
    $result = $conn->query($sql);

    // Check for errors
    if (!$result) {
        die("Database query failed: " . $conn->error);
    }
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTTO'S DEALERSHIP</title>

    <!-- External files -->
    <link rel="stylesheet" href="css_geral.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://use.typekit.net/nap8sij.css">
</head>

<body>
    <?php include_once 'header.php'; ?>

    <main>
        <?php
        while ($row = $result->fetch_assoc()) {
        ?>
            <div class="card">
                <div class="image">
                    <img src="<?php echo htmlspecialchars($row["Image"]); ?>" alt="Car Image">
                </div>

                <div class="caption">
                    <p class="product_name"><b><?php echo htmlspecialchars($row["name"]); ?></b></p>
                </div>

                <div class="lower-caption">
					<div class="buttons">
                    	<a href="#" class="tag-button"><?php echo htmlspecialchars($row["Tag"]); ?></a>
                    	<a href="#" class="tag-button">Classe <?php echo htmlspecialchars($row["Classe"]); ?></a>
                    	<p class="price"><b>$<?php echo htmlspecialchars($row["Price"]); ?></b></p>
					</div>
				</div>
            </div>
        <?php
        }
        $result->free(); // Free up the result set
        ?>

    </main>
    
    <?php
    $conn->close(); // Close the database connection
    ?>

</body>
</html>