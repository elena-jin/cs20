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
}

</style>
</head>
<body>
<?php
class Product {
  public $name;
  public $description;
  public $price;
  function __construct($n, $d, $p) {
    $this->name = $n;
    $this->description = $d;
    $this->price = $p;
  }
}

$products = [
  new Product("Hammer", "This is a great hammer for all of your nails.", 13.56),
  new Product("Screwdriver", "Tool great for ur screws", 11.09),
  new Product("Files", "Adjustable for sanding things down.", 10.99),
  new Product("Wrench", "Strong things to screw around.", 15.49)
];

foreach ($products as $p) {
  echo "<div class='product'>
          <div class='name'>$p->name <span class='price'>\$$p->price</span></div>
          <p>$p->description</p>
        </div>";
}
?>
</body>
</html>
