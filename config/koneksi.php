<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "db_bengkel";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

global $conn; 
    
    $eksekusi = mysqli_query($conn, $sql) or die("<b>Database Error:</b> " . mysqli_error($conn));
    
    return $eksekusi;
?>