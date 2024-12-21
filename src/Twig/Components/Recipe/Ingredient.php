<?php

namespace App\Twig\Components\Recipe;

use App\Entity\RecipesIngredients;
use Doctrine\Common\Collections\Collection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Ingredient
{
    public int $servingNumber;

    /**
     * @var Collection<int, RecipesIngredients>
     */
    public Collection $recipeIngredients;
}
