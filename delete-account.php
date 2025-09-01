<?php
// Include the database connection file
include "./includes/library.php";

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Connect to Database
$pdo = connectdb();

// Get the user ID from the session
$userID = $_SESSION['user_id'];

// Delete all data associated with the user
try {
    // Delete entries associated with the user from the User_entry table
    $stmtEntries = $pdo->prepare("DELETE FROM User_entry WHERE user_id = ?");
    $stmtEntries->execute([$userID]);

    // Delete the user account data from the User_data table
    $stmtUserData = $pdo->prepare("DELETE FROM User_data WHERE id = ?");
    $stmtUserData->execute([$userID]);

    // Destroy the session
    session_destroy();

    // Redirect to the login page after successful deletion
    header("Location: login.php");
    exit();
} catch (PDOException $e) {
    // Handle the exception, you might want to log it or display an error message
    echo "Error: " . $e->getMessage();
}
?>

