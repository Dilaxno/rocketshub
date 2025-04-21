<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $bidAmount = isset($_POST['bidAmount']) ? $_POST['bidAmount'] : 'Not specified';
    $email = isset($_POST['email']) ? $_POST['email'] : 'Not provided';
    $industry = isset($_POST['industry']) ? $_POST['industry'] : 'Not specified';
    $message = isset($_POST['message']) ? $_POST['message'] : 'No message provided';
    
    // Set recipient email
    $to = "mail.esstafasoufiane@gmail.com";
    
    // Set email subject
    $subject = "New Bid for Rocketshub.com: $" . $bidAmount;
    
    // Create email content
    $email_content = "
    <html>
    <head>
        <title>New Bid for Rocketshub.com</title>
    </head>
    <body>
        <h2>New Bid Received for Rocketshub.com</h2>
        <p><strong>Bid Amount:</strong> $" . $bidAmount . "</p>
        <p><strong>Bidder Email:</strong> " . $email . "</p>
        <p><strong>Industry:</strong> " . $industry . "</p>
        <p><strong>Message:</strong> " . $message . "</p>
        <hr>
        <p>This email was sent from the Rocketshub.com domain sale page.</p>
    </body>
    </html>
    ";
    
    // Set email headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Rocketshub Domain Bid <noreply@rocketshub.com>" . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    
    // Send email
    $mail_sent = mail($to, $subject, $email_content, $headers);
    
    // Redirect back to the form page with success message
    if ($mail_sent) {
        header("Location: index.html?bid_submitted=true");
    } else {
        header("Location: index.html?bid_submitted=false");
    }
    exit;
}
?>