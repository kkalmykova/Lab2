<?php
$servername = "localhost";
$username = "root";
$rootpassword = "";
$database = "testdb"; //повинна бути створена в субд


// Встановлення з'єднання 
$connect = mysqli_connect($servername, $username, $rootpassword, $database);

// Перевірка з'єднання
if (!$connect) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
?>


