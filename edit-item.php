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

    // Check if the user owns the list item
    $userId = 1; 
    if ($result['user_id'] != $userId) {
        // Handle unauthorized access (redirect to an error page or main page)
        header("Location: index.php");
        exit();
    }
} else {
    // Handle missing list item ID (redirect to an error page or main page)
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $listName = $_POST["list"];
    $itemName = $_POST["gotoasummerfestival"];
    $state = isset($_POST["state"]) ? $_POST["state"] : '';
    $created = $_POST["item-start"];
    $completed = $_POST["item-Completion"];
    $description = $_POST["description"];
    $rating = isset($_POST["rating"]) ? (int)$_POST["rating"] : 0;
   
    // Update data in the User_entry table
    $stmt = $pdo->prepare("UPDATE User_entry SET list_name = ?, item_name = ?, item_description = ?, options = ?, completion_status = ?, created = ?, completed = ?, rating = ?, WHERE entry_id = ?");
    $stmt->execute([$listName, $itemName, $description, 'private', $state, $created, $completed, $rating,  $itemId]);

    // Redirect to the main page after successful submission
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
    <script defer src="./scripts/edit.js"></script>
    <title>Edit List Item</title>
</head>

<body>
    <div class="split-layout">
        <div class="left-half">
        <h1 id="asty">ASTY</h1>
        
        <!-- Navigation-->
        <?php include './includes/nav2.php' ?>
        </div>

            <div class="right-half">
                <nav>
                <div class="backtrack">
                    <ul>
                        <li><a href="./index.php" style="color: grey;">Main</a></li>
                        <li>></li>
                        <li><a href="./edit-item.php" style="color:  navy;">Edit enttry</a></li>
                    </ul>
                </div>
            </nav>
    
        
        <main>
<!-- Code below is for user to edit list item -->
        <h2 id="edit-entry">Edit Entry</h2>

        <form method="post" id="edit-form">  
        <div>
        <label for="list">Bucket list </label>
        <select name="list" id="list">
            <option value="0" <?php echo ($result['list_name'] == '0') ? 'selected' : ''; ?>>Select one</option>
            <option value="Summer Bucket list" <?php echo ($result['list_name'] == 'Summer Bucket list') ? 'selected' : ''; ?>>Summer Bucket list</option>
            <option value="College Bucket list" <?php echo ($result['list_name'] == 'College Bucket list') ? 'selected' : ''; ?>>College bucket list</option>
        </select>
        <div class="error"></div>
    </div>

    <div>   
        <label class="edit-label">Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>   
        <input type="text" placeholder="Go to a summer festival" name="gotoasummerfestival" required class="input-edit" value="<?php echo $result['item_name']; ?>">
        <div class="error"></div>
    </div>

    <div>
        <label class="edit-label">State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>

        <div class="radio-buttons">
            <input type="radio" id="in-progress" name="state" value="In-Progress" <?php echo ($result['completion_status'] == 'In-Progress') ? 'checked' : ''; ?>>
            <label for="in-progress">In-Progress</label>
        </div>

        <div class="radio-buttons">
            <input type="radio" id="completed" name="state" value="Completed" <?php echo ($result['completion_status'] == 'Completed') ? 'checked' : ''; ?>>
            <label for="completed">Completed</label>
        </div>
        <div class="error"></div>
    </div>

    <div>
        <div>
            <label class="edit-label">Created&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="date" id="start" name="item-start" value="<?php echo $result['created']; ?>" min="2018-01-01" max="2025-12-31" required class="input-edit">
        </div>

        <div>
            <label class="edit-label">Completed</label>
            <input type="date" id="completion" name="item-Completion" value="<?php echo $result['completed']; ?>" min="2018-01-01" max="2025-12-31" required class="input-edit">
        </div>
        <div class="error"></div>
    </div>

    <div>
        <label class="edit-label">Description : </label>
        <textarea rows="10" cols="50" name="description"><?php echo $result['item_description']; ?></textarea> 
        <div class="error"></div>
    </div>

    <div>
        <label for="rating">Rating: </label>
        <div name="star-rating" id="sta-rating" class="star-rating">
        <?php
        // Loop to generate stars based on the current rating
        for ($i = 1; $i <= 5; $i++) {
            $checked = ($i == $result['rating']) ? 'checked' : '';
            echo "<input type='radio' id='star{$i}' name='rating' value='{$i}' {$checked} />";
            echo "<label for='star{$i}' title='{$i} stars'>{$i}</label>";
        }
        ?>
        </div>
        <div class="error"></div>
    </div>


    <div>
        <label class="edit-label">Details : </label>
        <textarea rows="10" cols="50" name="details"></textarea> 
        <div id="character-counter"></div>
        <div class="error"></div>
    </div>

    <div>
        <label for="myfile">Image </label>
        <input type="File" id="myfile" name="myFile">
        <div class="error"></div>
    </div>

    <div>
        <button type="submit">Submit</button>
    </div>
        </form>

    </main>

    <?php include './includes/footer.php' ?>
    </div>
</div>  

</body>
</html>