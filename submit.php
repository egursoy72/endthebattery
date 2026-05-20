<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://www.endthebattery.com');

$to = 'erdalgursoy@gmail.com';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if (!$email) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid email address']);
    exit;
}

$subject = 'New Early Access Sign-up — EndTheBattery';
$body    = "New early access request:\n\nEmail: {$email}\nDate:  " . date('Y-m-d H:i:s T');
$headers = implode("\r\n", [
    'From: no-reply@endthebattery.com',
    'Reply-To: ' . $email,
    'X-Mailer: PHP/' . PHP_VERSION,
]);

if (mail($to, $subject, $body, $headers)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Mail delivery failed']);
}
