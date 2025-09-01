<?php
// Include the database connection file
include "./includes/library.php";

// Connect to Database
$pdo = connectdb();

// Start the session
session_start();

// Check if an entry_id is provided in the URL
if (isset($_GET['id'])) {
    $entryId = $_GET['id'];

    // Fetch the entry from the User_entry table
    $stmt = $pdo->prepare("SELECT * FROM User_entry WHERE entry_id = ?");
    $stmt->execute([$entryId]);
    $entry = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the entry exists and the user owns it
    if ($entry && $entry['user_id'] == $_SESSION['user_id']) {
        // Delete the entry from the database
        $stmt = $pdo->prepare("DELETE FROM User_entry WHERE entry_id = ?");
        $stmt->execute([$entryId]);

        // Redirect to the main page after deletion
        header('Location: index.php');
        exit();
    } else {
        // Entry not found or user does not own it, handle accordingly
        echo 'Entry not found or you do not have permission to delete.';
    }
} else {
    // No entry_id provided in the URL
    echo 'Invalid request.';
}
?>
