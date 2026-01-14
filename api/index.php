<!DOCTYPE html>
<html>
<head>
    <title>Premium IPTV Player</title>
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    <style>body{background:#000; color:#fff; text-align:center; font-family:sans-serif;}</style>
</head>
<body>
    <h1>Toffee Live Web Player</h1>
    <video id="player" class="video-js vjs-default-skin vjs-big-play-centered" controls width="800" height="450">
        <source src="proxy.php?url=https://bldcmprod-cdn.toffeelive.com/cdn/live/sony_sports_1_hd/playlist.m3u8" type="application/x-mpegURL">
    </video>
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
<script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>

<script>
    // ১. ভিডিও প্লেয়ার ইনিশিয়ালাইজ করা
    var player = videojs('my-video', {
        fluid: true, // স্ক্রিন অনুযায়ী প্লেয়ার ছোট-বড় হবে
        autoplay: false,
        controls: true
    });

    // ২. চ্যানেল ক্লিক করলে ভিডিও প্লে করার ফাংশন
    function playVideo(streamUrl) {
        // প্লেয়ারের কন্টেইনারটি শো করা (যদি হাইড থাকে)
        document.getElementById('player-container').style.display = 'block';

        // প্রক্সি স্ক্রিপ্টের মাধ্যমে লিঙ্ক সেট করা
        // এখানে 'proxy.php' ব্যবহার করা হয়েছে কারণ index.php ও proxy.php একই ফোল্ডারে আছে
        player.src({
            src: 'proxy.php?url=' + encodeURIComponent(streamUrl),
            type: 'application/x-mpegURL'
        });

        // ভিডিও প্লে করা
        player.play();

        // পেজের একদম উপরে নিয়ে যাওয়া যাতে প্লেয়ার দেখা যায়
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // ৩. প্লেয়ার বন্ধ করার ফাংশন
    function closePlayer() {
        player.pause();
        document.getElementById('player-container').style.display = 'none';
    }
</script></body>
</html>
