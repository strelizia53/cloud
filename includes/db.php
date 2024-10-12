<?php
// db.php - Database Connection Script

$servername = "localhost";  // Change this if your MySQL server is hosted elsewhere
$username = "root";         // Default username for MySQL (change if different)
$password = "";             // Default password for root (change if different)
$dbname = "music_player_db"; // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// To ensure the connection works
// Uncomment the line below to check connection status during testing
// echo "Connected successfully";
?>
