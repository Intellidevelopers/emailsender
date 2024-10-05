<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email Form</title>
</head>
<body>
    <h1>Send Custom Message</h1>
    <form action="send_mail.php" method="POST">
        <label for="from_name">Your Name (From Name):</label><br>
        <input type="text" id="from_name" name="from_name" required><br><br>
        
        <label for="from_email">Your Email (From Email):</label><br>
        <input type="email" id="from_email" name="from_email" required><br><br>
        
        <label for="recipient_name">Recipient Name:</label><br>
        <input type="text" id="recipient_name" name="recipient_name" required><br><br>
        
        <label for="recipient_email">Recipient Email:</label><br>
        <input type="email" id="recipient_email" name="recipient_email" required><br><br>
        
        <label for="subject">Email Subject:</label><br>
        <input type="text" id="subject" name="subject" required><br><br>

        <button type="submit">Send Email</button>
    </form>
</body>
</html>
