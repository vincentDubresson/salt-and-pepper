<?php

namespace App\Twig\Components\Recipe;

use App\Entity\Recipe;
use App\Entity\User;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Title
{
    public Recipe $recipe;
    public ?User $user = null;
}
