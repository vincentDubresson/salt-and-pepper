<?php

namespace App\Importer\IngredientImporter\Writer;

use App\Entity\Ingredient;
use App\Importer\Exception\ImporterException;
use App\Service\ImporterService;
use Doctrine\ORM\EntityManagerInterface;
use Port\Steps\Step;

class IngredientImporterWriterStep implements Step
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ImporterService $importerService,
    )
    {
    }

    /**
     * @inheritDoc
     * @param array<string, string> $item
     * @throws ImporterException
     */
    public function process($item, callable $next): bool
    {
        $ingredientRepository = $this->entityManager->getRepository(Ingredient::class);
        $ingredient = $ingredientRepository->findOneBy(['label' => $item['label']]);

        if ($ingredient instanceof Ingredient) {
            throw new ImporterException('L\'ingrédient "' . $item['label'] . '" est un doublon. Veuillez le supprimer de l\'import.', 409);
        }

        $checkedIngredientLabels = $this->importerService->getCheckedIngredientLabels();

        if (in_array($item['label'], $checkedIngredientLabels)) {
            throw new ImporterException('L\'ingrédient "' . $item['label'] . '" est un doublon. Veuillez le supprimer de l\'import.', 409);
        }

        $ingredient = new Ingredient();
        $ingredient->setLabel($item['label']);

        $this->entityManager->persist($ingredient);

        $this->importerService->setCheckedIngredientLabels($item['label']);

        return true;
    }
}