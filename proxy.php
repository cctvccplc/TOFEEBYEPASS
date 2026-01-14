<?php
header("Access-Control-Allow-Origin: *");
if (isset($_GET['url'])) {
    $url = $_GET['url'];
    $userAgent = "Mozilla/5.0 (Linux; Android 9; Redmi S2 Build/PKQ1.181203.001) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.7049.79 Mobile Safari/537.36";
    $cookie = "Edge-Cache-Cookie=URLPrefix=aHR0cHM6Ly9ibGRjbXByb2QtY2RuLnRvZmZlZWxpdmUuY29t:Expires=1768591340:KeyName=prod_linear:Signature=N2pe6EUZ4gRrLQtQXKmDfuLaRcDMcOlciOD5QV7v8iDQJPQHzOieViNZDUNjKca4hmOyxa3M5dEOyW6_9OeRDA";

    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: $userAgent\r\n" . "Cookie: $cookie\r\n"
        ]
    ];

    $context = stream_context_create($opts);
    $data = file_get_contents($url, false, $context);
    
    // মডিফাই করা যাতে সব সেগমেন্ট লোড হয়
    echo $data;
}
?>
