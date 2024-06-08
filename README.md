# EDF File Decoder

This script parses and decodes all `.edf` files in the specified directory and saves the decoded content to `.txt` files.

## Features

- Decodes various types of EDF files including Curse Filter, Checksum, and Credits.
- Handles encoded and unencoded EDF files.
- Uses interleave and deinterleave algorithms for decoding.

## Requirements

- PHP 7.x or later
- `eolib-php` package


## Installation

1. Clone the repository or download the script.
2. Install the required package using Composer:

```bash
composer install
```

3. Ensure proper autoloading by generating the autoload files:

```bash
composer dump-autoload
```

## Usage

Run the script from the command line, providing the path to the directory containing your .edf files:
    
```bash
php src/main.php /path/to/edf/files
```

## eolib-php

This project uses the eolib-php library for data encryption and decryption. You can find the library on GitHub: [eolib-php](https://github.com/ExileStudios/eolib-php-dist)

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.
