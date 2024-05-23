 <?php
$servername = "mysql-bankgestion.alwaysdata.net";
$username = "359571";
$password = "mesErvices76@";
$dbname = "bankgestion_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 