<?php

namespace App\Entity;

use App\Entity\Trait\SluggableTrait;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\SubcategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: '`subcategory`')]
#[ORM\Entity(repositoryClass: SubcategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Subcategory
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

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'subcategories')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id', nullable: false)]
    private Category $category;

    /**
     * @var Collection<int, Recipe>
     */
    #[ORM\OneToMany(targetEntity: Recipe::class, mappedBy: 'subcategory')]
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

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): static
    {
        $this->category = $category;

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
