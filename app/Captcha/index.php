<?php
// session_start()前不能有输出
session_start();

use App\Captcha;

include './Captcha.php';

$captcha = new Captcha\Captcha;
$code = $captcha->make();
$_SESSION['captcha'] = strtolower($code);
