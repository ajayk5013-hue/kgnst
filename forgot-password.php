<?php
require_once __DIR__ . '/db.php';
if (!isConfigured()) { header('Location: setup.php'); exit; }
$error = ''; $success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registration = strtoupper(trim($_POST['registration_number'] ?? ''));
    $phone = preg_replace('/\D/', '', $_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if ($registration === '' || strlen($phone) !== 10 || strlen($password) < 6 || $password !== $confirm) {
        $error = 'Enter your registration number, registered 10-digit mobile number, and matching password of at least 6 characters.';
    } else {
        $stmt = database()->prepare('SELECT id FROM students WHERE registration_number = ? AND phone = ?');
        $stmt->execute([$registration, $phone]); $student = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$student) $error = 'The registration number and mobile number do not match our records.';
        else { database()->prepare('UPDATE students SET password_hash = ? WHERE id = ?')->execute([password_hash($password, PASSWORD_DEFAULT), $student['id']]); $success = true; }
    }
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Reset Password | kgnst.com</title><link rel="stylesheet" href="assets/style.css"></head><body class="center-page"><main class="auth-card"><span class="eyebrow">PASSWORD RESET</span><h1>Reset your <em>password.</em></h1><?php if ($success): ?><div class="success"><h2>Password updated.</h2><p>Your new password has been saved. You can now sign in.</p><a class="button" href="student.php">Go to student login</a></div><?php else: ?><p>Verify your registration number and the mobile number used during registration.</p><?php if ($error): ?><div class="alert error"><?=esc($error)?></div><?php endif; ?><form method="post"><label>Registration number<input name="registration_number" required placeholder="KGNST-2026-XXXXXX" autocomplete="username" value="<?=esc($_POST['registration_number'] ?? '')?>"></label><label>Registered mobile number<input name="phone" required pattern="[0-9]{10}" inputmode="numeric" autocomplete="tel" placeholder="10-digit mobile number" value="<?=esc($_POST['phone'] ?? '')?>"></label><label>New password<input type="password" name="password" required minlength="6" autocomplete="new-password" placeholder="At least 6 characters"></label><label>Confirm new password<input type="password" name="confirm_password" required minlength="6" autocomplete="new-password"></label><button>Reset password</button></form><a class="text-link" href="student.php">← Back to student login</a><?php endif; ?></main></body></html>
