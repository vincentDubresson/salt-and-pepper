<?php

namespace App\Service;

class IngredientImporterService
{
    /**
     * @var array<string>
     */
    private array $checkedIngredientLabels = [];
    private int $insertedIngredientCount = 0;
    private int $duplicateIngredientCount = 0;

    /**
     * @return array<string>
     */
    public function getCheckedIngredientLabels(): array
    {
        return $this->checkedIngredientLabels;
    }

    public function setCheckedIngredientLabels(string $ingredientLabel): void
    {
        $this->checkedIngredientLabels[] = $ingredientLabel;
    }

    public function getInsertedIngredientCount(): int
    {
        return $this->insertedIngredientCount;
    }

    public function setInsertedIngredientCount(int $insertedIngredientCount): void
    {
        $this->insertedIngredientCount = $insertedIngredientCount;
    }

    public function getDuplicateIngredientCount(): int
    {
        return $this->duplicateIngredientCount;
    }

    public function setDuplicateIngredientCount(int $duplicateIngredientCount): void
    {
        $this->duplicateIngredientCount = $duplicateIngredientCount;
    }
}
