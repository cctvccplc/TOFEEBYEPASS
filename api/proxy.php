<?php
// সেটআপ ইউজার এজেন্ট (Toffee সাধারণত এটি চেক করে)
$userAgent = 'Toffee/1.0.0 (Android 10; Mobile)';

// আপনার টার্গেট M3U লিংক
$m3u_url = 'https://raw.githubusercontent.com/BINOD-XD/Toffee-Auto-Update-Playlist/refs/heads/main/toffee_OTT_Navigator.m3u';

// cURL দিয়ে ডাটা ফেচ করা
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $m3u_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$data = curl_exec($ch);
curl_close($ch);

// কন্টেন্ট টাইপ সেট করা যাতে প্লেয়ার বুঝতে পারে এটি M3U ফাইল
header('Content-Type: audio/x-mpegurl');
echo $data;
?>
