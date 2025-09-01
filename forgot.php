<?php
include "./includes/library.php";
// Connect to Database
$pdo = connectdb();

// Retrieve data
$username = $_POST['Username'] ?? null;

// Declare empty array to add errors to
$errors = array();

// Check if the form is submitted
if (isset($_POST['submit'])) {
    try {
        // Build and run a parametrized database query to select data from the User_data table based on the username 
        $query = "SELECT * FROM `User_data` WHERE `username` = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username]);

        // Fetch the results
        $user = $stmt->fetch();

        // Check if the username exists in the database
        if ($user) {
            // Start session
            session_start();

            // Put the username and user ID into the session array
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['user_id'];

            // Redirect to mail.php
            header("Location: ./includes/mail.php");
            exit(); // Make sure to stop execution after redirection
        } else {
            // Username not found, set an error
            $errors['username'] = "Invalid username";
        }
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
    <link rel="stylesheet" href="./styles/main.css">
    <title>Forgot Password</title>
</head>

<body>

<nav>
    <div class="backtrack">
        <ul class="no-bullets">
            <li><a href="./join.php" style="color: grey;">Join</a></li>
            <li>></li>
            <li><a href="./login.php" style="color: rgb(8, 61, 78);">Log in</a></li>
            <li>></li>
            <li><a href="./forgot.php" style="color: navy;">Forgot password</a> </li>
        </ul> 
    </div>
</nav>

<main>
    <h1 id="asty">ASTY</h1>
    <!-- Code below is to collect user's data (username) -->
    <h2 id="Forgot-password">Forgot Password</h2>
    <p>Please enter your Username and Email address associated with your Asty account to change your password.</p>

    <form method="post">
        <div>
            <label>Username  </label>
            <input type="text" placeholder="Enter Username" name="Username" required class="input-box" value="<?= $username ?>">
            <?php if (isset($errors['username'])) : ?>
                <span class="error"><?= $errors['username'] ?></span>
            <?php endif; ?>
        </div>

        <div>
            <button type="submit" name="submit">Continue</button>
        </div>
    </form>
</main>

<?php include './includes/footer.php' ?>

</body>
</html>
