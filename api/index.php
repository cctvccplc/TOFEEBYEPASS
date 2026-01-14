<?php
// ১. M3U ফাইল পাথ সেটআপ
$m3u_file = '../tofee.m3u'; 
if (file_exists($m3u_file)) {
    $m3u_content = file_get_contents($m3u_file);
} else {
    die("Error: tofee.m3u file not found in root directory!");
}

// ২. Regex দিয়ে চ্যানেল ডাটা সংগ্রহ
preg_match_all('/#EXTINF:.*tvg-logo="(.*?)".*,(.*)\n(?:#EXTVLCOPT:.*\n|#EXTHTTP:.*\n)*(http.*)/', $m3u_content, $matches);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toffee Premium Player</title>
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    <style>
        body { background: #000; color: #fff; font-family: sans-serif; margin: 0; padding: 0; }
        .header { background: #cc0000; padding: 15px; text-align: center; font-size: 20px; font-weight: bold; }
        #player-container { width: 100%; max-width: 800px; margin: 10px auto; display: none; }
        .channel-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px; padding: 20px; }
        .channel-item { background: #1a1a1a; padding: 10px; border-radius: 8px; text-align: center; cursor: pointer; transition: 0.3s; }
        .channel-item:hover { background: #333; transform: scale(1.05); border: 1px solid #cc0000; }
        .channel-item img { width: 60px; height: 60px; object-fit: contain; }
        .channel-item p { font-size: 12px; margin-top: 8px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    </style>
</head>
<body>

<div class="header">TOFFEE LIVE WEB</div>

<div id="player-container">
    <video id="my-player" class="video-js vjs-default-skin vjs-16-9 vjs-big-play-centered" controls preload="auto"></video>
    <button onclick="closePlayer()" style="width:100%; background:#cc0000; color:white; border:none; padding:10px; cursor:pointer; font-weight:bold;">CLOSE PLAYER</button>
</div>

<div class="channel-list">
    <?php
    if (!empty($matches[1])) {
        for ($i = 0; $i < count($matches[1]); $i++) {
            $logo = $matches[1][$i];
            $name = $matches[2][$i];
            $url = trim($matches[3][$i]);
            // urlencode ব্যবহার করে নিরাপদ লিঙ্ক তৈরি
            echo '<div class="channel-item" onclick="playVideo(\''.urlencode($url).'\')">
                    <img src="'.$logo.'" onerror="this.src=\'https://via.placeholder.com/60?text=TV\'">
                    <p>'.$name.'</p>
                  </div>';
        }
    } else {
        echo "<p>No channels found in M3U file.</p>";
    }
    ?>
</div>

<script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
<script>
    // ভিডিও প্লেয়ার ইনিশিয়ালাইজ
    var player = videojs('my-player');

    function playVideo(encodedUrl) {
        // প্লেয়ার কন্টেইনার দেখানো
        document.getElementById('player-container').style.display = 'block';
        
        // প্রক্সি ইউআরএল তৈরি
        var streamUrl = 'proxy.php?url=' + encodedUrl;
        
        player.src({
            src: streamUrl,
            type: 'application/x-mpegURL'
        });
        
        player.play();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function closePlayer() {
        player.pause();
        document.getElementById('player-container').style.display = 'none';
    }
</script>

</body>
</html>
