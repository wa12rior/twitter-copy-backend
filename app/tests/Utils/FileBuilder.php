<?php

namespace App\Tests\Utils;

use App\Entity\File;

final class FileBuilder
{
    public function __construct(
        private string $filename,
        private string $absolutePath,
        private string $extension,
    ) {
    }

    public static function create(): self
    {
        return new self(
            'example.jpeg',
            '/var/www/receipt-engine/tests/Utils/Resources/example.jpeg',
            'application/jpeg'
        );
    }

    public function build(): File
    {
        return new File(
            filename: $this->filename,
            absolutePath: $this->absolutePath,
            extension: $this->extension,
        );
    }
}
