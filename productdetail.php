
<?php include 'dbconnect.php'; ?>

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch product
$product = [];
try {
    $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        header("Location: home.php");
        exit();
    }
} catch(PDOException $e) {
    error_log("Error fetching product: " . $e->getMessage());
    header("Location: home.php");
    exit();
}

$cart_count = isset($_COOKIE['cart_count']) ? (int)$_COOKIE['cart_count'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="<?= htmlspecialchars($product['name']) ?>" />
    <title><?= htmlspecialchars($product['name']) ?> - BookNest</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="home.php">BookNest</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="contactus.php">Contact Us</a></li>
            </ul>
            <a href="Loginpage.php">
                <img src="assets/admin-icon.png" alt="Admin Login" width="50" height="50">
            </a>
            <form class="d-flex">
                <a href="cart1.php" class="btn btn-outline-dark">
                    <i class="bi-cart-fill me-1"></i> Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill"><?= $cart_count ?></span>
                </a>
            </form>
        </div>
    </div>
</nav>

<!-- Product Detail -->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                <img class="card-img-top mb-5 mb-md-0" src="assets/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
            </div>
            <div class="col-md-6">
                <h1 class="display-5 fw-bolder"><?= htmlspecialchars($product['name']) ?></h1>
                <div class="fs-5 mb-5">
                    <span>$<?= number_format($product['price'], 2) ?></span>
                </div>
                <p class="lead"><?= htmlspecialchars($product['description']) ?></p>
                <div class="d-flex">
                    <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1" min="1" max="<?= $product['stock'] ?>" style="max-width: 3rem" />
                    <button class="btn btn-outline-dark flex-shrink-0 me-2" id="addToCartBtn" type="button" data-id="<?= $product['id'] ?>">
                        <i class="bi-cart-fill me-1"></i> Add to cart
                    </button>
                    <button class="btn btn-outline-dark flex-shrink-0" id="checkoutBtn" type="button" data-id="<?= $product['id'] ?>">
                        Checkout
                    </button>
                </div>
                <div class="mt-3">
                    <a href="help.php" class="help-link" title="Get assistance">Help?</a>
                </div>
                <?php if ($product['stock'] > 0): ?>
                    <div class="text-success mt-2">In Stock (<?= $product['stock'] ?> available)</div>
                <?php else: ?>
                    <div class="text-danger mt-2">Out of Stock</div>
                <?php endif; ?>
                <a href="home.php" class="btn btn-outline-secondary mt-4">
                    <i class="bi bi-arrow-left"></i> Back to Home
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; BookNest 2025</p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>

<!-- Cart Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addToCartBtn = document.getElementById('addToCartBtn');
    const checkoutBtn = document.getElementById('checkoutBtn');

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    function updateCart(productId, quantity) {
        let cartItems = JSON.parse(getCookie('cart_items') || '[]');
        let found = false;

        cartItems = cartItems.map(item => {
            if (item.id == productId) {
                found = true;
                item.quantity += quantity;
            }
            return item;
        });

        if (!found) {
            cartItems.push({id: productId, quantity: quantity});
        }

        document.cookie = `cart_items=${JSON.stringify(cartItems)}; path=/`;
        const totalCount = cartItems.reduce((sum, item) => sum + item.quantity, 0);
        document.cookie = `cart_count=${totalCount}; path=/`;
        document.querySelector('.badge').textContent = totalCount;
    }

    addToCartBtn.addEventListener('click', function() {
        const productId = this.getAttribute('data-id');
        const quantity = parseInt(document.getElementById('inputQuantity').value);
        if (isNaN(quantity) || quantity < 1) {
            alert('Please enter a valid quantity');
            return;
        }

        updateCart(productId, quantity);
        alert('Added to cart!');
    });

    checkoutBtn.addEventListener('click', function() {
        const productId = this.getAttribute('data-id');
        const quantity = parseInt(document.getElementById('inputQuantity').value);
        if (isNaN(quantity) || quantity < 1) {
            alert('Please enter a valid quantity');
            return;
        }

        updateCart(productId, quantity);
        window.location.href = 'cart1.php';
    });
});
</script>
</body>
</html>
