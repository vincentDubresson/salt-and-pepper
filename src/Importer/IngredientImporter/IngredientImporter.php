<?php

namespace App\Importer\IngredientImporter;

use App\Entity\Ingredient;
use App\Importer\AbstractImporter;
use App\Importer\IngredientImporter\Writer\IngredientImporterWriterStep;
use App\Service\ImporterService;
use Doctrine\ORM\EntityManagerInterface;
use Port\Csv\CsvReader;
use Port\Doctrine\DoctrineWriter;
use Port\Exception;
use Port\Result;
use Port\Steps\Step;
use Port\Steps\StepAggregator as Workflow;

class IngredientImporter extends AbstractImporter
{
    private const IMPORT_DIR = '/_import/ingredient/';
    private const ERROR_DIR = '/_import/ingredient/error/';
    private const ARCHIVE_DIR = '/_import/ingredient/archive/';
    private const IMPORT_FILENAME = 'ingredient.csv';

    public function __construct(
        private readonly string $projectDir,
        private readonly EntityManagerInterface $entityManager,
        private readonly ImporterService $importerService,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function import(): bool
    {
        $file = $this->projectDir . self::IMPORT_DIR . self::IMPORT_FILENAME;

        $this->checkFile($file);

        $importFile = new \SplFileObject($file);
        $csvReader = new CsvReader($importFile, ';', '"', '"');

        $csvReader->setHeaderRowNumber(0);
        $csvReader->setStrict(true);

        $ingredientImportDoctrineWriter = $this->IngredientImportDoctrineWriter($this->entityManager);
        $ingredientImportWriterStep = $this->IngredientImportWriter($this->entityManager, $this->importerService);


        $workflow = new Workflow($csvReader);

        $workflow
            ->setSkipItemOnFailure(true)
            ->addWriter($ingredientImportDoctrineWriter)
            ->addStep($ingredientImportWriterStep)
        ;

        $this->entityManager->beginTransaction();

        try {
            $result = $workflow->process();
            $this->entityManager->commit();
            rename($file, $this->projectDir . self::ARCHIVE_DIR . self::IMPORT_FILENAME);

            $exceptions = $result->getExceptions();

            if (!empty($exceptions)) {
                $html = '<ul>';
                foreach ($exceptions as $exception) {
                    $html .= "<li>{$exception->getMessage()}</li>";
                }
                $html .= '</ul>';

                // Todo : On balance un email avec les erreurs de doublon

                return false;
            }

        } catch (Exception $exception) {
            $this->entityManager->rollback();
            rename($file, $this->projectDir . self::ERROR_DIR . self::IMPORT_FILENAME);
            throw $exception;
        }

        return true;
    }

    private function IngredientImportDoctrineWriter(EntityManagerInterface $entityManager): DoctrineWriter
    {
        $doctrineWriter = new DoctrineWriter($entityManager, Ingredient::class);
        $doctrineWriter->disableTruncate();

        return $doctrineWriter;
    }

    private function IngredientImportWriter(EntityManagerInterface $entityManager, ImporterService $importerService): Step
    {
        return new IngredientImporterWriterStep($entityManager, $importerService);
    }
}