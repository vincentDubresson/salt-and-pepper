<?php

namespace App\Importer\IngredientImporter;

use App\Entity\Ingredient;
use App\Importer\AbstractImporter;
use App\Importer\IngredientImporter\Writer\IngredientImporterWriterStep;
use App\Service\IngredientImporterService;
use Doctrine\ORM\EntityManagerInterface;
use Port\Csv\CsvReader;
use Port\Doctrine\DoctrineWriter;
use Port\Exception;
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
    ) {
    }

    public function import(IngredientImporterService $importerService): void
    {
        $file = $this->projectDir . self::IMPORT_DIR . self::IMPORT_FILENAME;

        $this->checkFile($file);

        $importFile = new \SplFileObject($file);
        $csvReader = new CsvReader($importFile, ';', '"', '"');

        $csvReader->setHeaderRowNumber(0);
        $csvReader->setStrict(true);

        $ingredientImportDoctrineWriter = $this->IngredientImportDoctrineWriter($this->entityManager);
        $ingredientImportWriterStep = $this->IngredientImportWriter($this->entityManager, $importerService);

        $workflow = new Workflow($csvReader);

        $workflow
            ->setSkipItemOnFailure(true)
            ->addWriter($ingredientImportDoctrineWriter)
            ->addStep($ingredientImportWriterStep)
        ;

        $this->entityManager->beginTransaction();

        try {
            $workflow->process();

            rename($file, $this->projectDir . self::ARCHIVE_DIR . self::IMPORT_FILENAME);

            $this->entityManager->commit();
        } catch (Exception $exception) {
            $this->entityManager->rollback();
            rename($file, $this->projectDir . self::ERROR_DIR . self::IMPORT_FILENAME);

            throw $exception;
        }
    }

    private function IngredientImportDoctrineWriter(EntityManagerInterface $entityManager): DoctrineWriter
    {
        $doctrineWriter = new DoctrineWriter($entityManager, Ingredient::class);
        $doctrineWriter->disableTruncate();

        return $doctrineWriter;
    }

    private function IngredientImportWriter(EntityManagerInterface $entityManager, IngredientImporterService $importerService): Step
    {
        return new IngredientImporterWriterStep($entityManager, $importerService);
    }
}
