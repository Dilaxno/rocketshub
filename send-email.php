<?php
// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Get the posted data
$postData = json_decode(file_get_contents("php://input"), true);

if (isset($postData)) {
    // Extract form data
    $amount = isset($postData['amount']) ? $postData['amount'] : 'Not specified';
    $email = isset($postData['email']) ? $postData['email'] : 'Not provided';
    $industry = isset($postData['industry']) ? $postData['industry'] : 'Not specified';
    $message = isset($postData['message']) ? $postData['message'] : 'No message provided';
    
    // Set recipient email
    $to = "mail.esstafasoufiane@gmail.com";
    
    // Set email subject
    $subject = "New Bid for Rocketshub.com: $" . $amount;
    
    // Create email content
    $email_content = "
    <html>
    <head>
        <title>New Bid for Rocketshub.com</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            h2 { color: #000; }
            .bid-info { background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
            .bid-amount { font-size: 24px; font-weight: bold; color: #000; }
            .footer { font-size: 12px; color: #777; margin-top: 30px; border-top: 1px solid #eee; padding-top: 10px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>New Bid Received for Rocketshub.com</h2>
            <div class='bid-info'>
                <p><strong>Bid Amount:</strong> <span class='bid-amount'>$" . $amount . "</span></p>
                <p><strong>Bidder Email:</strong> " . $email . "</p>
                <p><strong>Industry:</strong> " . $industry . "</p>
                <p><strong>Message:</strong> " . $message . "</p>
            </div>
            <div class='footer'>
                <p>This email was sent from the Rocketshub.com domain sale page.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Set email headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Rocketshub Domain Bid <noreply@rocketshub.com>" . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    
    // Log the email attempt
    error_log("Attempting to send email to: " . $to);
    
    // Send email
    $mail_sent = mail($to, $subject, $email_content, $headers);
    
    // Log the result
    if ($mail_sent) {
        error_log("Email sent successfully");
        echo json_encode(["success" => true, "message" => "Email sent successfully"]);
    } else {
        error_log("Failed to send email: " . error_get_last()['message']);
        echo json_encode(["success" => false, "message" => "Failed to send email"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No data received"]);
}
?>