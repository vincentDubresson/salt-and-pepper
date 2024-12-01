<?php

namespace App\Entity;

use App\Repository\RecipeImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Table(name: '`recipe_image`')]
#[ORM\Entity(repositoryClass: RecipeImageRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class RecipeImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'image', fileNameProperty: 'imageName')]
    #[Assert\File(
        maxSize: '5M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le titre ne peut pas dépasser 255 caractères.',
    )]
    #[Assert\NoSuspiciousCharacters]
    private ?string $title = null;

    #[ORM\Column(type: Types::FLOAT, scale: 2)]
    #[Assert\Positive(message: 'Le tri doit est positif.')]
    private float $sort;

    #[ORM\ManyToOne(targetEntity: Recipe::class, inversedBy: 'recipeImages')]
    #[ORM\JoinColumn(name: 'recipe_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Recipe $recipe;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->getRecipe()->setUpdatedAt(new \DateTime());
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getRecipe(): Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(Recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }
}
