<?php

namespace App\Twig\Components\Recipe;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Duration
{
    public \DateTimeInterface $preparationTime;
    public \DateTimeInterface $cookingTime;
    public \DateTimeInterface $restingTime;
}
