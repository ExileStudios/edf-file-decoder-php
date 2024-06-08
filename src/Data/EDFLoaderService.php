<?php

namespace EDFFileDecoderPHP\Data;

use Eolib\Data\StringEncodingUtils;

/**
 * Class EDFLoaderService
 * Service for loading and decoding EDF files.
 */
class EDFLoaderService {

    /**
     * Loads and decodes an EDF file based on its type.
     *
     * @param string $fileName The path to the EDF file.
     * @param int $fileType The type of EDF file.
     * @return string The decoded content of the EDF file.
     */
    public function loadFile(string $fileName, int $fileType): string {
        if (in_array($fileType, [DataFileTypes::CHECKSUM, DataFileTypes::CREDITS])) {
            return $this->loadUnencodedFile($fileName);
        } else {
            return $this->loadAndDecode($fileName, $fileType);
        }
    }

    /**
     * Saves the decoded data to a text file.
     *
     * @param string $fileName The path to the output text file.
     * @param string $data The decoded data to be saved.
     */
    public static function saveFile(string $fileName, string $data): void {
        file_put_contents($fileName, $data);
    }

    /**
     * Loads and decodes an encoded EDF file.
     *
     * @param string $fileName The path to the EDF file.
     * @param int $fileType The type of EDF file.
     * @return string The decoded content of the EDF file.
     */
    private function loadAndDecode(string $fileName, int $fileType): string {
        $lines = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $decodedLines = array_map(function($line) use ($fileType) {
            return $this->decodeDatString(trim($line), $fileType);
        }, $lines);
        return implode("\n", $decodedLines);
    }

    /**
     * Loads an unencoded EDF file.
     *
     * @param string $fileName The path to the EDF file.
     * @return string The content of the EDF file.
     */
    private function loadUnencodedFile(string $fileName): string {
        return file_get_contents($fileName);
    }

    /**
     * Decodes a string from an EDF file.
     *
     * @param string $content The encoded string.
     * @param int $fileType The type of EDF file.
     * @return string The decoded string.
     */
    private function decodeDatString(string $content, int $fileType): string {
        $byteData = StringEncodingUtils::stringToBytes($content);
        
        deinterleave($byteData);
        
        if ($fileType != DataFileTypes::CURSE_FILTER) {
            swapMultiples($byteData, 7);
        }
        
        return StringEncodingUtils::bytesToString($byteData);
    }
}
