<?php
// Include the database connection file
include "./includes/library.php";

// Connect to Database
$pdo = connectdb();

// Start the session
session_start();

// Get the user ID from the session
$userId = $_SESSION['user_id'];

// Fetch data from the User_entry table
$stmt = $pdo->query("SELECT * FROM User_entry");
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/4d41a90315.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./styles/main.css">
    <script defer src="./scripts/model.js"></script>
    <title>Main</title>
</head>

<body>
    <div class="split-layout">
        <div class="left-half">
            <h1 id="asty">ASTY</h1>
            <?php include './includes/nav2.php' ?> 
            
        </div>

        <div class="right-half">
            <main>
                <h1 id="bucket-list">Bucket Lists</h1>

                <?php
                // Group entries by list_name
                $groupedEntries = [];
                foreach ($entries as $entry) {
                    $groupedEntries[$entry['list_name']][] = $entry;
                }

                // Loop through each list
                foreach ($groupedEntries as $listName => $listEntries) {
                    echo '<div class="summer-list">';
                    echo '<h2><span>' . $listName . '&nbsp;&nbsp;&nbsp;</span></h2>';
                    echo '<ul>';

                    // Loop through each entry in the list
                    foreach ($listEntries as $entry) {
                        echo '<li>';
                        echo '<h3>' . $entry['item_name'] . '&nbsp;<a href="./view-item.php?id=' . $entry['entry_id'] . '" class="view-item-link" data-item-id=' . $entry['entry_id'] . '"><i class="fa-solid fa-eye"></i></a><a href="./edit-item.php?id=' . $entry['entry_id'] . '"><i class="fa-solid fa-pen-to-square"></i></a><a href="./delete-item.php?id=' . $entry['entry_id'] . '" class="delete-item-link" data-item-id=' . $entry['entry_id'] . '"><i class="fa-solid fa-trash"></i></a></h3>';
                        echo '<p>' . $entry['item_description'] . '</p>';
                        echo '</li>';
                    }

                    echo '</ul>';
                    echo '</div>';
                }
                ?>
            </main>

            <?php include './includes/footer.php' ?>
        </div>
    </div>
</body>

</html>
