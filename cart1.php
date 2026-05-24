<?php include 'dbconnect.php'; ?>
<?php
// Retrieve cart items from cookies
$cart_items = isset($_COOKIE['cart_items']) ? json_decode($_COOKIE['cart_items'], true) : [];
$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart / Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #212529;
        }
        .cart-container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .cart-item img {
            width: 100px;
            height: auto;
        }
        .cart-item-info {
            flex: 1;
            padding-left: 20px;
        }
        .cart-item-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .spinner {
            width: 50px;
            height: 30px;
            text-align: center;
            font-size: 16px;
        }
        .cart-summary {
            text-align: center;
            margin-top: 20px;
        }
        .cart-summary button {
            background-color: #212529;
        }
        .cart-summary button:hover {
            background-color: #c9302c;
        }
        button {
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            background-color: red;
            color: white;
            border-radius: 4px;
        }
        button:hover {
            background-color: #4cae4c;
        }
        footer {
            text-align: center;
            color: white;
            margin-top: 90px;
        }
    </style>
</head>
<body>

<div class="cart-container">
    <h1>Your Cart 
        <img src="assets/cart-icon.png" alt="Cart Icon" width="40" height="45">
    </h1>

    <div id="cartItems">
        <?php
        if (!empty($cart_items)) {
            // Fetch the details of cart items from the database
            $product_ids = array_column($cart_items, 'id');
            $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
            
            // Prepare the DB connection
            $db_host = 'localhost:3307';
            $db_name = 'booknest';
            $db_user = 'root';
            $db_pass = '';
            try {
                $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Query to fetch product details
                $stmt = $db->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
                $stmt->execute($product_ids);
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($products as $product) {
                    $item = current(array_filter($cart_items, function ($cart_item) use ($product) {
                        return $cart_item['id'] == $product['id'];
                    }));
                    $quantity = $item['quantity'];
                    $total_price += $product['price'] * $quantity;
                    echo '
                        <div class="cart-item">
                            <div class="cart-item-info">
                                <img src="assets/' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '">
                                <p><strong>' . htmlspecialchars($product['name']) . '</strong></p>
                                <p>Price: $' . number_format($product['price'], 2) . '</p>
                            </div>
                            <div class="cart-item-buttons">
                                <input type="number" class="spinner" value="' . $quantity . '" min="1" max="99" id="quantity_' . $product['id'] . '">
                                <button onclick="removeProduct(' . $product['id'] . ')">Remove</button>
                            </div>
                        </div>
                    ';
                }
            } catch (PDOException $e) {
                echo 'Error fetching products: ' . $e->getMessage();
            }
        } else {
            echo '<p>Your cart is empty.</p>';
        }
        ?>
    </div>

    <div class="cart-summary">
        <p><strong>Total Price: $<?php echo number_format($total_price, 2); ?></strong></p>
        <button onclick="checkout()">Buy</button>
        <button onclick="updateCart()">Update</button>
        <button onclick="emptyCart()">Empty</button>
    </div>
    <button onclick="window.location.href='home.php'">Previous Page</button>
</div>

<script>
// Function to remove a product from the cart
function removeProduct(productId) {
    let cookieValue = getCookie('cart_items');
    if (!cookieValue) return;

    try {
        let cartItems = JSON.parse(decodeURIComponent(cookieValue));
        let updatedItems = [];

        for (let item of cartItems) {
            if (parseInt(item.id) === parseInt(productId)) {
                if (item.quantity > 1) {
                    item.quantity -= 1;
                    updatedItems.push(item);
                }
                // If quantity == 1, don't push -> product gets removed
            } else {
                updatedItems.push(item);
            }
        }

        document.cookie = `cart_items=${encodeURIComponent(JSON.stringify(updatedItems))}; path=/; max-age=${60*60*24*30}; SameSite=Lax`;
        location.reload();
    } catch (e) {
        console.error("Error updating cart:", e);
    }
}


// Function to empty the cart
function emptyCart() {
    document.cookie = "cart_items=[]; path=/; max-age=0; SameSite=Lax";
    location.reload();
}

// Function to update the cart after editing quantities
function updateCart() {
    let cartItems = JSON.parse(decodeURIComponent(getCookie('cart_items') || '[]'));
    let updatedItems = cartItems.map(item => {
        let quantity = document.getElementById('quantity_' + item.id).value;
        item.quantity = parseInt(quantity, 10);
        return item;
    });
    document.cookie = `cart_items=${encodeURIComponent(JSON.stringify(updatedItems))}; path=/; max-age=${60*60*24*30}; SameSite=Lax`;
    alert("Cart updated successfully!");
    setTimeout(function() {
        location.reload();
    }, 1500);
}

// Function to get cookie value
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) {
        return parts.pop().split(';').shift();
    }
    return '';
}


// Function to simulate checkout and show the Thank You message
function checkout() {
    document.cookie = "cart_items=[]; path=/; max-age=0; SameSite=Lax";
    document.body.innerHTML = ` 
        <div style="display: flex; height: 100vh; justify-content: center; align-items: center; text-align: center;">
            <div>
                <h1 style="color: #28a745;">Thank You for Your Purchase!</h1>
                <p>Your order has been successfully placed.</p>
            </div>
        </div>
    `;
}
</script>

</body>
<footer>
    <div><p>Copyright &copy; BookNest 2025</p></div>
</footer>
</html>
