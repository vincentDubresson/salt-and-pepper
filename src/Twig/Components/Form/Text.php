<?php

namespace App\Twig\Components\Form;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Text
{
    public string $data;
    public string $label;
    public ?string $placeholder;
    public ?string $inputMode;
    public ?string $pattern;
    public ?string $autocomplete;
    public bool $autofocus = false;
}
