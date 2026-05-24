<!-- Group name: Group 4 -->
<!-- Names: Khawla Alhije, Reem Almousa, Khadijah khashogji , Maria Almalki , Nahida Al Ghareeb Ghadeer Alhassan -->
<!-- Student IDs: 2220006662, 2220002025, 2220003447, 2220040018, 2210003109, 2210002963 -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Modify / Delete Product - BookNest</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      background-color: #212529;
      color: white;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      color: white;
    }

    .form-container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #343a40;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
      color: white;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #495057;
      background-color: #495057;
      color: white;
    }

    textarea {
      min-height: 80px;
      resize: vertical;
    }

    .button-group {
      margin-top: 25px;
      text-align: center;
    }

    .button-group button {
      padding: 12px 24px;
      margin: 0 10px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      color: white;
      cursor: pointer;
      font-weight: bold;
      transition: all 0.3s ease;
    }

    .update-btn {
      background-color: #28a745;
    }

    .delete-btn {
      background-color: #dc3545;
    }

    .load-btn {
      background-color: white;
      color: #212529;
      margin-top: 10px;
      border-radius: 5px;
    }

    .message {
      margin-top: 20px;
      text-align: center;
      color: #28a745;
      font-weight: bold;
    }

    .navigation-buttons {
      text-align: center;
      margin-top: 30px;
    }

    .navigation-buttons button {
      padding: 10px 20px;
      background-color: white;
      color: #212529;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      transition: all 0.3s ease;
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      opacity: 0.9;
    }
	 .logout-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 8px 16px;
        background-color: #8B0000; /* Dark red */
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .logout-btn:hover {
        background-color: #A52A2A; /* Slightly lighter red on hover */
        transform: translateY(-2px);
     box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>
<button class="logout-btn" onclick="window.location.href='Loginpage.html'">Log Out</button>
  <h1>Modify / Delete Product</h1>

  <div class="form-container">
    <label for="productId">Enter Product ID:</label>
    <input type="text" id="productId" placeholder="e.g., B001">
    <button class="load-btn" onclick="loadProduct()">Load Product</button>

    <form id="productForm" style="display: none;">
      <label for="name">Name:</label>
      <input type="text" id="name">

      <label for="stock">Stock (Number):</label>
      <input type="number" id="stock" min="0">

      <label for="price">Price:</label>
      <input type="number" id="price">

      <label for="description">Description:</label>
      <textarea id="description"></textarea>

      <label for="image">Image URL:</label>
      <input type="text" id="image">

      <div class="button-group">
        <button type="button" class="update-btn" onclick="updateProduct()">Update</button>
        <button type="button" class="delete-btn" onclick="deleteProduct()">Delete</button>
      </div>
    </form>

    <div class="message" id="messageBox"></div>
  </div>

  <div class="navigation-buttons">
    <button onclick="window.location.href='manage.html'">Previous</button>
  </div>

  <script>
    const mockDatabase = {
      B001: { 
        name: "The Great Gatsby", 
        stock: 42, 
        price: 10.99, 
        description: "A classic novel about the American Dream",
        image: "book1.jpg" 
      },
      B002: { 
        name: "1984", 
        stock: 35, 
        price: 8.50, 
        description: "Dystopian novel about totalitarianism",
        image: "book2.jpg" 
      },
    };

    function loadProduct() {
      const productId = document.getElementById("productId").value.trim();
      const product = mockDatabase[productId];

      if (product) {
        document.getElementById("name").value = product.name;
        document.getElementById("stock").value = product.stock;
        document.getElementById("price").value = product.price;
        document.getElementById("description").value = product.description;
        document.getElementById("image").value = product.image;

        document.getElementById("productForm").style.display = "block";
        document.getElementById("messageBox").textContent = "";
      } else {
        document.getElementById("productForm").style.display = "none";
        document.getElementById("messageBox").textContent = "Product not found.";
      }
    }

    function updateProduct() {
      const productId = document.getElementById("productId").value.trim();

      if (mockDatabase[productId]) {
        mockDatabase[productId] = {
          name: document.getElementById("name").value,
          stock: parseInt(document.getElementById("stock").value),
          price: parseFloat(document.getElementById("price").value),
          description: document.getElementById("description").value,
          image: document.getElementById("image").value
        };

        document.getElementById("messageBox").textContent = "Product updated successfully!";
      } else {
        document.getElementById("messageBox").textContent = "Error: Product not found.";
      }
    }

    function deleteProduct() {
      const productId = document.getElementById("productId").value.trim();

      if (mockDatabase[productId]) {
        delete mockDatabase[productId];
        document.getElementById("productForm").reset();
        document.getElementById("productForm").style.display = "none";
        document.getElementById("messageBox").textContent = "Product deleted successfully!";
      } else {
        document.getElementById("messageBox").textContent = "Error: Product not found.";
      }
    }
  </script>
</body>
</html>