<?php

namespace App\Service;

use App\Entity\Recipe;

class RecipeService
{
    public function generateRecipeReference(Recipe $recipe): string
    {
        $date = new \DateTime();
        $formattedDate = $date->format('YmdHis');

        $subCategory = $recipe->getSubcategory();
        $subCategoryId = $subCategory->getId();

        $recipeLabel = $recipe->getLabel();
        $recipeLabelInitials = $this->getRecipeLabelInitials($recipeLabel);

        return "$formattedDate-$subCategoryId-$recipeLabelInitials";
    }

    public function getRecipeLabelInitials(string $string): string
    {
        /** @var array<int, string> $words */
        $words = preg_split('/\s+/', trim($string));

        $initials = array_map(function ($word) {
            return strtoupper($word[0] ?? '');
        }, $words);

        return implode('', $initials);
    }
}
