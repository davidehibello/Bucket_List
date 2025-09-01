<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/4d41a90315.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./styles/main.css">

    <title>Search</title>
</head>

<body>
    <div class="split-layout">

        <div class="left-half">
        <h1 id="asty">ASTY</h1>
        <!-- Navigation-->
        <?php include './includes/nav2.php' ?>
        
    </div>

    <div class="right-half">

        <main>
            <!-- Code below is for search bar -->
            <form method="post">
                <div class="topnav">
                    <input type="text" placeholder="" name="extremesearch" required class="search-box">
                    <button type="submit" name="search">Search</button>
                </div>
            </form>

            <?php
            // Include the database connection file
            include "./includes/library.php";

            // Connect to Database
            $pdo = connectdb();

            // Handle search form submission
            if (isset($_POST['search'])) {
                $searchTerm = $_POST['extremesearch'];

                // Perform a filtered query based on the search criteria
                $stmt = $pdo->prepare("SELECT * FROM User_entry WHERE item_name LIKE ?");
                $stmt->execute(["%$searchTerm%"]);
                $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Display search results
                foreach ($searchResults as $result) {
                    echo '<div>';
                    echo '<h3>' . $result['item_name'] . '</h3>';
                    echo '<p>' . $result['item_description'] . '</p>';
                    echo '</div>';
                }
            }
            ?>
        </main>
        <?php include './includes/footer.php' ?>
    </div>
    </div>  
</body>
</html>
