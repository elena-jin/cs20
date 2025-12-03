<?php
include 'header.php';

include 'db_connect.php';

$firstName = ($_GET['firstName']);
$lastName = ($_GET['lastName']);
$specialInstructions = ($_GET['specialInstructions']);
$pickupTime = ($_GET['pickupTime']);

$subtotal = 0;
$orderedItems = array();

$sql = "SELECT * FROM menu";
$result = $conn->query($sql);

// make sure the data is fetched when order is procesd
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $itemId = $row['id'];
        $quantity = isset($_GET['item_' . $itemId]) ? intval($_GET['item_' . $itemId]) : 0;
        
        if ($quantity > 0) {
            $itemTotal = $row['price'] * $quantity;
            $subtotal += $itemTotal;
            
            $orderedItems[] = array(
                'name' => $row['name'],
                'quantity' => $quantity,
                'price' => $row['price'],
                'total' => $itemTotal
            );
        }
    }
}

$taxRate = 0.0625; // 6.25% taxes baby
$tax = $subtotal * $taxRate;
$total = $subtotal + $tax;


// extra cred
$customerName = $firstName . ' ' . $lastName;
$orderDate = date('Y-m-d H:i:s');

// placeholder characters used within a prepared statement for values
$insertOrder = "INSERT INTO orders (order_date, customer_name, special_instructions, pickup_time, subtotal, tax, total) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($insertOrder);
// bind_param function expects four var, first three r strings, and the fourth is treated as a double (prices)
$stmt->bind_param("ssssddd", $orderDate, $customerName, $specialInstructions, $pickupTime, $subtotal, $tax, $total);
$stmt->execute();

// order ID
$orderId = $conn->insert_id;

// order items
$insertItem = "INSERT INTO order_items (order_id, menu_item_name, quantity, price, item_total) VALUES (?, ?, ?, ?, ?)";
$stmt2 = $conn->prepare($insertItem);

foreach ($orderedItems as $item) {
    $stmt2->bind_param("isidd", $orderId, $item['name'], $item['quantity'], $item['price'], $item['total']);
    $stmt2->execute();
}

$stmt->close();
$stmt2->close();

$conn->close();
?>



<div class="container">
    <h2>Order Confirmation</h2>
    
    <h3>Order Summary</h3>
    
    <?php
    // display the formated items properly
    foreach ($orderedItems as $item) {
        echo '<div class="order-item">';
        echo '<h4>' . $item['name'] . '</h4>';
        echo '<p>Quantity: ' . $item['quantity'] . '</p>';
        echo '<p>Price: $' . number_format($item['price'], 2) . '</p>';
        echo '<p><strong>Total for item (s): $' . number_format($item['total'], 2) . '</strong></p>';
        echo '</div>';
    }
    ?>
    
    <div class="total-section">
        <h3>Order Totals</h3>
        <p>Subtotal: $<?php echo number_format($subtotal, 2); ?></p>
        <p>Tax (6.25%): $<?php echo number_format($tax, 2); ?></p>
        <h3>Total: $<?php echo number_format($total, 2); ?></h3>
    </div>
    
    <div class="customer-info">
        <h3>Customer Information</h3>
        <p><strong>Name:</strong> <?php echo $firstName . ' ' . $lastName; ?></p>
        <p><strong>Pickup Time:</strong> <?php echo $pickupTime; ?></p>
        <?php if (!empty($specialInstructions)) { ?>
            <p><strong>Special Instructions:</strong> <?php echo $specialInstructions; ?></p>
        <?php } ?>
    </div>
    
    <p style="margin-top: 30px;">
        <a href="order_form.php" style="color: #6B4423;">← Place Another Order</a>
    </p>
</div>

</body>
</html>