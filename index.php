<?php
	require_once 'DB_connection.php';
  	$sql = "SELECT * FROM carros";
	$all_product = $conn->query($sql);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>OTTO'S DEALERSHIP</title>

<!--external files -->
<link rel="stylesheet" href="css_geral.css">

<!-- Fonts -->
<link rel="stylesheet" href="https://use.typekit.net/nap8sij.css">
</head>

<body>
	<?php
		include_once 'header.php';	
	?>
	
	<main>
       <?php
          while($row = mysqli_fetch_assoc($all_product)){
       ?>
		<div class="card">	
			<div class="image">
				<img src="<?php echo $row["Image"]; ?>" alt="">
			</div>
			
		<div class="caption">
			<p class="product_name"> <?php echo $row["name"]; ?></p>
			<p class="price"><b>$<?php echo $row["Price"]; ?>?</b></p>
		</div>
		
		</div>	
		<?php
		}
		?>
		
	</main>

</body>
</html>
