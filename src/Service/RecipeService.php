<?php

namespace App\Service;

use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;

class RecipeService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

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

    public function incrementViews(Recipe $recipe): void
    {
        $recipe->setViews($recipe->getViews() + 1);

        $this->entityManager->persist($recipe);
        $this->entityManager->flush();
    }
}
