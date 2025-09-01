<?php
// Include the database connection file
include "./includes/library.php";

// Connect to Database
$pdo = connectdb();

// Check if the list item ID is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $itemId = $_GET['id'];

    // Fetch data from the database based on the list item ID
    $stmt = $pdo->prepare("SELECT * FROM User_entry WHERE entry_id = ?");
    $stmt->execute([$itemId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        // Handle invalid list item ID (redirect to an error page or main page)
        header("Location: index.php");
        exit();
    }
} else {
    // Handle missing list item ID (redirect to an error page or main page)
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/4d41a90315.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./styles/main.css">
    <title>View List Item</title>
</head>

<body>
    
    <div class="split-layout">
        

        <div class="right-half">
            <nav>
                <div class="backtrack">
                    <ul class="no-bullets">
                        <li><a href="./index.php" style="color: grey;">Main</a></li>
                        <li>></li>
                        <li><a href="./view-item.php" style="color:  navy;">List Item</a></li>
                    </ul>
                </div>
            </nav>

            <main>
                <!-- Code below contains information about a bucket list item -->
                <h2 id="go-summer"><?php echo $result['item_name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="./edit-item.php?id=<?php echo $itemId; ?>"><i class="fa-solid fa-pen-to-square"></i></a> &nbsp;<a href=""><i class="fa-solid fa-trash"></i></a>&nbsp;<a href=""><i class="fa-solid fa-backward"></i></a></h2>

                <div class="itemss">
                    <div class="item-details">
                        <fieldset class="stress">
                            <p data-label="List:"><a href="./Summer.html"><?php echo $result['list_name']; ?></a></p>
                        </fieldset>
                    </div>

                    <div class="item-details">
                        <fieldset class="stress">
                            <p data-label="Completion:"><?php echo $result['completed']; ?></p>
                        </fieldset>
                    </div>

                    <div class="item-details">
                        <fieldset class="stress">
                            <p data-label="Created on:"><?php echo $result['created']; ?></p> 
                        </fieldset>
                    </div>
                </div>

                <p class="custom-paragraph"><?php echo $result['item_description']; ?></p>

                <img src="./img/<?php echo $result['image']; ?>" alt="<?php echo $result['item_name']; ?>" width="700" height="480">

                <div class="viewitemrating">
                    <ul class="no-bullets">
                        <?php
                        $rating = $result['rating'];
                        for ($i = 0; $i < $rating; $i++) {
                            echo '<li><i class="fa-solid fa-star"></i></li>';
                        }
                        for ($i = $rating; $i < 5; $i++) {
                            echo '<li><i class="fa-regular fa-star"></i></li>';
                        }
                        ?>
                    </ul>
                </div>

            </main>

            <?php include './includes/footer.php' ?>
        </div>
    </div>

</body>
</html>
