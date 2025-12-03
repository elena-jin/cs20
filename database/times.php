<?php
$n = isset($_GET['n']) ? intval($_GET['n']) : 1;
echo "<h2>Times Table for $n</h2>";
for ($i = 1; $i <= 15; $i++) {
    $result = $i * $n;
    echo "$i x $n = $result<br>";
}
?>