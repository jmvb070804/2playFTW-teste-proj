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
<div class="flex-containers">
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

    <div class="page-indicators" id="page-indicators">
    	<button class="prev-page">←</button>
    
    	<button class="next-page">→</button>
	</div>
</div>

    <div class="scrollable-card-container" id="scrollable-card-container">
        <main id="card-container">
            
        </main>
    </div>

<script>
    // Card data from the database
    const carData = <?php echo json_encode($carData); ?>;
    const cardsPerPage = 9; // Number of cards per page
    let currentPage = 1;

    // Define CardContainer as a global variable
    const cardContainer = document.getElementById('card-container');

    // Function to update the page indicators
    function updatePageIndicators() {
        const totalPages = Math.ceil(carData.length / cardsPerPage);
        const pageIndicators = document.querySelector('.page-indicators');

        pageIndicators.innerHTML = '';
        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('button');
            pageButton.textContent = i;
            pageButton.classList.add('page-indicator');
            if (i === currentPage) {
                pageButton.classList.add('active');
            }
            pageButton.addEventListener('click', () => {
                currentPage = i;
                updateCards();
                updatePageIndicators();
            });
            pageIndicators.appendChild(pageButton);
        }
    }

    // Function to update the card display based on pagination
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

        // Paginate the filtered cards
        const startIndex = (currentPage - 1) * cardsPerPage;
        const endIndex = startIndex + cardsPerPage;
        const paginatedCards = filteredCards.slice(startIndex, endIndex);

        // Sort the cards
        paginatedCards.sort((a, b) => (a[sortValue] > b[sortValue]) ? 1 : -1);

        // Update the card display
        cardContainer.innerHTML = '';
        paginatedCards.forEach(card => {
            // Create and append card elements
            const cardElement = document.createElement('div');
            cardElement.classList.add('card');

            // Create and append card elements
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

        // Update the page indicators
        updatePageIndicators();
    }

    //Event listeners to filter and sort controls
    const filterSelect = document.getElementById('filter');
    const sortSelect = document.getElementById('sort');
    filterSelect.addEventListener('change', () => {
        currentPage = 1; // Reset to the first page when filtering
        updateCards();
    });
    sortSelect.addEventListener('change', () => {
        currentPage = 1; // Reset to the first page when sorting
        updateCards();
    });

    // Initial card display and page indicators
    updateCards();
	
	// Handling page navigation
	const prevPageButton = document.querySelector('.prev-page');
	const nextPageButton = document.querySelector('.next-page');

	prevPageButton.addEventListener('click', () => {
    	if (currentPage > 1) {
			currentPage--;
			updateCards();
			updatePageIndicators();
    	}
	});

	nextPageButton.addEventListener('click', () => {
		const totalPages = Math.ceil(carData.length / cardsPerPage);
		if (currentPage < totalPages) {
			currentPage++;
			updateCards();
			updatePageIndicators();
		}
	});
	
	
</script>
	

</body>
</html>