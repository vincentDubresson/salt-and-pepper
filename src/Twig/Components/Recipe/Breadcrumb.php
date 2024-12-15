<?php

namespace App\Twig\Components\Recipe;

use App\Entity\Subcategory;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Breadcrumb
{
    // @phpstan-ignore-next-line
    private Subcategory $subcategory;

    // @phpstan-ignore-next-line
    private string $recipeTitle;
}
