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

    <!-- Add filter and sorting controls -->
    <div class="filters">
<label for="sort">Ordenar por:</label>
        <select id="sort">
            <option value="name">Nome</option>
            <option value="price">Preço</option>
        </select>
		
		<label for="filter" class="sort_margin">Filtros:</label>
        <select id="filter">
			<option value="all">Todos</option>
            <option value="Desportivos">Desportivos</option>
			<option value="classico">Clássicos</option>
			<option value="S">Classe D</option>
			<option value="D">Classe S</option>
        </select>
    </div>

    <main id="card-container">
    </main>

<script>
        //card data from the database
        const carData = <?php echo json_encode($carData); ?>;

        // Get references to filter and sort controls
        const filterSelect = document.getElementById('filter');
        const sortSelect = document.getElementById('sort');
        const cardContainer = document.getElementById('card-container');

        // Function to filter and sort cards
        function updateCards() {
            const filterValue = filterSelect.value;
            const sortValue = sortSelect.value;

            // Filter the cards
            const filteredCards = filterValue === 'all' ?
        carData : carData.filter(card => {
            if (filterValue === 'Desportivos') {
                return card.Tag === 'Desportivos';
            } else if (filterValue === 'classico') {
                return card.Tag === 'classico';
            } else if (filterValue === 'S') {
                return card.Classe === 'S';
            } else if (filterValue === 'D') {
                return card.Classe === 'D';
            }
        });

	// Sort the cards
    filteredCards.sort((a, b) => (a[sortValue] > b[sortValue]) ? 1 : -1);

    // Update the card display
    cardContainer.innerHTML = '';
    filteredCards.forEach(card => {
   		// Create and append card elements here
    	const cardElement = document.createElement('div');
    	cardElement.classList.add('card');
                
        // Create and append card elements
        // Example:
		cardElement.innerHTML = `
            <div class="image">
            	<img src="${card.Image}" alt="Car Image">
            </div>
            <div class="caption">
            	<p class="product_name"><b>${card.name}</b></p>
            </div>
            	<div class="lower-caption">
					<div class="buttons">
						<a href="#" class="tag-button">${card.Tag}</a>
                		<a href="#" class="tag-button">Classe ${card.Classe}</a>
            		</div>
						<p class="price">$${card.Price}</p>
          	</div>
        `;
                
        cardContainer.appendChild(cardElement);
    });
}

        // Attach event listeners to filter and sort controls
        filterSelect.addEventListener('change', updateCards);
        sortSelect.addEventListener('change', updateCards);

        // Initial card display
        updateCards();
    </script>
</body>
</html>
