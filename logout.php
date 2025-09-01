<?php

session_start();

// Declare empty array to add errors too
$errors = array();

session_destroy();

header("location: login.php");