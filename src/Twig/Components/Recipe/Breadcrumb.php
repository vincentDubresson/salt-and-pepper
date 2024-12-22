<?php

namespace App\Twig\Components\Recipe;

use App\Entity\Subcategory;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Breadcrumb
{
    public Subcategory $subcategory;
    public string $recipeTitle;
}
