<?php

namespace EDFFileDecoderPHP\Data;

/**
 * Class EDFParser
 * Responsible for parsing all EDF files in a specified directory.
 */
class EDFParser {

    /**
     * Parses all EDF files in the specified directory, decodes them, and saves the decoded content to text files.
     *
     * @param string $directory The directory containing the EDF files.
     * @throws \InvalidArgumentException If the specified directory is invalid or not readable.
     */
    public function parseAllEDFFiles(string $directory): void {
        if (!is_dir($directory) || !is_readable($directory)) {
            throw new \InvalidArgumentException("The specified directory is invalid or not readable: {$directory}");
        }

        $dataFiles = array_filter(scandir($directory), function($file) {
            return pathinfo($file, PATHINFO_EXTENSION) == 'edf';
        });

        if (empty($dataFiles)) {
            echo "No EDF files found in the directory: {$directory}\n";
            return;
        }

        $edfLoader = new EDFLoaderService();

        // Mapping EDF file numbers to their types
        $fileTypeMap = [
            1 => DataFileTypes::CHECKSUM,
            2 => DataFileTypes::CREDITS,
            3 => DataFileTypes::CURSE_FILTER
        ];

        foreach ($dataFiles as $dataFile) {
            $filePath = $directory . DIRECTORY_SEPARATOR . $dataFile;
            $fileNumber = (int)substr($dataFile, 3, 3); // Extract the number from the file name
            $fileType = $fileTypeMap[$fileNumber] ?? DataFileTypes::OTHER;

            $edfData = $edfLoader->loadFile($filePath, $fileType);
            $outputFile = $directory . DIRECTORY_SEPARATOR . str_replace('.edf', '.txt', $dataFile);
            EDFLoaderService::saveFile($outputFile, $edfData);
            echo "Decoded content of {$dataFile} saved to {$outputFile}.\n";
        }
    }
}
