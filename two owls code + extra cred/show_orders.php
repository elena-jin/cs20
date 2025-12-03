<?php
include 'header.php';
include 'db_connect.php';

// get all orders
$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);
?>

<div class="container">
    <h2>All Orders, Admin View</h2>
    
    <?php
    if ($result->num_rows > 0) {
        while($order = $result->fetch_assoc()) {
            echo '<div class="order-item">';
            echo '<h3>Order #' . $order['order_id'] . '</h3>';
            echo '<p><strong>Date:</strong> ' . $order['order_date'] . '</p>';
            echo '<p><strong>Customer:</strong> ' . htmlspecialchars($order['customer_name']) . '</p>';
            echo '<p><strong>Pickup Time:</strong> ' . htmlspecialchars($order['pickup_time']) . '</p>';
            
            // get items for this order
            $orderId = $order['order_id'];
            $itemSql = "SELECT * FROM order_items WHERE order_id = $orderId";
            $itemResult = $conn->query($itemSql);
            
            // list items
            echo '<h4>Items:</h4>';
            echo '<ul>';
            while($item = $itemResult->fetch_assoc()) {
                echo '<li>' . htmlspecialchars($item['menu_item_name']) . ' (x' . $item['quantity'] . ') - $' . number_format($item['item_total'], 2) . '</li>';
            }
            echo '</ul>';
            
            if (!empty($order['special_instructions'])) {
                echo '<p><strong>Special Instructions:</strong> ' . htmlspecialchars($order['special_instructions']) . '</p>';
            }
            
            echo '<p><strong>Total:</strong> $' . number_format($order['total'], 2) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No orders yet.</p>';
    }
    
    $conn->close();
    ?>
</div>

</body>
</html>