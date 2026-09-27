<?php
require_once __DIR__ . '/db.php';
if (!isConfigured()) { header('Location: setup.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }

$name = trim($_POST['full_name'] ?? '');
$phone = preg_replace('/\D/', '', $_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$course = trim($_POST['course'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || strlen($phone) !== 10 || $message === '' || ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL))) {
    $_SESSION['query_flash'] = 'Please enter a valid name, 10-digit mobile number, and message.';
} else {
    database()->prepare('INSERT INTO queries (full_name,phone,email,course,message,created_at) VALUES (?,?,?,?,?,?)')->execute([$name, $phone, $email ?: null, $course ?: null, $message, date(DATE_ATOM)]);
    $_SESSION['query_flash'] = 'Thank you. Your query has been submitted successfully.';
}
header('Location: index.php');
exit;
