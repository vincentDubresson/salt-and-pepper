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
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function import(IngredientImporterService $importerService, string $file): void
    {
        $this->checkFile($file);

        if (!$this->isHeaderLabelOnly($file)) {
            throw new \RuntimeException('Le nom de la colonne est non valide.');
        }

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

            unlink($file);

            $this->entityManager->commit();
        } catch (Exception $exception) {
            $this->entityManager->rollback();
            unlink($file);

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

    private function isHeaderLabelOnly(string $file): bool
    {
        /** @var resource $handle */
        $handle = fopen($file, 'r');

        $header = fgetcsv($handle);
        fclose($handle);

        return is_array($header) && count($header) === 1 && $header[0] === 'label';
    }
}
