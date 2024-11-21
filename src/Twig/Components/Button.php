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
            'log-in' => 'lucide:log-in',
            'sign-in' => 'lucide:user-round-plus',
            'send' => 'lucide:send',
            'update' => 'radix-icons:update',
            'log-out' => 'lucide:log-out',
            default => 'lucide:circle',
        };
    }
}
