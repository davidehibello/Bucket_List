<?php
// *****************************************************************************
// Process form here:
// *****************************************************************************

// Declare empty array to add errors too
$errors = array();

// Get inputs from $_POST
$username       = $_POST['username'] ?? null;
$password       = $_POST['password'] ?? null;

// Get username from cookie
$cookieUsername = $_COOKIE['remembered_username'] ?? "";

// If a cookie exists, pre-populate the username
if (!empty($cookieUsername)) {
    $username = $cookieUsername;
}

//Check if submit button is in $_POST array
if(isset($_POST['submit'])){
  include "./includes/library.php"; //includes database library
  $pdo = connectdb(); // creates database connection using PDO

  try{
    //Build and run a parametrized database query to select data from the 3420_users table based on the username 
    $query = "SELECT * FROM `User_data` WHERE `username` = ?";
    $stmt = $pdo->prepare($query);
     $stmt->execute([$username]);

     //Fetch the results
        $user = $stmt->fetch();

      // Check if the username exists in the database
        if ($user) {

          // Use password_verify() to compare the password from the form with the hashed password from the database
          if (password_verify($password, $user['password'])) {

              // Start session
              session_start();

               // Put the username and user ID into the session array
               $_SESSION['username'] = $user['username'];
               $_SESSION['user_id'] = $user['user_id'];

                // Redirect to results.php
                header("Location: index.php");
                exit(); // Make sure to stop execution after redirection
            } 

            else {
                // Passwords do not match, set an error
                $errors['password'] = "Invalid password";
            }

          }

           else {
            // Username not found, set an error
            $errors['username'] = "Invalid username";
        }
  }
  catch (PDOException $e) {
    // Handle database connection errors
    $errors['database'] = "Database error: " . $e->getMessage();
}

}
 


// ...
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/4d41a90315.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./styles/main.css">

    <title>Login</title>
</head>

<body>
   
    <div class="split-layout">
        <div class="left-half">
        <h1 id="asty">ASTY</h1>

<!-- Navigation to other pages in website -->
<?php include './includes/nav.php' ?>
    </div>

    <div class="right-half">

        <nav>
    <div class="backtrack">
        <ul class="no-bullets">
            <li><a href="./join.php" style="color: grey;">Join</a></li>
            <li>></li>
            <li><a href="./login.php"  style="color:  navy;">Log in</a></li>
        </ul>
        
    </div>
    </nav>

        <main>
        <h1 id="login">Login</h1>
        <!-- Code below takes users log in information -->
        <form method="post">
 
            <div>   
                <label>Username  </label> 
                <input type="text" placeholder="Enter Username" name="username" required class="input-box" value="<?= $username ?>">
                <?php if (isset($errors) && in_array('Username is required', $errors)) : ?>
                 <span class="error">Please enter your username.</span>
                 <?php endif; ?>
            </div>

            <div>
                <label>Password  </label>   
                <input type="password" placeholder="Enter Password" name="password" required class="input-box"> 
            </div>

            <div>
                <button type="submit" name = 'submit'>Login</button>
            </div>

            <div class="ch-remember">
                <input type="checkbox" class="defaultcheckbox" name="checkbox1" checked="checked"> remember me 
            </div>

                <nav>
                    <div class="f-password">
                     <a href="../assn3/forgot.php"> Forgot password? </a> 
                    </div>
                </nav>   
        </form>     
    </main>
    

    <?php include './includes/footer.php' ?>
    </div>
</div>
</body>
</html>