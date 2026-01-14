<?php
$url = $_GET['url'] ?? '';

if (!$url) {
    die("No URL provided.");
}

// URL টি ডিকোড করা
$url = urldecode($url);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// Toffee-র জন্য প্রয়োজনীয় হেডারসমূহ
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36",
    "Referer: https://toffeelive.com/",
    "Origin: https://toffeelive.com/",
    "Cookie: YOUR_TOFFEE_COOKIE_HERE" // এখানে আপনার আপডেট করা কুকি বসাতে হবে
]);

$response = curl_exec($ch);
$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

// ভিডিও প্লেয়ারকে কন্টেন্ট টাইপ জানানো
header("Content-Type: " . $content_type);
echo $response;
?>
