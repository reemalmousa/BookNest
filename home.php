<?php
// Database connection
$db_host = 'localhost:3307';
$db_name = 'booknest';
$db_user = 'root';
$db_pass = '';

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get products from database
$products = [];
try {
    $stmt = $db->query("SELECT * FROM products WHERE stock > 0");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log("Error fetching products: " . $e->getMessage());
}

// Handle past purchases with cookies
$past_purchases = [];
if (isset($_COOKIE['past_purchases'])) {
    $past_purchase_ids = json_decode($_COOKIE['past_purchases'], true);
    if (is_array($past_purchase_ids) && count($past_purchase_ids) > 0) {
        $placeholders = implode(',', array_fill(0, count($past_purchase_ids), '?'));
        try {
            $stmt = $db->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
            $stmt->execute($past_purchase_ids);
            $past_purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error fetching past purchases: " . $e->getMessage());
        }
    }
}

// Get cart count from cookie
$cart_count = 0;
if (isset($_COOKIE['cart_items'])) {
    $cart_items = json_decode($_COOKIE['cart_items'], true);
    if (is_array($cart_items)) {
        $cart_count = array_reduce($cart_items, function($sum, $item) {
            return $sum + $item['quantity'];
        }, 0);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Shop Homepage - BookNest</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        .added-to-cart {
            background-color: #28a745 !important;
            color: white !important;
        }
        .quantity-input {
            width: 60px;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="#!">Start BookNest</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="contactus.php">Contact Us</a></li>
            </ul>
            <a href="Loginpage.php">
                <img class="spaceforadmin" src="assets/admin-icon.png" alt="Admin Login" width="50" height="50">
            </a>
            <form class="d-flex">
                <a href="cart1.php">
                    <button class="btn btn-outline-dark" type="button">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill" id="cart-count"><?= $cart_count ?></span>
                    </button>
                </a>
            </form>
        </div>
    </div>
</nav>

<!-- Header -->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5 text-center text-white">
        <img src="assets/open-book.png" alt="Book Nest Logo" width="150" height="150">
        <h1 class="display-4 fw-bolder">Welcome to BookNest</h1>
        <p class="lead fw-normal text-white-50 mb-0">Whether you're a bookworm or a casual reader, BookNest is your perfect escape.</p>
        <p class="lead fw-normal text-white-50 mb-0">Explore curated collections, enjoy seamless browsing, and get lost in the magic of reading.</p>
    </div>
</header>

<!-- Products Section -->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php foreach ($products as $product): ?>
            <div class="col mb-5">
                <div class="card h-100">
                    <a href="productdetail.php?id=<?= $product['id'] ?>" target="_blank">
                        <img class="card-img-top" src="assets/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
                    </a>
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bolder"><?= htmlspecialchars($product['name']) ?></h5>
                        $<?= number_format($product['price'], 2) ?>
                    </div>
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">
                            <input type="number" class="quantity-input" value="1" min="1" />
                            <button class="btn btn-outline-dark mt-auto add-to-cart-btn" type="button" data-id="<?= $product['id'] ?>">Add to cart</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Past Purchases -->
<?php if (!empty($past_purchases)): ?>
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Past Purchases</h2>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php foreach ($past_purchases as $purchase): ?>
            <div class="col mb-5">
                <div class="card h-100">
                    <img class="card-img-top" src="assets/<?= htmlspecialchars($purchase['image']) ?>" alt="<?= htmlspecialchars($purchase['name']) ?>" />
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bolder"><?= htmlspecialchars($purchase['name']) ?></h5>
                        $<?= number_format($purchase['price'], 2) ?>
                    </div>
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">
                            <button class="btn btn-outline-dark mt-auto add-to-cart-btn" type="button" data-id="<?= $purchase['id'] ?>">Add to cart</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container text-center text-white">
        <p class="m-0">&copy; BookNest 2025</p>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
    const cartCountElement = document.getElementById('cart-count');

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return '';
    }

    function safeParseCookie(name) {
        try {
            return JSON.parse(getCookie(name) || '[]');
        } catch {
            return [];
        }
    }

    function updateCartCount(count) {
        cartCountElement.textContent = count;
    }

    function initializeCartCount() {
        const cartItems = safeParseCookie('cart_items');
        const totalCount = cartItems.reduce((sum, item) => sum + (item.quantity || 0), 0);
        updateCartCount(totalCount);
    }

    addToCartBtns.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            const quantityInput = this.closest('.text-center').querySelector('.quantity-input');
            let quantity = parseInt(quantityInput.value) || 1;

            if (quantity <= 0) {
                quantity = 1;
                quantityInput.value = 1;
            }

            let cartItems = safeParseCookie('cart_items');
            let itemExists = false;

            cartItems = cartItems.map(item => {
                if (item.id == productId) {
                    item.quantity += quantity;
                    itemExists = true;
                }
                return item;
            });

            if (!itemExists) {
                cartItems.push({ id: productId, quantity: quantity, added_at: new Date().toISOString() });
            }

            document.cookie = `cart_items=${JSON.stringify(cartItems)}; path=/; max-age=${60*60*24*30}; SameSite=Lax`;
            const totalCount = cartItems.reduce((sum, item) => sum + item.quantity, 0);
            updateCartCount(totalCount);

            const btn = this;
            btn.textContent = 'Added!';
            btn.classList.add('added-to-cart');
            btn.classList.remove('btn-outline-dark');

            setTimeout(() => {
                btn.textContent = 'Add to cart';
                btn.classList.remove('added-to-cart');
                btn.classList.add('btn-outline-dark');
            }, 1000);
        });
    });

    initializeCartCount();
});
</script>
</body>
</html>
