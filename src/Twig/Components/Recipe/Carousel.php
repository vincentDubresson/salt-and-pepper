<?php

namespace App\Twig\Components\Recipe;

use App\Entity\RecipeImage;
use Doctrine\Common\Collections\Collection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Carousel
{
    /**
     * @var Collection<RecipeImage>
     */
    private Collection $pictures;
}
