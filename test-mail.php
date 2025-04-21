<?php
// This is a test script to check if the mail function is working
// Access this file directly in your browser to test email functionality

// Only allow access in development or with a special parameter
if (!isset($_GET['test']) && getenv('RAILWAY_ENVIRONMENT') === 'production') {
    header('HTTP/1.1 403 Forbidden');
    echo 'Access denied in production. Add ?test=1 to the URL to run this test.';
    exit;
}

// Set recipient email
$to = "mail.esstafasoufiane@gmail.com";

// Set email subject
$subject = "Test Email from RocketsHub Domain Sale Page";

// Create email content
$message = "
<html>
<head>
    <title>Test Email</title>
</head>
<body>
    <h2>Test Email</h2>
    <p>This is a test email from your RocketsHub Domain Sale Page.</p>
    <p>If you're receiving this, the PHP mail function is working correctly.</p>
    <p>Server information:</p>
    <ul>
        <li>PHP Version: " . phpversion() . "</li>
        <li>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</li>
        <li>Time: " . date('Y-m-d H:i:s') . "</li>
    </ul>
</body>
</html>
";

// Set email headers
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: RocketsHub Test <test@rocketshub.com>" . "\r\n";

// Send email
$mail_sent = mail($to, $subject, $message, $headers);

// Output result
header('Content-Type: application/json');
if ($mail_sent) {
    echo json_encode([
        'success' => true,
        'message' => 'Test email sent successfully to ' . $to,
        'php_mail_enabled' => true
    ]);
} else {
    $error = error_get_last();
    echo json_encode([
        'success' => false,
        'message' => 'Failed to send test email',
        'error' => $error ? $error['message'] : 'Unknown error',
        'php_mail_enabled' => function_exists('mail')
    ]);
}
?>