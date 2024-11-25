<?php

namespace App\Importer\IngredientImporter\Writer;

use App\Entity\Ingredient;
use App\Importer\Exception\ImporterException;
use App\Service\IngredientImporterService;
use Doctrine\ORM\EntityManagerInterface;
use Port\Steps\Step;

class IngredientImporterWriterStep implements Step
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly IngredientImporterService $importerService,
    ) {
    }

    /**
     * @param array<string, string> $item
     *
     * @throws ImporterException
     */
    public function process($item, callable $next): bool
    {
        $checkedIngredientLabels = $this->importerService->getCheckedIngredientLabels();

        if (in_array($item['label'], $checkedIngredientLabels)) {
            $this->incrementDuplicateIngredientCount();

            return false;
        }

        $ingredientRepository = $this->entityManager->getRepository(Ingredient::class);
        $ingredient = $ingredientRepository->findOneBy(['label' => $item['label']]);

        if ($ingredient instanceof Ingredient) {
            $this->incrementDuplicateIngredientCount();

            return false;
        }

        $ingredient = new Ingredient();
        $ingredient->setLabel($item['label']);

        $this->entityManager->persist($ingredient);

        $this->importerService->setCheckedIngredientLabels($item['label']);

        $this->incrementInsertedIngredientCount();

        return true;
    }

    private function incrementDuplicateIngredientCount(): void
    {
        $duplicateIngredients = $this->importerService->getDuplicateIngredientCount();
        $this->importerService->setDuplicateIngredientCount($duplicateIngredients + 1);
    }

    private function incrementInsertedIngredientCount(): void
    {
        $insertedIngredients = $this->importerService->getInsertedIngredientCount();
        $this->importerService->setInsertedIngredientCount($insertedIngredients + 1);
    }
}
