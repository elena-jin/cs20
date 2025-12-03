<?php
// copied from last assignment without css
$servername = "localhost";
$username = "ugeb0nggou4ff";
$password = "IWillPass100";
$dbname = "dbxoc6btvjqayu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>