<?php
require_once __DIR__ . '/db.php';
if (isConfigured()) { header('Location: index.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? ''); $email = trim($_POST['email'] ?? ''); $password = $_POST['password'] ?? '';
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) $error = 'Enter your name, a valid email, and a password of at least 8 characters.';
    else {
        $db = database();
        $db->prepare('INSERT INTO admins (name,email,password_hash,created_at) VALUES (?,?,?,?)')->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), date(DATE_ATOM)]);
        $db->prepare("INSERT INTO settings (key,value) VALUES ('configured','1')")->execute();
        $_SESSION['admin_id'] = $db->lastInsertId(); $_SESSION['admin_name'] = $name;
        header('Location: admin.php'); exit;
    }
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Set up KGN website</title><link rel="stylesheet" href="assets/style.css"></head><body class="center-page"><main class="auth-card"><span class="eyebrow">ONE-TIME SETUP</span><h1>Set up your admin account.</h1><p>This creates the secure account used to view student registrations.</p><?php if ($error): ?><div class="alert error"><?=esc($error)?></div><?php endif; ?><form method="post"><label>Name<input name="name" required></label><label>Email<input type="email" name="email" required></label><label>Password<input type="password" name="password" minlength="8" required></label><button>Create admin account</button></form></main></body></html>
