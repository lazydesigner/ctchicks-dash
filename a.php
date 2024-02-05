<?php
function scrapeImages($url) {
    $imgUrls = [];
    $html = file_get_contents($url);
    $dom = new DOMDocument;
    @$dom->loadHTML($html);

    $imgTags = $dom->getElementsByTagName('img');
    foreach ($imgTags as $imgTag) {
        $src = $imgTag->getAttribute('src');
        if ($src) {
            $imgUrls[] = $src;
        }
        $dataSrc = $imgTag->getAttribute('data-src');
        if ($dataSrc) {
            $imgUrls[] = $dataSrc;
        }
    }

    return $imgUrls;
}

$a = scrapeImages('https://callgirlsinlucknow.in');

foreach($a as $s){
    downloadImage($s);
}


function downloadImage($url) {
    $imageData = file_get_contents($url);
    $filename = basename($url);
    $filepath = 'deepak' . '/' . $filename;

    file_put_contents($filepath, $imageData);

    echo "Downloaded: $filename\n";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'];
    $imgUrls = scrapeImages($url);

    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode(['imgUrls' => $imgUrls]);
    exit;
}
?>