<?php
include "./includes/library.php";
// Connect to Database
$pdo = connectdb();

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Retrieve user data
$username = $_SESSION['username'];

// Declare empty arrays to store errors and success messages
$errors = array();
$success = array();

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve data from the form
    $newUsername = $_POST['newUsername'] ?? null;
    $newName = $_POST['newName'] ?? null;
    $newEmail = $_POST['newEmail'] ?? null;
    $newPassword = $_POST['newPassword'] ?? null;

    // Validate data

if (empty($newUsername)) {
    $errors[] = 'Username is required';
}
if (empty($newName)) {
    $errors[] = 'Name is required';
}
if (empty($newEmail)) {
    $errors[] = 'Email is required';
}
if (empty($newPassword)) {
    $errors[] = 'Password is required';
}

    // If validation passes, update the database
    if (empty($errors)) {
        try {
            // Build and run a parametrized database query to update user data
            $query = "UPDATE `User_data` SET `username` = ?, `name` = ?, `email` = ? WHERE `username` = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$newUsername, $newName, $newEmail, $username]);

            // Check if password is provided and update it
            if (!empty($newPassword)) {
                // Hash the new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the password in the database
                $query = "UPDATE `User_data` SET `password` = ? WHERE `username` = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$hashedPassword, $username]);
            }

            // Set success message
            $success['update'] = "Account details updated successfully!";

            // Redirect to the main page
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            // Handle database connection errors
            $errors['database'] = "Database error: " . $e->getMessage();
        }
    }
} else {
    // Fetch existing user data to pre-populate the form
    try {
        $query = "SELECT * FROM `User_data` WHERE `username` = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username]);
        $user = $stmt->fetch();
    } catch (PDOException $e) {
        // Handle database connection errors
        $errors['database'] = "Database error: " . $e->getMessage();
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
   
    <title>Edit Account</title>
</head>

<body>
    

    <div class="split-layout">
     <div class="left-half">
        <h1 id="asty">ASTY</h1>
        <nav>
            <div class="mylist">
        <h2 id="mylists">My Lists</h2>
        <ul class="no-bullets">
            <li><i class="fa-solid fa-umbrella-beach"></i><a href="./Summer.php">Summer Bucket List</a></li>
            <li><i class="fa-solid fa-building-columns"></i><a href="./college.php">College Bucket List</a></li>
        </ul>
            </div>

            <div class="exp">
        <h2 id="explore">Explore</h2>
        <ul class="no-bullets">
            <li><i class="fa-regular fa-compass"></i><a href="./explore-public.php">Explore Public lists</a></li>
            <li><i class="fa-solid fa-shuffle"></i><a href="./random-list.php">Random List Entry </a></li>
            <li><i class="fa-solid fa-magnifying-glass"></i><a href="./search.php">Search </a></li>
        </ul>
            </div>

        <div class="account">
        <ul class="no-bullets">
            <li><i class="fa-solid fa-user"></i><a href="">Pofile</a></li>
            <li><i class="fa-solid fa-pen-to-square"></i><a href="./editaccount.php">Edit account</a></li>
            <li><i class="fa-solid fa-right-from-bracket"></i><a href="./logout.php">Log out</a></li>
        </ul>
        </div>
        </nav>
     </div>

        <div class="right-half">
     <nav>
                <div class="backtrack">
            <ul class="no-bullets">
                <li><a href="./edit-account.php" style="color:  navy;">Edit Account</a></li>
            </ul> 
           
                </div>
        </nav>

        <main>
        <h2 id="edit-account">Edit Account</h2>
        <!-- Code below is to collect users new data(username, name, email, password) to edit database -->
        <form method="post" action="edit-account.php">  

                <div>   
                <label for="username">Username  </label>   
                <input type="text" placeholder="" name="newUsername" id="username" required class="input-box" required value="<?= $user['username'] ?>">
                
                </div>  

                <div> 
                <label for="username">Name </label>
                <input type="text" placeholder="" name="newName" required class="input-box"  required value="<?= $user['name'] ?>">
                
                </div>

                <div>
                <label>Email &nbsp; &nbsp; &nbsp;  </label>
                <input type="email" placeholder="" name="newEmail" required class="input-box" required value="<?= $user['email'] ?>">
                
                
                </div>

                <div>
                <label>New Password </label>   
                <input type="password" placeholder="" name="newPassword" required class="input-box" >
                </div>

                <?php if (isset($errors['database'])) : ?>
            <span class="error"><?= $errors['database'] ?></span>
        <?php endif; ?>

        <?php if (isset($success['update'])) : ?>
            <span class="success"><?= $success['update'] ?></span>
        <?php endif; ?>

                <div>
               <button type="submit" name="submit">Submit</button>
                </div>

               
                  
        </form>   
        </main>
    
    <?php include './includes/footer.php' ?>
</div>
</div>
</body>

</html>
