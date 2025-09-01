<?php
// Include the database connection file
include "./includes/library.php";

// Connect to Database
$pdo = connectdb();

// Fetch public lists from the User_entry table
$stmt = $pdo->query("SELECT * FROM User_entry WHERE options = 'public'");
$publicLists = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/4d41a90315.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./styles/main.css">


    <title>Public List</title>
</head>

<body>
       
    <div class="split-layout">
        <div class="left-half">
        <h1 id="asty">ASTY</h1>
        <!-- Navigation -->
        <?php include './includes/nav2.php' ?>
    </div>

        <div class="right-half">

        <main>

        <h1 id="bucket-list">Public Bucket Lists</h1>

        <?php
                if (!empty($publicLists)) {
                    foreach ($publicLists as $list) {
                        echo '<div class="public-list">';
                        echo '<h2>' . htmlspecialchars($list['list_name']) . '</h2>';
                        echo '<ul>';

                        // Fetch items for this list
                        $stmt = $pdo->prepare("SELECT * FROM User_entry WHERE list_name = ? AND options = 'public'");
                        $stmt->execute([$list['list_name']]);
                        $listItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($listItems as $item) {
                            echo '<li>';
                            echo '<h3>' . htmlspecialchars($item['item_name']) . '</h3>';
                            echo '<p>' . htmlspecialchars($item['item_description']) . '</p>';
                            echo '</li>';
                        }

                        echo '</ul>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No public lists found.</p>';
                }
                ?>

    </main>

    <?php include './includes/footer.php' ?>
    </div>
</div>
</body>
</html>