<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Alert
{
    public string $type = 'success';
    public string $message;

    public function getIcon(): string
    {
        return match ($this->type) {
            'information' => 'lucide:info',
            'success' => 'lucide:circle-check',
            'caution' => 'lucide:circle-alert',
            'error' => 'lucide:circle-x',
            default => 'lucide:circle',
        };
    }
}
