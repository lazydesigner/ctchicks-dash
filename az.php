<?php

function createUniqueFolder($baseFolder) {
    $uniqueFolder = $baseFolder . '/' . uniqid('image_folder_');
    
    if (!file_exists($uniqueFolder)) {
        mkdir($uniqueFolder, 0777, true);
    }

    return $uniqueFolder;
}

function downloadImage($url, $folder) {
    $imageData = file_get_contents($url);

    if ($imageData !== false) {
        $filename = basename($url);
        $filepath = $folder . '/' . $filename;

        file_put_contents($filepath, $imageData);

        return "Downloaded: $filename";
    } else {
        return "Failed to download image from $url";
    }
}

function zipFolder($folder, $zipFilePath) {
    $zip = new ZipArchive();
    if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($folder),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($folder) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();
        return true;
    } else {
        return false;
    }
}

// Example usage
$imageUrl = 'https://cdn.ctgal.com/content/images/1953-1.jpg';
$baseFolder = './';

$uniqueFolder = createUniqueFolder($baseFolder);
downloadImage($imageUrl, $uniqueFolder);

$zipFilePath = $uniqueFolder . '.zip';
if (zipFolder($uniqueFolder, $zipFilePath)) {
    // Provide the zip file for download
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . basename($zipFilePath) . '"');
    readfile($zipFilePath);

    // Delete the folder and zip file after download
    unlink($zipFilePath);
    array_map('unlink', glob("$uniqueFolder/*.*"));
    rmdir($uniqueFolder);

    exit;
} else {
    echo "Failed to create zip file.";
}

?>
