<?php
$m3u_file = '../tofee.m3u'; 
if (file_exists($m3u_file)) {
    $m3u_content = file_get_contents($m3u_file);
} else {
    die("Error: tofee.m3u not found in root!");
}
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
        .channel-item:hover { background: #333; transform: scale(1.05); }
        .channel-item img { width: 60px; height: 60px; object-fit: contain; }
        .channel-item p { font-size: 12px; margin-top: 8px; }
    </style>
</head>
<body>
<div class="header">TOFFEE LIVE WEB</div>
<div id="player-container">
    <video id="my-player" class="video-js vjs-default-skin vjs-16-9 vjs-big-play-centered" controls preload="auto"></video>
    <button onclick="closePlayer()" style="width:100%; background:red; color:white; border:none; padding:10px; cursor:pointer;">CLOSE PLAYER</button>
</div>
<div class="channel-list">
    <?php
    for ($i = 0; $i < count($matches[1]); $i++) {
        echo '<div class="channel-item" onclick="playVideo(\''.urlencode(trim($matches[3][$i])).'\')">
                <img src="'.$matches[1][$i].'" onerror="this.src=\'https://via.placeholder.com/60\'">
                <p>'.$matches[2][$i].'</p>
              </div>';
    }
    ?>
</div>
<script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
<script>
    var player = videojs('my-player');
    function playVideo(url) {
        document.getElementById('player-container').style.display = 'block';
        player.src({ src: 'proxy.php?url=' + url, type: 'application/x-mpegURL' });
        player.play();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    function closePlayer() { player.pause(); document.getElementById('player-container').style.display = 'none'; }
</script>
</body>
</html>
