<?php
// Include the database connection file
include "./includes/library.php";

// Connect to Database
$pdo = connectdb();

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $listName = $_POST["list"];
    $itemName = $_POST["gotoasummerfestival"];
    $description = $_POST["description"];  
    $options = $_POST["options"];
    
     

     // Get the user ID from the session
     $userId = $_SESSION['user_id'];

    
    // Insert data into the User_entry table
    $stmt = $pdo->prepare("INSERT INTO User_entry (user_id, list_name, item_name, item_description, options) 
                           VALUES (?, ?, ?, ?, ?)");
    
    
    try {
    $stmt->execute([$userId, $listName, $itemName, $description, $options]);

    // Redirect to the main page after successful submission
    header("Location: index.php");
    exit(); // Make sure to add exit() to stop further execution
} catch (PDOException $e) {
    // Handle the exception, you might want to log it or display an error message
    echo "Error: " . $e->getMessage();
}
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
    <title>New Entry</title>
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
                        <li><a href="./add-entry.php" style="color:  navy;">New entry</a></li>
                    </ul>
                </div>
            </nav>
    
        
        <main>
<!-- Code below is for user to add list entry -->
        <h2 id="edit-entry">New entry</h2>

        <form method="post">  

        <div>
                   <label for="list">Bucket list </label>
                     <select name="list" id="list">
                     <option value="0" selected>Select one</option>
                     <option value="Summer Bucket list">Summer Bucket list</option>
                    <option value="College Bucket list">College bucket list</option>
                    </select>
                  </div>


                <div>   
                <label class="edit-label">Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>   
                <input type="text" placeholder="Enter name" name="gotoasummerfestival" required class="input-edit">
                </div>


                
                


                  

                <div>
                <label class="edit-label">Description : </label>
                <textarea rows="10" cols="50" name="description"></textarea> 
                </div>

                <div>
                   <label for="options">Accessibility: </label>
                     <select name="options" id="options">
                     <option value="0" selected>Select one</option>
                     <option value="private">private </option>
                    <option value="public">public </option>
                    </select>
                  </div>
                

                
               
                
                    <button type="submit">Submit</button>
                </div>
        </form>

    </main>

    <?php include './includes/footer.php' ?>
    </div>
</div>  

</body>
</html>