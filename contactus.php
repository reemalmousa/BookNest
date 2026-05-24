<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    $to = "booknest@gmail.com";
    $body = "Hello,\n\nMy Name: $name\nMy Email: $email\n\n$message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        $success = "Message sent successfully!";
    } else {
        $error = "Failed to send message. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #212529; margin: 0; padding: 0; }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; display: block; margin-bottom: 5px; }
        input, textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        textarea { height: 120px; resize: vertical; }
        button {
            background-color: #212529;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
        }
        button:hover { background-color: #218838; }
        .contact-info { text-align: center; margin-top: 20px; }
        .map-container { margin-top: 20px; text-align: center; }
        iframe {
            width: 100%;
            height: 300px;
            border: 0;
            border-radius: 8px;
        }
        footer { text-align: center; color: white; margin-top: 20px; }
        .navigation-buttons { text-align: center; margin-top: 30px; }
        .message { text-align: center; margin: 10px 0; font-weight: bold; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
<div class="container">
    <h2>Contact Us</h2>

    <?php if (!empty($success)): ?>
        <div class="message success"><?= $success ?></div>
    <?php elseif (!empty($error)): ?>
        <div class="message error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" placeholder="Enter subject" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" placeholder="Enter your message" required></textarea>
        </div>
        <button type="submit">Send Message</button>
    </form>

    <div class="navigation-buttons">
        <button onclick="window.location.href='index.php'">Previous Page</button>
    </div>

    <div class="contact-info">
        <h3>Our Address</h3>
        <iframe src="https://www.google.com/maps/embed?pb=..." loading="lazy"></iframe>
        <p><strong>Phone:</strong> 055-123-4567</p>
        <p><strong>Email:</strong> Booknest@gmail.com</p>
    </div>
</div>

<footer>
    <p>&copy; BookNest 2025</p>
</footer>
</body>
</html>
