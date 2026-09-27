<?php
require_once __DIR__ . '/db.php';
if (!isConfigured()) { header('Location: setup.php'); exit; }
$error = ''; $student = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registration = strtoupper(trim($_POST['registration_number'] ?? ''));
    $password = $_POST['password'] ?? '';
    $stmt = database()->prepare('SELECT * FROM students WHERE registration_number = ?');
    $stmt->execute([$registration]); $candidate = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($candidate && password_verify($password, $candidate['password_hash'])) $student = $candidate;
    else $error = 'Registration number or password is incorrect.';
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Student Login | kgnst.com</title><link rel="stylesheet" href="assets/style.css"></head><body class="center-page"><main class="auth-card"><?php if ($student): ?><span class="eyebrow">STUDENT ACCOUNT</span><h1>Hello, <?=esc($student['full_name'])?>.</h1><p>Your registration number</p><strong class="student-id"><?=esc($student['registration_number'])?></strong><dl><dt>Course</dt><dd><?=esc($student['course'])?></dd><dt>Registered</dt><dd><?=esc(date('d M Y', strtotime($student['created_at'])))?></dd></dl><a class="button" href="index.php">Return to home</a><?php else: ?><span class="eyebrow">STUDENT LOGIN</span><h1>Access your account.</h1><p>Sign in with the registration number you received and your password.</p><?php if ($error): ?><div class="alert error"><?=esc($error)?></div><?php endif; ?><form method="post"><label>Registration number<input name="registration_number" required placeholder="KGNST-2026-XXXXXX" autocomplete="username"></label><label>Password<input type="password" name="password" required autocomplete="current-password"></label><button>Sign in</button></form><p><a class="text-link" href="forgot-password.php">Forgot password?</a></p><a class="text-link" href="registration.php">Create a student account</a><?php endif; ?></main></body></html>
