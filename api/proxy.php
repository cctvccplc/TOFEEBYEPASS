<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/vnd.apple.mpegurl"); // ব্রাউজারকে জানানো যে এটি ভিডিও ফাইল

if (isset($_GET['url'])) {
    $url = $_GET['url'];
    $userAgent = "Mozilla/5.0 (Linux; Android 9; Redmi S2 Build/PKQ1.181203.001) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.7049.79 Mobile Safari/537.36";
    $cookie = "Edge-Cache-Cookie=URLPrefix=aHR0cHM6Ly9ibGRjbXByb2QtY2RuLnRvZmZlZWxpdmUuY29t:Expires=1768591340:KeyName=prod_linear:Signature=N2pe6EUZ4gRrLQtQXKmDfuLaRcDMcOlciOD5QV7v8iDQJPQHzOieViNZDUNjKca4hmOyxa3M5dEOyW6_9OeRDA";

    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: $userAgent\r\n" . 
                        "Cookie: $cookie\r\n" .
                        "Referer: https://toffeelive.com/\r\n" // অনেক সময় রেফারার প্রয়োজন হয়
        ]
    ];

    $context = stream_context_create($opts);
    $data = @file_get_contents($url, false, $context);
    
    if ($data === FALSE) {
        header("HTTP/1.1 500 Internal Server Error");
        echo "Error: Could not fetch stream. Maybe cookie expired.";
    } else {
        echo $data;
    }
} else {
    echo "No URL provided.";
}
?>
