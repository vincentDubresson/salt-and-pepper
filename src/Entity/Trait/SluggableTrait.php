<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Adds slug to an entity. Requires that entities are
 * marked with the HasLifecycleCallbacks annotation.
 */
#[ORM\HasLifecycleCallbacks]
trait SluggableTrait
{
    #[ORM\Column(type: 'string', length: 160)]
    #[Assert\NotBlank]
    protected string $slug;

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function generateSlug(): void
    {
        $slugger = new AsciiSlugger();

        $slug = $slugger->slug(mb_strtolower($this->getSlugSource()));

        $this->slug = $slug;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    abstract protected function getSlugSource(): string;
}
