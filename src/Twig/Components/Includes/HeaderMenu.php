<?php

namespace App\Twig\Components\Includes;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class HeaderMenu
{
    public string $styleClass;
    public string $scriptClass;
    public string $role;
    /** @var array<int, array<string, string>> */
    public array $content;
}
