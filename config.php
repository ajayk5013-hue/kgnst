<?php
declare(strict_types=1);

const APP_NAME = 'kgnst.com';
const TRUST_NAME = 'Khawaja Garib Nawaj Sewa Trust';
const INSTITUTE_PHONE = '+919839654910';
const SITE_URL = 'https://kgnst.com';
const DB_PATH = __DIR__ . '/data/kgn.sqlite';

session_name('kgnst_session');
session_start();

// Keep the public-facing brand consistent across every page.
ob_start(static function (string $content): string {
    $content = str_replace(
        ['KGN Computer Institute', 'K.G.N', 'KGN registration', 'KGN website', 'kgncomputerinstitute.in', 'KGN-'],
        ['kgnst.com', 'kgnst.com', 'kgnst.com registration', 'kgnst.com website', 'kgnst.com', 'KGNST-'],
        $content
    );
    $content = preg_replace('/KGN(?!ST)/', 'kgnst.com', $content) ?? $content;

    $courseMenu = '<div class="course-menu"><a class="course-toggle" href="index.php#courses">Courses <span aria-hidden="true">⌄</span></a><div class="course-dropdown"><a href="index.php#courses"><b>BCC</b><small>Basic computer concepts and digital skills</small></a><a href="index.php#courses"><b>CCC</b><small>Everyday computer and internet use</small></a><a href="index.php#courses"><b>DCA</b><small>MS Office, typing, Internet and Photoshop</small></a><a href="index.php#courses"><b>ADCA</b><small>DCA + PageMaker, Accounting and Tally</small></a></div></div>';
    $content = str_replace(['<a href="#courses">Courses</a>', '<a href="index.php#courses">Courses</a>'], $courseMenu, $content);
    $menuStyles = '<style>.course-menu{position:relative}.course-toggle{display:inline-flex;gap:5px;align-items:center}.course-toggle span{font-size:16px;line-height:.7}.course-dropdown{position:absolute;z-index:20;top:calc(100% + 17px);left:-18px;width:270px;background:#fffefa;border:1px solid #d7dedc;box-shadow:8px 10px 20px #10233c24;opacity:0;visibility:hidden;transform:translateY(-7px);transition:.18s ease}.course-menu:hover .course-dropdown,.course-menu:focus-within .course-dropdown{opacity:1;visibility:visible;transform:translateY(0)}.course-dropdown a{display:block!important;padding:12px 16px;border-bottom:1px solid #e5e9e7;text-decoration:none}.course-dropdown a:last-child{border-bottom:0}.course-dropdown a:hover,.course-dropdown a:focus{background:#e7f4f1}.course-dropdown b{display:block;font-size:13px;color:#10233c}.course-dropdown small{display:block;margin-top:2px;color:#597085;font-size:11px;font-weight:400;line-height:1.35}@media(max-width:760px){.course-menu{display:none}}</style>';
    $queryStyles = '<style>.query-widget{position:fixed;z-index:50;right:20px;bottom:0;width:292px;box-shadow:0 8px 25px #10233c33}.query-toggle{width:100%;display:flex;justify-content:space-between;align-items:center;background:#19ace2;color:#fff;border:0;padding:15px 16px;font-size:18px;cursor:pointer}.query-toggle span{font-size:23px;line-height:1}.query-form{display:none;background:#fffefa;padding:17px 20px 16px;border:1px solid #d7dedc;border-top:0}.query-widget.open .query-form{display:block}.query-widget.open .query-toggle span{transform:rotate(180deg)}.query-form input,.query-form select,.query-form textarea{width:100%;margin:0 0 9px;padding:10px 11px;border:1px solid #bbc9c6;border-radius:3px;background:white;font:13px Arial;color:#10233c}.query-form textarea{height:72px;resize:vertical}.query-submit{display:block;margin:2px auto 0;background:#19ace2;color:white;border:0;border-radius:3px;padding:10px 25px;font-weight:bold;font-size:14px;cursor:pointer}.query-notice{position:fixed;z-index:60;right:20px;bottom:72px;max-width:292px;background:#e7f4f1;border-left:4px solid #20d7c1;padding:13px 15px;color:#10233c;font-size:13px;box-shadow:0 6px 18px #10233c22}@media(max-width:500px){.query-widget{right:10px;width:calc(100% - 20px)}.query-notice{right:10px}} </style>';
    $roundedMessageStyles = '<style>.query-form textarea,.contact-page textarea{height:48px!important;min-height:48px!important;padding:12px 11px!important;border:2px solid #111!important;border-radius:25px!important;background:#fff;resize:vertical}.query-submit,.contact-page form button{display:block;margin:2px auto 0;background:#19ace2!important;color:#fff!important;border:0!important;border-radius:22px!important;padding:10px 25px!important;font-weight:bold!important}</style>';
    $logoStyle = '<style>.institute-home .topbar{min-height:92px;border-bottom:1px solid #dde5ee}.institute-home .logo-block{gap:10px}.institute-home .logo-icon{font-size:0!important;width:38px!important;height:40px!important;border:0!important;background:url("assets/computer-logo.svg") center/contain no-repeat!important}.institute-home .logo-icon:before,.institute-home .logo-icon:after{display:none!important}.institute-home .logo-block strong{font-family:Arial,sans-serif;font-size:25px!important;font-weight:800!important;letter-spacing:.2px!important;color:#003d7c!important}.institute-home .logo-block small{font-size:12px!important;letter-spacing:.15px;color:#e32f2f!important;font-weight:700!important;margin-top:3px!important}</style>';
    $content = str_replace('</head>', $menuStyles . $queryStyles . $roundedMessageStyles . $logoStyle . '</head>', $content);
    if (str_contains($content, '<title>Student Login')) {
        $studentLoginStyle = '<style>.student-login-page{background:linear-gradient(135deg,#edf7f5 0%,#f8f6f1 58%,#d9f6f0 100%)}.student-login-page .auth-card{position:relative;width:min(100%,480px);padding:29px 34px 32px;border-radius:14px;border:0;box-shadow:0 14px 35px #10233c22}.student-login-page .auth-card:before{content:"";position:absolute;top:0;left:0;right:0;height:7px;border-radius:14px 14px 0 0;background:linear-gradient(90deg,#20d7c1,#19ace2)}.student-login-page .auth-card h1{font-size:38px;letter-spacing:-1.8px;line-height:1.05;margin:12px 0}.student-login-page .auth-card p{font-size:13px;line-height:1.55}.student-login-page .auth-card form{gap:13px;margin:20px 0}.student-login-page .auth-card input{min-height:41px}.student-login-page .auth-card button{width:100%;padding:11px;background:#19ace2;border-radius:7px}.student-login-page .auth-card .text-link{display:inline-block;margin-top:10px;font-size:12px}@media(max-width:500px){.student-login-page .auth-card{padding:27px 23px}.student-login-page .auth-card h1{font-size:33px}}</style>';
        $content = str_replace('<body class="center-page">', '<body class="center-page student-login-page">', $content);
        $content = str_replace('</head>', $studentLoginStyle . '</head>', $content);
    }
    $content = preg_replace('#<a class="nav-cta" href="tel:[^"]+">Call now</a>#', '<a class="nav-cta" href="contact.php">Contact Us</a>', $content) ?? $content;
    $content = str_replace('<a class="button small" href="logout.php">Log out</a>', '<a class="button small" href="queries.php">View queries</a><a class="button small" href="logout.php">Log out</a>', $content);
    $notice = $_SESSION['query_flash'] ?? '';
    unset($_SESSION['query_flash']);
    $queryNotice = $notice === '' ? '' : '<div class="query-notice">' . htmlspecialchars($notice, ENT_QUOTES, 'UTF-8') . '</div>';
    $content = str_replace(
        ['<label class="full">Your message *<textarea name="message" required style="min-height:110px">', '</textarea></label></div><button>Submit message</button>'],
        ['<textarea name="message" required placeholder="Message">', '</textarea></div><button>Submit</button>'],
        $content
    );
    if (!str_contains($content, 'class="admin-page"') && !str_contains($content, 'class="center-page') && !str_contains($content, 'class="contact-page"')) {
        $queryWidget = '<div class="query-widget" id="query-widget"><button class="query-toggle" type="button" aria-expanded="false" aria-controls="query-form">Drop a Query <span aria-hidden="true">⌃</span></button><form class="query-form" id="query-form" action="query.php" method="post"><input name="full_name" required autocomplete="name" placeholder="Enter Name *"><input name="phone" required pattern="[0-9]{10}" inputmode="numeric" autocomplete="tel" placeholder="Mobile number *"><input name="email" type="email" autocomplete="email" placeholder="Enter Email"><select name="course"><option value="">-- Select Course --</option><option>BCC</option><option>CCC</option><option>DCA</option><option>ADCA</option></select><textarea name="message" required placeholder="Your query / message *"></textarea><button class="query-submit" type="submit">Submit</button></form></div><script>document.querySelector(".query-toggle")?.addEventListener("click",function(){const w=document.getElementById("query-widget"),open=w.classList.toggle("open");this.setAttribute("aria-expanded",open)})</script>';
        $queryWidget = str_replace('Your query / message *', 'Message', $queryWidget);
        $content = str_replace('</body>', $queryNotice . $queryWidget . '</body>', $content);
    }
    return $content;
});
