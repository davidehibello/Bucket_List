<?php
include "./includes/library.php";
//Connect to Database
$pdo = connectdb();


//Retrieve Data
$username = $_POST['username'] ?? null;
$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;




// Declare empty array to add errors too
$errors = array();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    /* Validation from previous assignment is commented out so that your JavaScript can
   * be responsible for it instead */
  /* ---------------------------------------------------------------------------


//Validate variables
if (empty($username)) {
    $errors[] = 'Username is required';
}
if (empty($name)) {
    $errors[] = 'Name is required';
}
if (empty($email)) {
    $errors[] = 'Email is required';
}
if (empty($password)) {
    $errors[] = 'Password is required';
}




//Validate username
$similar_username = get_username($pdo, $username);
if ($similar_username !== null) {
    $errors[] = 'There is already a similar username';
}
--------------------------------------------------------------------------- */
 




//Insert record into database if no recorded errors
if (count($errors) === 0) {
    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO User_data (Username, Name, Email, Password) VALUES (?,?,?,?)");
    $stmt->execute([$username, $name, $email, $encrypted_password]);
    if ($stmt->rowCount() === 1) {
        $user_id = $pdo->LastInsertId();
        //start session
        session_start();
        // Put the username and user ID into the session array
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user_id ;
        // Redirect to index..php
        header('Location: index.php');
        exit(); // Make sure to stop execution after redirection
    } else {
        // Records do not match, set an error
        $errors[] = "Invalid record, cannot insert into database.";
    }
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
    <script defer src="./scripts/main.js"></script>
    <title>Create Account</title>
</head>


<body>
   


    <div class="split-layout">
     <div class="left-half">
        <h1 id="asty">ASTY</h1>
        <?php include './includes/nav.php' ?>
     </div>


        <div class="right-half">
     <nav>
                <div class="backtrack">
            <ul class="no-bullets">
                <li><a href="./join.php" style="color: grey;">Join</a></li>
                <li>></li>
                <li><a href="./create-account.php" style="color:  navy;">Create Account</a></li>
            </ul>
           
                </div>
        </nav>




      <main>
        <h2 id="create-account">Create Account</h2>


        <!-- Code below is to collect users data(username, name, email, password) -->
        <form id="create-form" method="post" novalidate>  


                <div>  
                <label for="username">Username  </label>  
                <input type="text" placeholder="Enter username" name="username" id="username" required class="input-box" value="<?= $username ?>">
                 <?php if (isset($errors) && in_array('Username is required', $errors)) : ?>
                 <span class="error">Please enter your username.</span>
                 <?php endif; ?>
                </div>  


                <div>
                <label for="username">Name </label>
                <input type="text" placeholder="Enter name" name="name" required class="input-box"  value="<?= $name ?>">
                <?php if (isset($errors) && in_array('Name is required', $errors)) : ?>
                <span class="error">Please enter your name.</span>
                <?php endif; ?>
                </div>


                <div>
                <label>Email &nbsp; &nbsp; &nbsp;  </label>
                <input type="email" placeholder="Enter email" name="email" required class="input-box" value="<?= $email ?>">
                <?php if (isset($errors) && in_array('Email is required', $errors)) : ?>
                 <span class="error">Please enter a correct email.</span>
                <?php endif; ?>
               
                </div>


                <div>
                <label>Password </label>  
                <input type="password" placeholder="Enter password" name="password" required class="input-box" value="<?= $password ?>">
                <?php if (isset($errors) && in_array('Password is required', $errors)) : ?>
                <span class="error">Please enter your desired password.</span>
                <?php endif; ?>
                </div>


                <div>
               <button type="submit">Submit</button>
                </div>


                <div class="ch-remember">
                    Remember me:
                <input type="checkbox" class="defaultcheckbox" name="checkbox1" checked="checked">  
                </div>
                 
        </form>  
           
      </main>
   
      <?php include './includes/footer.php' ?>
</div>
</div>
</body>


</html>
