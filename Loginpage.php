<!-- Group name: Group 4 -->
<!-- Names: Khawla Alhije, Reem Almousa, Khadijah khashogji , Maria Almalki , Nahida Al Ghareeb Ghadeer Alhassan -->
<!-- Student IDs: 2220006662, 2220002025, 2220003447, 2220040018, 2210003109, 2210002963 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #212529;
            position: relative;
        }
        
        .logo-container {
            margin-bottom: 10px;
			margin-top: 30px;  
            text-align: center;
        }
        
        .logo {
            width: 150px;
            height: 150px;
        }
    
        .login-container {
          background-color: #343a40;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            margin: 20px 0;
        }
        
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            
            border-radius: 5px;
        }
        
        .login-container button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background-color: #212529;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input{
     
      border: 1px solid #495057;
      background-color: #495057;
      color: white;
    }
        .login-container button:hover {
            background-color: #343a40;
        }
        h2 {
		color: white;
		}
		label {
		color: white;}
		
        .home-button {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px;
            background-color: white;
            color: #212529;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        
        footer {
            text-align: center;
            color: white;
            margin-top: auto;
            padding: 20px;
            width: 100%;
        }
    </style>
</head>
<body>
    <button class="home-button" onclick="window.location.href='index.html'">Home</button>
    
    <div class="logo-container">
        <img src="assets/open-book.png" alt="BookNest Logo" class="logo">
    </div>
    
    <div class="login-container">
        <h2>Login</h2>
        <form action="manage.html" method="post">
            <label for="userID">Admin ID:</label>
            <input type="text" id="userID" name="userID" required>
            <br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <button type="submit">Login</button>
        </form>
    </div>

    <footer>
        <p>Copyright &copy; BookNest 2025</p>
    </footer>
</body>
</html>