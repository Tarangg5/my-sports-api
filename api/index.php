<html>
<title>Radio Player By Sonu</title>
<head>
  <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .player-container { max-width: 500px; background: #181920; padding: 18px; border-radius: 14px; box-shadow: 0 8px 16px rgba(0,0,0,0.12); }
    audio { width: 100%; background: #21222b; border-radius: 8px; }
    .playlist { list-style: none; padding: 0; }
    .playlist li { background: #21222b; color: #fff; margin-bottom: 7px; border-radius: 5px; padding: 8px; cursor: pointer; }
    .playlist li.active { background: #24a4f9; color: #fff; font-weight: bold; }
    .playlist li:hover { background: #182c3c; }
  </style>
</head>
<body>
  <div class="player-container">
    <h1><p style="color: green;"> Radio Playlist </p></h1>
    <audio id="audioPlayer" controls></audio>
    <ul class="playlist" id="playlist"></ul>
  </div>
  <script>
    const audioPlayer = document.getElementById('audioPlayer');
    const playlist = document.getElementById('playlist');
    const audioFiles = [
    { name: 'VIVID BHARATI', src: 'https://air.pc.cdn.bitgravity.com/air/live/pbaudio001/chunklist.m3u8' },
{ name: 'FM GOLD', src: 'https://airhlspush.pc.cdn.bitgravity.com/httppush/hlspbaudio005/hlspbaudio00564kbps.m3u8' },
{ name: 'FM RAINBOW', src: 'https://airhlspush.pc.cdn.bitgravity.com/httppush/hlspbaudio004/hlspbaudio00464kbps.m3u8' },
{ name: 'AIR RADIO NEWS', src: 'https://airhlspush.pc.cdn.bitgravity.com/httppush/hlspbaudio002/hlspbaudio00264kbps.m3u8' },  
{ name: 'Akashwani PATNA', src: 'https://air.pc.cdn.bitgravity.com/air/live/pbaudio087/chunklist.m3u8' },
{ name: 'Akashwani Sasaram', src: 'https://air.pc.cdn.bitgravity.com/air/live/pbaudio075/chunklist.m3u8' },
{ name: 'VBS DELHI', src: 'https://airhlspush.pc.cdn.bitgravity.com/httppush/hlspbaudio238/hlspbaudio23864kbps.m3u8' },
{ name: 'INDRAPRASTH', src: 'https://airhlspush.pc.cdn.bitgravity.com/httppush/hlspbaudio006/hlspbaudio00664kbps.m3u8' },
{ name: 'Akashwani chattisgarh', src: 'https://air.pc.cdn.bitgravity.com/air/live/pbaudio118/chunklist.m3u8' }, 
{ name: 'Akashwani Saraipali', src: 'https://air.pc.cdn.bitgravity.com/air/live/pbaudio254/chunklist.m3u8' },
{ name: 'Md Rafi', src: 'https://stream.zeno.fm/2xx62x8ztm0uv' },
{ name: 'BOLLYWOOD 90', src: 'https://stream.zeno.fm/143d7gty24zuv' },
{ name: 'KISHOR KR', src: 'https://server.mixify.in:8010/radio.mp3' },
 { name: 'BIG FM 92.7', src: 'https://stream.zeno.fm/dbstwo3dvhhtv' },
{ name: 'RED FM 93.5', src: 'https://stream.zeno.fm/9phrkb1e3v8uv' },
{ name: 'ISHQ FM', src: 'https://drive.uber.radio/uber/bollywoodlove/icecast.audio' },
{ name: 'HITS OF BOLLYWOOD', src: 'https://stream.zeno.fm/a2gyqzwpwfeuv' },
{ name: 'Radio Retro Bollywood', src: 'https://stream.zeno.fm/g372rxef798uv' },
{ name: 'Bollywood Radio and Beyond', src: 'https://s6.yesstreaming.net/proxy/john1237?mp=/live' },
{ name: 'Radio Baingan online', src: 'https://stream.zeno.fm/eyxg23ky4x8uv' },
      // ...add more as you need
    ];

    let hls;

    function detachHLS() {
      if (hls) {
        hls.destroy();
        hls = null;
      }
    }

    function loadAudio(audioSrc, listItem) {
      detachHLS();

      // For .m3u8 (HLS) audio
      if (audioSrc.endsWith('.m3u8') && window.Hls && Hls.isSupported()) {
        hls = new Hls();
        hls.loadSource(audioSrc);
        hls.attachMedia(audioPlayer);
        audioPlayer.load();
        setTimeout(() => { audioPlayer.play(); }, 200);
      } else {
        // For normal mp3/ogg streams
        audioPlayer.src = audioSrc;
        audioPlayer.load();
        setTimeout(() => { audioPlayer.play(); }, 100);
      }

      document.querySelectorAll('.playlist li').forEach(item => item.classList.remove('active'));
      listItem.classList.add('active');
    }

    // Create playlist UI and set click listeners
    audioFiles.forEach((audio, idx) => {
      const li = document.createElement('li');
      li.textContent = audio.name;
      li.tabIndex = 0;
      li.onclick = () => loadAudio(audio.src, li);
      playlist.appendChild(li);
      if (idx === 0) setTimeout(() => loadAudio(audio.src, li), 100);
    });
  </script>
</body>
</html>
