<?php

namespace App\Importer;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AbstractImporter
{
    private const CSV_MINIMUM_LINES = 2;

    protected function checkFile(string $file): void
    {
        if (!file_exists($file)) {
            throw new NotFoundHttpException('File not found');
        }

        if (!is_readable($file) || !fopen($file, 'r')) {
            throw new \RuntimeException('Le fichier ne peut pas être lu.');
        }

        if ($this->hasCsvFileBom($file)) {
            throw new \RuntimeException('Un BOM a été détecté. Merci d\'encoder le fichier en "UTF-8".');
        }

        if (!$this->hasAtLeastTwoLines($file)) {
            throw new \RuntimeException('Le fichier est vide.');
        }
    }

    private function hasCsvFileBom(string $file): bool
    {
        /** @var resource $handle */
        $handle = fopen($file, 'r');

        $bom = fread($handle, 3);
        fclose($handle);

        return $bom === "\xEF\xBB\xBF";
    }

    private function hasAtLeastTwoLines(string $file): bool
    {
        /** @var resource $handle */
        $handle = fopen($file, 'r');

        $lineCount = 0;
        while (fgets($handle) !== false) {
            $lineCount++;
            if ($lineCount >= self::CSV_MINIMUM_LINES) {
                fclose($handle);

                return true;
            }
        }

        fclose($handle);

        return false;
    }
}
