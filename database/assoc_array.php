<!DOCTYPE html>
<html>
<head>
<style>
body {
  padding: 20px;
}
h2 {
    color: red;
    vertical-align: top;
    text-align: center;
}

p {
    vertical-align: top;
    text-align: center;
}
</style>

</head>
<body>
<div class="container">
<h2>Office Hours</h2>
<?php
$hours = [
    "Monday" => "9am - 4pm",
    "Tuesday" => "9am - 4pm",
    "Wednesday" => "9am - 4pm",
    "Thursday" => "9am - 6pm",
    "Friday" => "9am - 3pm",
    "Saturday" => "Closed",
    "Sunday" => "Closed"
];

foreach ($hours as $day => $time) {
    echo "<p><span class='day'>$day:</span> $time</p>";
}
?>
</div>
</body>
</html>
