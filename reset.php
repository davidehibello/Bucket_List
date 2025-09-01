<?php
include "./includes/library.php";
// Connect to Database
$pdo = connectdb();

// Retrieve data
$newPassword = $_POST['Newpassword'] ?? null;
$confirmNewPassword = $_POST['Confirmnewpassword'] ?? null;
$username = $_POST['username'] ?? null;

// Declare empty array to add errors too
$errors = array();

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Validate the new password and confirmation
    if (empty($newPassword)) {
        $errors['newPassword'] = 'New password is required';
    }

    if (empty($confirmNewPassword)) {
        $errors['confirmNewPassword'] = 'Confirming the new password is required';
    } elseif ($newPassword !== $confirmNewPassword) {
        $errors['confirmNewPassword'] = 'Passwords do not match';
    }

    // If there are no errors, update the password in the database
    if (count($errors) === 0) {
        // Get the user ID from the session 
        session_start();
        $username= $_SESSION['username'];

        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $stmt = $pdo->prepare("UPDATE User_data SET Password = ? WHERE `username` = ?");
        $stmt->execute([$hashedPassword, $username]);

        if ($stmt->rowCount() === 1) {
            // Password updated successfully
            
            header("Location: ./login.php");
            exit();
        } else {
            // Password update failed
            $errors['database'] = 'Failed to update password';
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
    <link rel="stylesheet" href="./styles/main.css">

    <title>Reset password</title>
</head>

<body>

    <nav>
        <div class="backtrack">
          <ul class="no-bullets">
              <li><a href="./join.php" style="color: grey;">Join</a></li>
              <li>></li>
              <li><a href="./login.php"  style="color: rgb(8, 61, 78);">Log in</a></li>
              <li>></li>
              <li><a href="./forgot.php" style="color:rgb(8, 61, 78);">Forgot password</a> </li>
              <li>></li>
              <li><a href="./reset.php" style="color:  navy;">Reset Password</a></li>
          </ul> 
         
              </div>
      </nav>

    <main>
        <h1 id="asty">ASTY</h1>
<!-- Code below allows user to set new password -->
        <h2 id="new-password">Reset Account Password</h2>
       <p>Enter new password below</p>

        <form method="post">

         <div>
          <label>New Password</label>
          <input type="password" placeholder="password" name="Newpassword" required class="input-box">
          <?php if (isset($errors['newPassword'])) : ?>
                    <span class="error"><?= $errors['newPassword'] ?></span>
                <?php endif; ?>
         </div>

         <div>
          <label>Confirm New Password </label>
          <input type="password" placeholder="Confirm Password" name="Confirmnewpassword" required class="input-box">
          <?php if (isset($errors['confirmNewPassword'])) : ?>
                    <span class="error"><?= $errors['confirmNewPassword'] ?></span>
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