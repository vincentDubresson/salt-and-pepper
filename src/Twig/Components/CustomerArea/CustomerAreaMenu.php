<?php

namespace App\Twig\Components\CustomerArea;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class CustomerAreaMenu
{
    /** @var array<int, array<string, string>> */
    public array $menuItems;
    public string $currentRoute;

    public function isActive(string $route): bool
    {
        return $this->currentRoute === $route;
    }
}
