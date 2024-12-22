<?php

namespace App\Twig\Components\Recipe\Includes;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Separator
{
    public string $title;
    public ?int $count = null;
}
