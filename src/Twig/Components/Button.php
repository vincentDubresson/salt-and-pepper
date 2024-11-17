<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Button
{
    public string $type;
    public string $action;
    public string $style;
    public string $content;
    public ?string $route = null;

    public function getIcon(): string
    {
        return match ($this->action) {
            'login' => 'lucide:log-in',
            'signin' => 'lucide:user-round-plus',
            default => 'lucide:circle',
        };
    }
}
