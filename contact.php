<?php
require_once __DIR__ . '/db.php';
if (!isConfigured()) { header('Location: setup.php'); exit; }
$error = ''; $sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name'] ?? '');
    $phone = preg_replace('/\D/', '', $_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name === '' || strlen($phone) !== 10 || $message === '' || ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL))) {
        $error = 'Please enter your name, valid 10-digit mobile number, and message.';
    } else {
        database()->prepare('INSERT INTO queries (full_name,phone,email,course,message,created_at) VALUES (?,?,?,?,?,?)')->execute([$name, $phone, $email ?: null, $course ?: null, $message, date(DATE_ATOM)]);
        $sent = true;
    }
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Contact Us | kgnst.com</title><link rel="stylesheet" href="assets/style.css"></head><body class="contact-page"><nav><a class="brand" href="index.php"><span class="mark">◆</span>kgnst.com</a><div class="links"><a href="index.php#courses">Courses</a><a href="about.php">About</a><a href="registration.php">Register</a><a href="student.php">Student login</a><a class="nav-cta" href="contact.php">Contact Us</a></div></nav><main class="register-layout"><section class="intro"><span class="eyebrow">CONTACT US</span><h1>Let’s start a <em>conversation.</em></h1><p>Have a question about admissions, batches or courses? Send your message below and our team can get back to you.</p><p>Contact information and office hours can be added here whenever you are ready.</p></section><section class="form-card"><?php if ($sent): ?><div class="success"><span class="eyebrow">MESSAGE SENT</span><h2>Thank you, <?=esc($_POST['full_name'])?>.</h2><p>Your message has been received. We will contact you soon.</p><a class="button" href="contact.php">Send another message</a></div><?php else: ?><h2>Send us a message</h2><p>Fields marked with * are required.</p><?php if ($error): ?><div class="alert error"><?=esc($error)?></div><?php endif; ?><form method="post"><div class="fields"><label class="full">Full name *<input name="full_name" required autocomplete="name" value="<?=esc($_POST['full_name'] ?? '')?>"></label><label>Mobile number *<input name="phone" required pattern="[0-9]{10}" inputmode="numeric" autocomplete="tel" placeholder="10-digit mobile number" value="<?=esc($_POST['phone'] ?? '')?>"></label><label>Email address<input type="email" name="email" autocomplete="email" value="<?=esc($_POST['email'] ?? '')?>"></label><label class="full">Course interested in<select name="course"><option value="">Select a course</option><option>BCC</option><option>CCC</option><option>DCA</option><option>ADCA</option></select></label><label class="full">Your message *<textarea name="message" required style="min-height:110px"><?=esc($_POST['message'] ?? '')?></textarea></label></div><button>Submit message</button></form><?php endif; ?></section></main><footer><span>© <?=date('Y')?> <?=APP_NAME?></span><span>Sikahari Nahar, Ghazipur, Uttar Pradesh</span><a href="admin.php">Admin login</a></footer></body></html>
