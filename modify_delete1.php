<?php
// modify_delete.php

$conn = new mysqli("localhost:3307", "root", "", "booknest");
if ($conn->connect_error) {
    header("Content-Type: application/json");
    die(json_encode(["error" => "DB connection failed"]));
}

// JSON API: Fetch product
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    header("Content-Type: application/json");
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("s", $_GET['id']);
    $stmt->execute();
    echo json_encode($stmt->get_result()->fetch_assoc() ?: ["error" => "Product not found"]);
    exit;
}

// JSON API: Delete or update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header("Content-Type: application/json");

    // Delete if only ID passed
    if (isset($_POST['id']) && empty($_POST['name']) && empty($_FILES['imageFile']['name'] ?? '')) {
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("s", $_POST['id']);
        echo json_encode($stmt->execute() ? ["success" => true] : ["error" => "Failed to delete"]);
        exit;
    }

    // Update
    $id          = $_POST['id'];
    $name        = $_POST['name'];
    $stock       = $_POST['stock'];
    $price       = $_POST['price'];
    $description = $_POST['description'];

    // Handle optional image upload
    $imagePath = null;
    if (!empty($_FILES['imageFile']['name'])) {
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $ext     = pathinfo($_FILES['imageFile']['name'], PATHINFO_EXTENSION);
        $newName = uniqid('prod_', true) . '.' . $ext;
        $dest    = $uploadDir . $newName;

        if (move_uploaded_file($_FILES['imageFile']['tmp_name'], $dest)) {
            $imagePath = 'uploads/' . $newName;
        } else {
            echo json_encode(["error" => "Failed to upload image"]);
            exit;
        }
    }

    // Prepare SQL
    if ($imagePath) {
        $sql = "UPDATE products SET name=?, stock=?, price=?, description=?, image=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sidsss", $name, $stock, $price, $description, $imagePath, $id);
    } else {
        $sql = "UPDATE products SET name=?, stock=?, price=?, description=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sidss", $name, $stock, $price, $description, $id);
    }

    echo json_encode($stmt->execute() ? ["success" => true] : ["error" => "Failed to update"]);
    exit;
}

// Otherwise: serve the HTML page
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Modify / Delete Product - BookNest</title>
  <style>
    body { font-family: Arial; padding:40px; background:#212529; color:#fff; }
    .form-container { max-width:600px; margin:auto; background:#343a40; padding:30px; border-radius:10px; }
    label { display:block; margin-top:15px; font-weight:bold; }
    input, textarea { width:100%; padding:10px; margin-top:5px; border-radius:5px; border:1px solid #495057; background:#495057; color:#fff; }
    .button-group { margin-top:25px; text-align:center; }
    .update-btn { background:#28a745; padding:12px 24px; color:#fff; border:none; border-radius:5px; cursor:pointer; }
    .delete-btn { background:#dc3545; padding:12px 24px; color:#fff; border:none; border-radius:5px; cursor:pointer; }
    .load-btn   { background:#fff; color:#212529; padding:8px 16px; border-radius:5px; cursor:pointer; margin-top:10px; }
    .message    { margin-top:20px; text-align:center; font-weight:bold; }
    .message.success { color: #28a745; }  /* green */
    .message.error   { color: #dc3545; }  /* red */
  </style>
</head>
<body>
  <h1 style="text-align:center;">Modify Product</h1>
  <div class="form-container">
    <label for="productId">Enter Product ID:</label>
    <input type="text" id="productId" placeholder="e.g., 1">
    <button class="load-btn" onclick="loadProduct()">Load Product</button>

    <form id="productForm" style="display:none;" enctype="multipart/form-data">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name">
      <label for="stock">Stock:</label>
      <input type="number" id="stock" name="stock" min="0">
      <label for="price">Price:</label>
      <input type="number" id="price" name="price" step="0.01">
      <label for="description">Description:</label>
      <textarea id="description" name="description"></textarea>
      <label for="imageFile">Choose New Image:</label>
      <input type="file" id="imageFile" name="imageFile" accept="image/*">
      <div class="button-group">
        <button type="button" class="update-btn" onclick="updateProduct()">Update</button>
        <button type="button" class="delete-btn" onclick="deleteProduct()">Delete</button>
      </div>
    </form>

    <div id="messageBox" class="message"></div>
  </div>

  <script>
    const msgBox = document.getElementById("messageBox");

    function showMessage(text, isSuccess) {
      msgBox.textContent = text;
      msgBox.classList.toggle("success", isSuccess);
      msgBox.classList.toggle("error", !isSuccess);
    }

    function loadProduct() {
      const id = encodeURIComponent(document.getElementById("productId").value.trim());
      fetch(`modify_delete.php?id=${id}`)
        .then(r => r.json())
        .then(p => {
          const form = document.getElementById("productForm");
          if (p.error) {
            form.style.display = "none";
            showMessage(p.error, false);
          } else {
            document.getElementById("name").value        = p.name;
            document.getElementById("stock").value       = p.stock;
            document.getElementById("price").value       = p.price;
            document.getElementById("description").value = p.description;
            document.getElementById("imageFile").value   = "";
            form.style.display = "block";
            showMessage("", true);
          }
        });
    }

    function updateProduct() {
      const id = document.getElementById("productId").value.trim();
      const form = document.getElementById("productForm");
      const fd = new FormData(form);
      fd.set("id", id);

      fetch("modify_delete.php", { method: "POST", body: fd })
        .then(r => r.json())
        .then(res => showMessage(res.success ? "Product updated successfully!" : res.error, !!res.success));
    }

    function deleteProduct() {
      const id = document.getElementById("productId").value.trim();
      const fd = new FormData();
      fd.set("id", id);

      fetch("modify_delete.php", { method: "POST", body: fd })
        .then(r => r.json())
        .then(res => {
          if (res.success) {
            document.getElementById("productForm").reset();
            document.getElementById("productForm").style.display = "none";
            showMessage("Product deleted successfully!", true);
          } else {
            showMessage(res.error, false);
          }
        });
    }
  </script>
</body>
</html>
