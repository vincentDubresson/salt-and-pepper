<?php

namespace App\Entity;

use App\Repository\RecipesIngredientsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: '`recipes_ingredients`')]
#[ORM\Entity(repositoryClass: RecipesIngredientsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class RecipesIngredients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::FLOAT, scale: 2)]
    #[Assert\Positive(message: 'La quantité doit est positive.')]
    private float $quantity;

    #[ORM\Column(type: Types::FLOAT, scale: 2)]
    #[Assert\Positive(message: 'Le tri doit est positif.')]
    private float $sort;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Unit $unit;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Ingredient $ingredient;

    #[ORM\ManyToOne(targetEntity: Recipe::class, inversedBy: 'recipesIngredients')]
    #[ORM\JoinColumn(name: 'recipe_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Recipe $recipe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): static
    {
        $this->quantity = $quantity;

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

    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getIngredient(): Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(Ingredient $ingredient): static
    {
        $this->ingredient = $ingredient;

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
