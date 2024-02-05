<?php

function downloadImage($url, $folder) {
    $imageData = file_get_contents($url);
    $filename = basename($url);
    $filepath = $folder . '/' . $filename;

    file_put_contents($filepath, $imageData);

    echo "Downloaded: $filename\n";
}

function extractImages($html, $folder) {
    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    $xpath = new DOMXPath($dom);

    // Extract images with 'src' attribute
    $srcImages = $xpath->query('//img[@src]');
    foreach ($srcImages as $srcImage) {
        $src = $srcImage->getAttribute('src');
        downloadImage($src, $folder);
    }

    // Extract images with 'data-src' attribute
    $dataSrcImages = $xpath->query('//img[@data-src]');
    foreach ($dataSrcImages as $dataSrcImage) {
        $dataSrc = $dataSrcImage->getAttribute('data-src');
        downloadImage($dataSrc, $folder);
    }
}

function saveImagesFromWebsite($url, $folder) {
    $html = file_get_contents($url);

    if ($html !== false) {
        extractImages($html, $folder);
    } else {
        echo "Failed to fetch HTML content from $url\n";
    }
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $websiteUrl = $_POST['websiteUrl'];
    $saveFolder = $_POST['saveFolder'];

    saveImagesFromWebsite($websiteUrl, $saveFolder);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Downloader</title>
</head>
<body>
    <h1>Image Downloader</h1>
    <form method="post" action="">
        <label for="websiteUrl">Website URL:</label>
        <input type="text" id="websiteUrl" name="websiteUrl" required>
        <br>
        <label for="saveFolder">Save Folder:</label>
        <input type="text" id="saveFolder" name="saveFolder" required>
        <button type="submit">Download Images</button>
    </form>
</body>
</html>
