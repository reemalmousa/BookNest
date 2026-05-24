<!-- Group name: Group 4 -->
<!-- Names: Khawla Alhije, Reem Almousa, Khadijah khashogji , Maria Almalki , Nahida Al Ghareeb -->
<!-- Student IDs: 2220006662, 2220002025, 2220003447, 2220040018, 2210003109 -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Product - BookNest</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      padding: 30px 15px;
      background-color: #212529;
      margin: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      color: white;
    }

    h2 {
      margin-bottom: 20px;
      text-align: center;
      color: white;
    }

    form {
      background-color: #343a40;
      padding: 20px;
      border-radius: 8px;
      max-width: 600px;
      width: 100%;
      box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    }

    label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
      color: white;
    }

    input, textarea, select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #495057;
      border-radius: 5px;
      background-color: #495057;
      color: white;
    }

    textarea {
      min-height: 80px;
      resize: vertical;
    }

    .button-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 25px;
      flex-wrap: wrap;
    }

    button {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      transition: all 0.3s ease;
    }

    .add-btn {
      background-color: #2196F3;
      color: white;
    }

    .cancel-btn {
      background-color: #6c757d;
      color: white;
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .nav {
      margin-top: 30px;
      text-align: center;
    }

    .nav a {
      margin-right: 15px;
      text-decoration: none;
      color: white;
      font-weight: bold;
      padding: 8px 16px;
      background-color: white;
      color: #212529;
      border-radius: 5px;
      transition: all 0.3s ease;
    }

    .nav a:hover {
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
  <h2>Add a New Product</h2>

  <form id="addForm">
    <label for="productId">Product ID</label>
    <input type="text" id="productId" name="productId" required />

    <label for="productName">Product Name</label>
    <input type="text" id="productName" name="productName" required />

    <label for="description">Description</label>
    <textarea id="description" name="description" rows="4"></textarea>

    <label for="price">Price</label>
    <input type="number" id="price" name="price" step="1.00" required />

    <label for="stock">Stock</label>
    <input type="number" id="stock" name="stock" min="0" required />

    <label for="imageUrl">Image URL</label>
    <input type="text" id="imageUrl" name="imageUrl" />

    <label for="availability">Availability</label>
    <select id="availability" name="availability">
      <option value="available">Available</option>
      <option value="out-of-stock">Out of Stock</option>
    </select>

    <div class="button-row">
      <button type="submit" class="add-btn">Add Product</button>
      <button type="button" class="cancel-btn" onclick="cancelForm()">Cancel</button>
    </div>
  </form>

  <div class="nav">
    <a href="manage.html">Previous</a>
 
  </div>

  <script>
    document.getElementById('addForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const name = document.getElementById('productName').value;
      alert('Product "' + name + '" added successfully!');

      // Reset the form
      this.reset();
    });

    function cancelForm() {
      if (confirm('Cancel and clear all fields?')) {
        document.getElementById('addForm').reset();
      }
    }
  </script>

</body>
</html>
