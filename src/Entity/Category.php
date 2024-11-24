<?php

namespace App\Entity;

use App\Entity\Trait\SluggableTrait;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: '`category`')]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Category
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
     * @var Collection<int, Subcategory>
     */
    #[ORM\OneToMany(targetEntity: Subcategory::class, mappedBy: 'category')]
    private Collection $subcategories;

    public function __construct()
    {
        $this->subcategories = new ArrayCollection();
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
     * @return Collection<int, Subcategory>
     */
    public function getSubcategories(): Collection
    {
        return $this->subcategories;
    }

    /*
     * Cela ne devrait jamais arriver.
     * Todo : Supprimer après avoir été sûr.
     */
    //    public function addSubcategory(Subcategory $subcategory): static
    //    {
    //        if (!$this->subcategories->contains($subcategory)) {
    //            $this->subcategories->add($subcategory);
    //            $subcategory->setCategory($this);
    //        }
    //
    //        return $this;
    //    }
    //
    //    public function removeSubcategory(Subcategory $subcategory): static
    //    {
    //        if ($this->subcategories->removeElement($subcategory)) {
    //            // set the owning side to null (unless already changed)
    //            if ($subcategory->getCategory() === $this) {
    //                $subcategory->setCategory(null);
    //            }
    //        }
    //
    //        return $this;
    //    }
}
