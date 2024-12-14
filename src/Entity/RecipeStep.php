<?php

namespace App\Entity;

use App\Repository\RecipeStepRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: '`recipe_step`')]
#[ORM\Entity(repositoryClass: RecipeStepRepository::class)]
#[ORM\HasLifecycleCallbacks]
class RecipeStep
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\Positive(message: 'Le numéro d\'étape doit est positif.')]
    private int $step;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\NoSuspiciousCharacters]
    private string $description;

    #[ORM\ManyToOne(targetEntity: Recipe::class, inversedBy: 'recipeSteps')]
    #[ORM\JoinColumn(name: 'recipe_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Recipe $recipe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStep(): int
    {
        return $this->step;
    }

    public function setStep(int $step): static
    {
        $this->step = $step;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
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
