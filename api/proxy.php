<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/vnd.apple.mpegurl");

$url = $_GET['url'] ?? '';
if (!$url) die("No URL provided.");

$url = urldecode($url);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36");

// Toffee কে বুঝানো হচ্ছে যে রিকোয়েস্টটি তাদের সাইট থেকেই আসছে
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Referer: https://toffeelive.com/",
    "Origin: https://toffeelive.com/"
]);

$response = curl_exec($ch);
curl_close($ch);

// ভিডিওর ভেতরের লিঙ্কগুলোকে প্রক্সির মাধ্যমে রি-রাইট করা (যাতে লোডিং না আটকে থাকে)
$base_url = dirname($url) . '/';
$response = preg_replace('/(?<!http)([\w\-]+\.ts|[\w\-]+\.m3u8)/', $base_url . '$1', $response);

echo $response;
?>
