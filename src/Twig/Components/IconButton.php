<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class IconButton
{
    public string $styleButtonClass;
    public string $scriptButtonClass;
    public string $styleIconClass;
    public string $iconName;
    public string $ariaLabel;
    public ?string $title = null;
    public ?string $attributes = null;
}
