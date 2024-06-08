<?php

namespace EDFFileDecoderPHP;

require_once __DIR__ . '/../vendor/autoload.php';

use EDFFileDecoderPHP\Data\EDFParser;

// Check if a directory argument is provided
if ($argc != 2) {
    echo "Usage: php src/Main.php <directory>\n";
    exit(1);
}

try {
    // Execute the function to parse and decode all EDF files in the specified directory.
    $directory = $argv[1];
    $parser = new EDFParser();
    $parser->parseAllEDFFiles($directory);
} catch (\InvalidArgumentException $e) {
    echo $e->getMessage() . "\n";
    exit(1);
} catch (\Exception $e) {
    echo "An unexpected error occurred: " . $e->getMessage() . "\n";
    exit(1);
}
