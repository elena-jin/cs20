<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two Owls Café</title>
    <style>
    // css 
        body {
            font-family: Comic Sans MS, URW Palladio L, serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }
        .header {
            background-color: #A30018;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2.5em;
        }
        .header p {
            font-size: 1.2em;
        }
        .container {
            max-width: 1400px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
        }
        .menu-item {
            border: 0px solid #ddd;
            padding: 30px;
            margin: 15px 0;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .menu-item img {
            width: 200px;
            height: 200px;
            object-fit: cover;
        }
        .menu-item-info {
            flex: 1;
        }
        .menu-item h3 {
            margin: 0 0 10px 0;
            color: #1A0004;
        }
        .menu-item .price {
            font-size: 2.4em;
            color: #D1001F;
            font-weight: bold;
        }
        .quantity-select {
            padding: 5px;
            font-size: 1em;
        }
        .customer-info {
            margin-top: 30px;
            padding: 20px;
            background-color: #FFE6E9;
        }
        .customer-info input, .customer-info textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        .submit-btn {
            background-color: #A30018;
            color: white;
            padding: 15px 30px;
            border: none;
            font-size: 1.2em;
            cursor: pointer;
            margin-top: 20px;
        }
        .submit-btn:hover {
            background-color: #5a3a1e;
        }
        .order-summary {
            margin: 20px 0;
        }
        .order-item {
            background-color: #f9f9f9;
            padding: 15px;
            margin: 10px 0;
        }
        .total-section {
            background-color: #FFB6C1;
            padding: 20px;
            margin: 20px 0;
        }
        .total-section h3 {
            color: #750012;
        }
        .admin-link {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            background-color: rgba(255,255,255,0.2);
        }
        .admin-link:hover {
            background-color: rgba(255,255,255,0.3);
        }
    </style>
</head>




<body>
    <div class="header">
        <a href="show_orders.php" class="admin-link">Admin</a>
        <h1>Two Owls Café</h1>
        <p>Hours: 11am - 10pm</p>
    </div>