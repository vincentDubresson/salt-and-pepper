<?php

namespace App\Entity;

use App\Entity\Trait\SluggableTrait;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\CostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: '`cost`')]
#[ORM\Entity(repositoryClass: CostRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Cost
{
    use TimestampableTrait;
    use SluggableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank(message: 'Le libellé est obligatoire.')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le libellé ne peut pas dépasser 255 caractères.',
    )]
    #[Assert\NoSuspiciousCharacters]
    private string $label;

    #[ORM\Column(type: Types::FLOAT, scale: 2)]
    #[Assert\Positive(message: 'Le tri doit est positif.')]
    private float $sort;

    /**
     * @var Collection<int, Recipe>
     */
    #[ORM\OneToMany(targetEntity: Recipe::class, mappedBy: 'cost', orphanRemoval: true)]
    private Collection $recipes;

    public function __construct()
    {
        $this->recipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->label;
    }

    protected function getSlugSource(): string
    {
        return $this->label;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getSort(): float
    {
        return $this->sort;
    }

    public function setSort(float $sort): static
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }
}
