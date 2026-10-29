<!-- for run this code in the root terminal run this "php cleanup_unused_media.php" it will delete unused media -->

<?php
// Set file extensions to check
$mediaExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'webm', 'avi', 'mov'];

// File types where media might be used
$codeExtensions = ['php', 'html', 'css', 'js'];

// Collect all media files
$mediaFiles = [];
$directory = new RecursiveDirectoryIterator(__DIR__);
$iterator = new RecursiveIteratorIterator($directory);

foreach ($iterator as $file) {
    if ($file->isFile()) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($ext, $mediaExtensions)) {
            $mediaFiles[] = $file->getPathname();
        }
    }
}

// Search all code content
$allCode = '';
foreach ($iterator as $file) {
    if ($file->isFile()) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($ext, $codeExtensions)) {
            $allCode .= file_get_contents($file->getPathname()) . "\n";
        }
    }
}

// Find unused files
$unused = [];
foreach ($mediaFiles as $filePath) {
    $filename = basename($filePath);
    if (stripos($allCode, $filename) === false) {
        $unused[] = $filePath;
    }
}

// Show unused files
echo "Unused media files:\n\n";
if (count($unused) === 0) {
    echo "🎉 No unused media files found!\n";
    exit;
}

foreach ($unused as $file) {
    echo $file . "\n";
}

// Ask user to confirm deletion
echo "\nDo you want to delete these files? Type 'yes' to confirm: ";
$handle = fopen("php://stdin", "r");
$line = trim(fgets($handle));
if ($line === 'yes') {
    foreach ($unused as $file) {
        unlink($file);
        echo "Deleted: $file\n";
    }
    echo "\n✅ All unused files deleted.\n";
} else {
    echo "\n❌ No files were deleted.\n";
}
fclose($handle);
