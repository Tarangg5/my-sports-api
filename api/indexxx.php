<?php
// Clear any buffer
ob_start();

// Change to text/plain - this is more compatible with some IPTV apps
header('Content-Type: text/plain; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$source_url = "https://sports.pfy.workers.dev";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $source_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
$json_data = curl_exec($ch);
curl_close($ch);

// 4. Decode JSON
$channels = json_decode($json_data, true);

// 5. Start Output
echo "#EXTM3U x-tvg-url=\"https://avkb.xyz/dpl/guide.xml\"\n\n";

if ($channels && is_array($channels)) {
    foreach ($channels as $channel) {
        $name = $channel['name'] ?? 'Unknown';
        $logo = $channel['logo'] ?? '';
        $link = $channel['link'] ?? '';
        $cookie = $channel['cookie'] ?? '';
        $key = $channel['drmLicense'] ?? '';
        $drmScheme = $channel['drmScheme'] ?? 'clearkey';

        // Clean name for EPG ID mapping
        $clean_id = str_replace([' ', 'HD', '(', ')'], ['', '', '', ''], $name);
        $tvg_id = $clean_id . ".in";

        echo "#EXTINF:-1 tvg-id=\"$tvg_id\" tvg-name=\"$name\" tvg-logo=\"$logo\" group-title=\"Sports\", $name\n";
        
        // DRM Tags
        if (!empty($key)) {
            echo "#KODIPROP:inputstream.adaptive.license_type=$drmScheme\n";
            echo "#KODIPROP:inputstream.adaptive.license_key=$key\n";
        }
        
        // Cookie Tag
        if (!empty($cookie)) {
            echo "#EXTHTTP:{\"Cookie\":\"$cookie\"}\n";
        }
        
        echo "$link\n\n";
    }
} else {
    echo "#EXTINF:-1, Error: Could not load JSON data\n";
    echo "http://error.com/index.mpd\n";
}

// 6. Flush output
ob_end_flush();
?>
