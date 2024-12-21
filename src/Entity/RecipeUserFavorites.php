<?php

namespace App\Entity;

use App\Entity\Trait\TimestampableTrait;
use App\Repository\RecipeUserFavoritesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeUserFavoritesRepository::class)]
#[ORM\HasLifecycleCallbacks]
class RecipeUserFavorites
{
    use TimestampableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recipeUserFavorites')]
    #[ORM\JoinColumn(nullable: false)]
    private Recipe $recipe;

    #[ORM\ManyToOne(inversedBy: 'recipeUserFavorites')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
