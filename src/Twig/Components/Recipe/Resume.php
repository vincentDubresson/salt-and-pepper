<?php

namespace App\Twig\Components\Recipe;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Resume
{
    public \DateTimeInterface $preparationTime;
    public \DateTimeInterface $cookingTime;
    public \DateTimeInterface $restingTime;
    public int $costId;
    public int $difficultyId;

    public function getTotalTime(): string
    {
        $totalSeconds = ($this->preparationTime->format('H') * 3600 + $this->preparationTime->format('i') * 60) +
            ($this->cookingTime->format('H') * 3600 + $this->cookingTime->format('i') * 60) +
            ($this->restingTime->format('H') * 3600 + $this->restingTime->format('i') * 60);

        $hours = intdiv((int) $totalSeconds, 3600);
        $minutes = intdiv($totalSeconds % 3600, 60);

        return sprintf('%02dh%02d', $hours, $minutes);
    }
}
