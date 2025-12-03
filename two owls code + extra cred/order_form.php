<?php
include 'header.php';

include 'db_connect.php';

$sql = "SELECT * FROM menu ORDER BY name";
$result = $conn->query($sql);
?>

<div class="container">
    <h2>Place Your Order</h2>
    
    <form id="orderForm" method="get" action="process_order.php" onsubmit="return validateForm()">
        
        <?php
        // deal with everything and the display the data
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="menu-item">';
                echo '<img src="/owls/images/' .  ($row['image']) . '" alt="' .  ($row['name']) . '">';
                echo '<div class="menu-item-info">';
                echo '<h3>' .  ($row['name']) . '</h3>';
                echo '<p>' .  ($row['description']) . '</p>';
                echo '<p class="price">$' . number_format($row['price'], 2) . '</p>';
                echo '</div>';
                echo '<div>';
                echo '<label>Quantity:</label><br>';
                echo '<select name="item_' . $row['id'] . '" class="quantity-select item-quantity">';
                for ($i = 0; $i <= 10; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }
                echo '</select>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No menu items available :((</p>';
        }
        
        $conn->close();
        ?>
        
        <div class="customer-info">
            <h3>Customer Info</h3>
            
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required>
            
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required>
            
            <label for="specialInstructions">Special Instructions:</label>

            <!-- text areaaaa req from spec -->
            <textarea id="specialInstructions" name="specialInstructions" rows="4" placeholder="Allergies or special requests?"></textarea>
            
            <!-- hidden field for pickup time (JavaScript) -->
            <input type="hidden" id="pickupTime" name="pickupTime" value="">
        </div>
        
        <button type="submit" class="submit-btn">Submit Order</button>
    </form>
</div>

<script>
function validateForm() {
    // makes sure 1 order is placed, basically this chunk validates form
    let quantities = document.querySelectorAll('.item-quantity');
    let hasOrder = false;
    
    for (let i = 0; i < quantities.length; i++) {
        if (parseInt(quantities[i].value) > 0) {
            hasOrder = true;
            break;
        }
    }
    
    if (!hasOrder) {
        alert('Please order at least one item!');
        return false;
    }
    
    let firstName = document.getElementById('firstName').value.trim();
    let lastName = document.getElementById('lastName').value.trim();
    
    if (firstName === '' || lastName === '') {
        alert('Please provide your first and last name!');
        return false;
    }
    
    // 20 min pick up time
    let now = new Date();
    now.setMinutes(now.getMinutes() + 20);
    
    // hour:minute AM/PM
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // Convert 0 to 12
    minutes = minutes < 10 ? '0' + minutes : minutes;
    
    let pickupTime = hours + ':' + minutes + ' ' + ampm;
    
    document.getElementById('pickupTime').value = pickupTime;
    
    return true;
}
</script>

</body>
</html>