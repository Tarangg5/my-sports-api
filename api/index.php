<?php
// JSON Source URL
$source_url = "https://sports.pfy.workers.dev";

// Fetch the JSON data
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $source_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$json_data = curl_exec($ch);
curl_close($ch);

$channels = json_decode($json_data, true);

header('Content-Type: audio/x-mpegurl');
echo "#EXTM3U x-tvg-url=\"https://avkb.xyz/dpl/guide.xml\"\n\n";

if ($channels) {
    foreach ($channels as $channel) {
        $name = $channel['name'] ?? 'Unknown';
        $logo = $channel['logo'] ?? '';
        $link = $channel['link'] ?? '';
        $cookie = $channel['cookie'] ?? '';
        $key = $channel['drmLicense'] ?? '';
        $drmScheme = $channel['drmScheme'] ?? 'clearkey';

        // EPG mapping
        $tvg_id = str_replace([' ', 'HD'], ['', ''], $name) . ".in";

        echo "#EXTINF:-1 tvg-id=\"$tvg_id\" tvg-name=\"$name\" tvg-logo=\"$logo\" group-title=\"Sports\", $name\n";
        echo "#KODIPROP:inputstream.adaptive.license_type=$drmScheme\n";
        echo "#KODIPROP:inputstream.adaptive.license_key=$key\n";
        echo "#EXTHTTP:{\"Cookie\":\"$cookie\"}\n";
        echo "$link\n\n";
    }
}
?>
