<?php
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get form data
$naam = isset($_POST['naam']) ? trim($_POST['naam']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$telefoon = isset($_POST['telefoon']) ? trim($_POST['telefoon']) : '';
$onderwerp = isset($_POST['onderwerp']) ? trim($_POST['onderwerp']) : '';
$bericht = isset($_POST['bericht']) ? trim($_POST['bericht']) : '';

// Validate required fields
$errors = [];
if (empty($naam)) {
    $errors[] = 'Naam is verplicht';
}
if (empty($email)) {
    $errors[] = 'E-mail is verplicht';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Ongeldig e-mailadres';
}
if (empty($onderwerp)) {
    $errors[] = 'Onderwerp is verplicht';
}
if (empty($bericht)) {
    $errors[] = 'Bericht is verplicht';
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit;
}

// Prepare email
$to = 'info@buroworst.nl';
$subject = 'Nieuw bericht van: ' . $naam . ' - ' . $onderwerp;

$message = "Naam: $naam\n";
$message .= "E-mail: $email\n";
if (!empty($telefoon)) {
    $message .= "Telefoon: $telefoon\n";
}
$message .= "Onderwerp: $onderwerp\n\n";
$message .= "Bericht:\n$bericht\n";

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send email
$mailSent = mail($to, $subject, $message, $headers);

if ($mailSent) {
    echo json_encode(['success' => true, 'message' => 'Bedankt voor je bericht! We nemen zo snel mogelijk contact met je op.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Er is een fout opgetreden bij het verzenden van je bericht. Probeer het later nog eens.']);
}
