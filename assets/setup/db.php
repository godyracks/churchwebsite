<?php

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '@godygaro66';
$database = 'guka';

// Create a database connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Set the character set to UTF-8 (if needed)
mysqli_set_charset($conn, 'utf8');

// Close the database connection
function closeDBConnection() {
    global $conn;
    mysqli_close($conn);
}

?>



