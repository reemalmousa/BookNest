<!-- Group name: Group 4 -->
<!-- Names: Khawla Alhije, Reem Almousa, Khadijah khashogji , Maria Almalki , Nahida Al Ghareeb Ghadeer Alhassan -->
<!-- Student IDs: 2220006662, 2220002025, 2220003447, 2220040018, 2210003109, 2210002963 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNest Admin</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #212529; /* Dark background as requested */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            color: white; /* White text for contrast */
        }
        
        .content {
            text-align: center;
            margin: 40px 0;
            width: 100%;
            max-width: 400px;
        }
        
        h1 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            color: white; /* White heading */
        }
        
        .menu {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 50px;
        }
        
        .menu-item {
            padding: 15px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            font-size: 1.5rem;
			font-weight: bold;
            text-decoration: none;
            color: #212529; /* Dark text on white buttons */
            transition: all 0.2s ease;
        }
        
        .menu-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        footer {
            margin-top: auto;
            padding: 20px;
            color: rgba(255,255,255,0.7); /* Semi-transparent white */
            font-size: 0.9rem;
            width: 100%;
            text-align: center;
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
	.logo{
	margin-top: 40px; 
	
	}
    </style>
</head>
<body>
	<button class="logout-btn" onclick="window.location.href='Loginpage.html'">Log Out</button>
			<img src="assets/open-book.png" alt="Book Nest Logo" width="150" height="150" class="logo">
<h1>BookNest Managment System</h1>   
   <div class="content">
        
        
        <div class="menu">
            <a href="addproduct.html" class="menu-item">Add Product</a>
            <a href="modify_delete.html" class="menu-item">Modify Product</a>
            <a href="modify_delete.html" class="menu-item">Delete Product</a>
        </div>
    </div>
    
    <footer>
        Copyright &copy; BookNest 2025
    </footer>
</body>
</html>