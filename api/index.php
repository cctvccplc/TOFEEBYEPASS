<?php
// ১. M3U ফাইল পাথ
$m3u_file = 'tofee.m3u'; 
if (!file_exists($m3u_file)) {
    $m3u_file = 'api/tofee.m3u'; // যদি api ফোল্ডারে থাকে
}

if (file_exists($m3u_file)) {
    $m3u_content = file_get_contents($m3u_file);
} else {
    die("Error: tofee.m3u not found!");
}

// ২. চ্যানেল ডাটা সংগ্রহ
preg_match_all('/#EXTINF:.*tvg-logo="(.*?)".*,(.*)\n(?:#EXTVLCOPT:.*\n|#EXTHTTP:.*\n)*(http.*)/', $m3u_content, $matches);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Toffee Player</title>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <style>
        body { background: #0b0b0b; color: #fff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; }
        .header { background: #cc0000; padding: 15px; text-align: center; font-size: 22px; font-weight: bold; box-shadow: 0 2px 10px rgba(0,0,0,0.5); }
        #player-wrapper { width: 100%; max-width: 900px; margin: 20px auto; display: none; background: #000; border-radius: 10px; overflow: hidden; }
        .channel-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 15px; padding: 20px; }
        .channel-item { background: #1a1a1a; padding: 10px; border-radius: 12px; text-align: center; cursor: pointer; transition: 0.3s; border: 1px solid #333; }
        .channel-item:hover { background: #cc0000; transform: translateY(-5px); border-color: #fff; }
        .channel-item img { width: 70px; height: 70px; object-fit: contain; margin-bottom: 8px; }
        .channel-item p { font-size: 13px; margin: 0; font-weight: 500; height: 32px; overflow: hidden; }
        .close-btn { background: #555; color: white; border: none; padding: 8px; width: 100%; cursor: pointer; font-weight: bold; }
        .close-btn:hover { background: #333; }
    </style>
</head>
<body>

<div class="header">TOFFEE LIVE WEB</div>

<div id="player-wrapper">
    <video id="player" playsinline controls></video>
    <button class="close-btn" onclick="closePlayer()">CLOSE PLAYER</button>
</div>

<div class="channel-list">
    <?php
    for ($i = 0; $i < count($matches[1]); $i++) {
        $logo = $matches[1][$i];
        $name = $matches[2][$i];
        $url = trim($matches[3][$i]);
        echo '<div class="channel-item" onclick="playStream(\''.base64_encode($url).'\')">
                <img src="'.$logo.'" onerror="this.src=\'https://via.placeholder.com/70?text=TV\'">
                <p>'.$name.'</p>
              </div>';
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
<script>
    const video = document.querySelector('#player');
    const playerWrapper = document.querySelector('#player-wrapper');
    const player = new Plyr(video);

    function playStream(encodedUrl) {
        const streamUrl = atob(encodedUrl); // Base64 decode
        playerWrapper.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });

        if (Hls.isSupported()) {
            const hls = new Hls();
            hls.loadSource(streamUrl);
            hls.attachMedia(video);
            hls.on(Hls.Events.MANIFEST_PARSED, function() {
                video.play();
            });
        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            // For Safari
            video.src = streamUrl;
            video.play();
        }
    }

    function closePlayer() {
        player.stop();
        playerWrapper.style.display = 'none';
    }
</script>

</body>
</html>
