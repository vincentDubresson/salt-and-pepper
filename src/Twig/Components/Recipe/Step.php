<?php

namespace App\Twig\Components\Recipe;

use App\Entity\RecipeStep;
use Doctrine\Common\Collections\Collection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Step
{
    /**
     * @var Collection<int, RecipeStep>
     */
    public Collection $recipeSteps;
}
