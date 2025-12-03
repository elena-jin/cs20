<!DOCTYPE html>
<html>
<head>
<style>
body {
  padding: 20px;
}
.product {
  border: 1px solid #ccc;
  color: red;
  padding: 15px;
  width: 45%;
  background: white;
  display: inline-block;
  margin: 10px;
  vertical-align: top;
  text-align: center;
}
.product img {
  width: 400px;
  height: 400;
  object-fit: contain;
  margin-bottom: 10px;
}

</style>
</head>
<body>
<?php

$servername = "localhost";
$username = "ugeb0nggou4ff";
$password = "IWillPass100";
$dbname = "dbt3jxbforrdqi";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// display products
$result = $conn->query("SELECT * FROM products");
if ($result->num_rows > 0) {
  while ($p = $result->fetch_assoc()) {
    echo "<div class='product'>
            <img src='{$p['image']}' alt='{$p['name']}'>
            <div class='name'>{$p['name']} <span class='price'>\${$p['price']}</span></div>
            <p>{$p['description']}</p>
          </div>";
  }
} else {
  echo "No products found.";
}

$conn->close();
?>
</body>
</html>
