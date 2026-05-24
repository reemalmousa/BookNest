<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNest - Help Center</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #212529;
            color: #f8f9fa;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background-color: #1a1e21;
            padding: 20px 0;
            border-bottom: 2px solid #495057;
        }
        
        h1 {
            color: #4dabf7;
            text-align: center;
            margin-bottom: 30px;
        }
        
        h2 {
            color: #74c0fc;
            margin-top: 30px;
            border-bottom: 1px solid #495057;
            padding-bottom: 10px;
        }
        
        .faq-section {
            background-color: #2c3034;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .question {
            font-weight: bold;
            color: #adb5bd;
            margin-bottom: 5px;
        }
        
        .answer {
            margin-bottom: 15px;
            color: #dee2e6;
        }
        
        .contact-info {
            background-color: #2c3034;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }
        
        a {
            color: #4dabf7;
            text-decoration: none;
        }
        
        a:hover {
            text-decoration: underline;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 8px 15px;
            background-color: #495057;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>BookNest Help Center</h1>
        </div>
    </header>
    
    <div class="container">
        <section class="faq-section">
            <h2>Frequently Asked Questions</h2>
            
            <div class="question">How do I create an account?</div>
            <div class="answer">
                Click on the "Sign Up" button in the top right corner of the page. 
                Fill in your details including email, username, and password. 
                You'll receive a confirmation email to verify your account.
            </div>
            
            <div class="question">How do I search for books?</div>
            <div class="answer">
                Use the search bar at the top of any page. You can search by title, 
                author, ISBN, or keywords. Use our advanced search filters to narrow 
                down results by genre, publication date, or rating.
            </div>
            
            <div class="question">Can I save books to read later?</div>
            <div class="answer">
                Yes! When you're logged in, click the "Add to Shelf" button on any 
                book page. You can organize your saved books into custom shelves 
                like "Want to Read", "Currently Reading", and "Finished".
            </div>
            
            <div class="question">How do I leave a review?</div>
            <div class="answer">
                Navigate to the book's page and scroll down to the reviews section. 
                Click "Write a Review" and rate the book (1-5 stars). Your review 
                will appear once submitted.
            </div>
            
            <div class="question">Is BookNest free to use?</div>
            <div class="answer">
                Yes, BookNest is completely free for all users. We may offer premium 
                features in the future, but the core functionality will always remain free.
            </div>
        </section>
        
        <section class="contact-info">
            <h2>Need More Help?</h2>
            <p>If you didn't find the answer to your question, please contact our support team:</p>
            <ul>
                <li>Email: <a href="mailto:support@booknest.example">support@booknest.example</a></li>
                <li>Twitter: <a href="https://twitter.com/BookNestHelp" target="_blank">@BookNestHelp</a></li>
                <li>Phone: (555) 123-4567 (9am-5pm EST)</li>
            </ul>
        </section>
        
        <a href="home.php" class="back-link">← Back to BookNest</a>
    </div>
</body>
</html>