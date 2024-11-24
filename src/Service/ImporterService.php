<?php

namespace App\Service;

class ImporterService
{
    private array $checkedIngredientLabels = [];

    public function getCheckedIngredientLabels(): array
    {
        return $this->checkedIngredientLabels;
    }

    public function setCheckedIngredientLabels(string $checkedIngredientLabel): void
    {
        $this->checkedIngredientLabels[] = $checkedIngredientLabel;
    }
}