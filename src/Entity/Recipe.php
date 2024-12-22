<?php

namespace App\Entity;

use App\Entity\Trait\SluggableTrait;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\RecipeRepository;
use App\Validator\TimeNotZero;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: '`recipe`')]
#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_REFERENCE', fields: ['reference'])]
#[ORM\HasLifecycleCallbacks]
class Recipe
{
    use TimestampableTrait;
    use SluggableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    private string $reference = '';

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank(message: 'Le titre est obligatoire.')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le titre ne peut pas dépasser 255 caractères.',
    )]
    #[Assert\NoSuspiciousCharacters]
    private string $label;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NoSuspiciousCharacters]
    private ?string $description = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotBlank(message: 'Ce nombre est obligatoire.')]
    #[Assert\Positive(
        message: 'Ce nombre doit être positif.'
    )]
    private int $servingNumber;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message: 'La durée de préparation est obligatoire.')]
    #[TimeNotZero]
    private \DateTimeInterface $preparationTime;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message: 'La durée de cuisson est obligatoire.')]
    private \DateTimeInterface $cookingTime;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message: 'La durée de repos est obligatoire.')]
    private \DateTimeInterface $restingTime;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NoSuspiciousCharacters]
    private ?string $metaDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NoSuspiciousCharacters]
    private ?string $metaKeywords = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false)]
    private bool $enabled = false;

    #[ORM\ManyToOne(targetEntity: Subcategory::class, inversedBy: 'recipes')]
    #[ORM\JoinColumn(name: 'subcategory_id', referencedColumnName: 'id', nullable: false)]
    private Subcategory $subcategory;

    #[ORM\ManyToOne(targetEntity: CookingType::class, inversedBy: 'recipes')]
    #[ORM\JoinColumn(name: 'cooking_type_id', referencedColumnName: 'id', nullable: false)]
    private CookingType $cookingType;

    #[ORM\ManyToOne(targetEntity: Difficulty::class, inversedBy: 'recipes')]
    #[ORM\JoinColumn(name: 'difficulty_id', referencedColumnName: 'id', nullable: false)]
    private Difficulty $difficulty;

    #[ORM\ManyToOne(targetEntity: Cost::class, inversedBy: 'recipes')]
    #[ORM\JoinColumn(name: 'cost_id', referencedColumnName: 'id', nullable: false)]
    private Cost $cost;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'recipes')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: true)]
    private ?User $user = null;

    /**
     * @var Collection<int, RecipesIngredients>
     */
    #[ORM\OneToMany(targetEntity: RecipesIngredients::class, mappedBy: 'recipe', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Assert\Count(
        min: 1, minMessage: 'Vous devez renseigner au moins un ingrédient.'
    )]
    private Collection $recipesIngredients;

    /**
     * @var Collection<int, RecipeStep>
     */
    #[ORM\OneToMany(targetEntity: RecipeStep::class, mappedBy: 'recipe', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Assert\Count(
        min: 1, minMessage: 'Vous devez renseigner au moins une étape.'
    )]
    private Collection $recipeSteps;

    /**
     * @var Collection<int, RecipeImage>
     */
    #[ORM\OneToMany(targetEntity: RecipeImage::class, mappedBy: 'recipe', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $recipeImages;

    /**
     * @var Collection<int, RecipeUserFavorites>
     */
    #[ORM\OneToMany(targetEntity: RecipeUserFavorites::class, mappedBy: 'recipe', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $recipeUserFavorites;

    private int $countRecipeUserFavorites = 0;

    /**
     * @var Collection<int, RecipesComments>
     */
    #[ORM\OneToMany(targetEntity: RecipesComments::class, mappedBy: 'recipe', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $recipesComments;

    private int $countRecipesComments = 0;

    #[ORM\Column(type: Types::INTEGER)]
    private int $views = 0;

    public function __construct()
    {
        $this->recipesIngredients = new ArrayCollection();
        $this->recipeSteps = new ArrayCollection();
        $this->recipeImages = new ArrayCollection();
        $this->recipeUserFavorites = new ArrayCollection();
        $this->recipesComments = new ArrayCollection();
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

    public function getReference(): string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getServingNumber(): int
    {
        return $this->servingNumber;
    }

    public function setServingNumber(int $servingNumber): static
    {
        $this->servingNumber = $servingNumber;

        return $this;
    }

    public function getPreparationTime(): \DateTimeInterface
    {
        return $this->preparationTime;
    }

    public function setPreparationTime(\DateTimeInterface $preparationTime): static
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    public function getCookingTime(): \DateTimeInterface
    {
        return $this->cookingTime;
    }

    public function setCookingTime(\DateTimeInterface $cookingTime): static
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getRestingTime(): \DateTimeInterface
    {
        return $this->restingTime;
    }

    public function setRestingTime(\DateTimeInterface $restingTime): static
    {
        $this->restingTime = $restingTime;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): static
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function getMetaKeywords(): ?string
    {
        return $this->metaKeywords;
    }

    public function setMetaKeywords(?string $metaKeywords): static
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getSubcategory(): Subcategory
    {
        return $this->subcategory;
    }

    public function setSubcategory(Subcategory $subcategory): static
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    public function getCookingType(): CookingType
    {
        return $this->cookingType;
    }

    public function setCookingType(CookingType $cookingType): static
    {
        $this->cookingType = $cookingType;

        return $this;
    }

    public function getDifficulty(): Difficulty
    {
        return $this->difficulty;
    }

    public function setDifficulty(Difficulty $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getCost(): Cost
    {
        return $this->cost;
    }

    public function setCost(Cost $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, RecipesIngredients>
     */
    public function getRecipesIngredients(): Collection
    {
        return $this->recipesIngredients;
    }

    public function addRecipesIngredient(RecipesIngredients $recipesIngredient): static
    {
        if (!$this->recipesIngredients->contains($recipesIngredient)) {
            $this->recipesIngredients->add($recipesIngredient);
            $recipesIngredient->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipesIngredient(RecipesIngredients $recipesIngredient): static
    {
        $this->recipesIngredients->removeElement($recipesIngredient);

        return $this;
    }

    /**
     * @return Collection<int, RecipeStep>
     */
    public function getRecipeSteps(): Collection
    {
        return $this->recipeSteps;
    }

    public function addRecipeStep(RecipeStep $recipeStep): static
    {
        if (!$this->recipeSteps->contains($recipeStep)) {
            $this->recipeSteps->add($recipeStep);
            $recipeStep->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeStep(RecipeStep $recipeStep): static
    {
        $this->recipeSteps->removeElement($recipeStep);

        return $this;
    }

    /**
     * @return Collection<int, RecipeImage>
     */
    public function getRecipeImages(): Collection
    {
        return $this->recipeImages;
    }

    public function addRecipeImage(RecipeImage $recipeImage): static
    {
        if (!$this->recipeImages->contains($recipeImage)) {
            $this->recipeImages->add($recipeImage);
            $recipeImage->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeImage(RecipeImage $recipeImage): static
    {
        $this->recipeImages->removeElement($recipeImage);

        return $this;
    }

    /**
     * @return Collection<int, RecipeUserFavorites>
     */
    public function getRecipeUserFavorites(): Collection
    {
        return $this->recipeUserFavorites;
    }

    public function addRecipeUserFavorite(RecipeUserFavorites $recipeUserFavorite): static
    {
        if (!$this->recipeUserFavorites->contains($recipeUserFavorite)) {
            $this->recipeUserFavorites->add($recipeUserFavorite);
            $recipeUserFavorite->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeUserFavorite(RecipeUserFavorites $recipeUserFavorite): static
    {
        $this->recipeUserFavorites->removeElement($recipeUserFavorite);

        return $this;
    }

    /**
     * @return Collection<int, RecipesComments>
     */
    public function getRecipesComments(): Collection
    {
        return $this->recipesComments;
    }

    public function addRecipesComment(RecipesComments $recipesComment): static
    {
        if (!$this->recipesComments->contains($recipesComment)) {
            $this->recipesComments->add($recipesComment);
            $recipesComment->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipesComment(RecipesComments $recipesComment): static
    {
        $this->recipesComments->removeElement($recipesComment);

        return $this;
    }

    public function getCountRecipeUserFavorites(): int
    {
        return count($this->recipeUserFavorites);
    }

    public function getCountRecipesComments(): int
    {
        $count = 0;

        foreach ($this->recipesComments as $recipeComment) {
            if ($recipeComment->isEnabled()) {
                ++$count;
            }
        }

        return $count;
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function setViews(int $views): static
    {
        $this->views = $views;

        return $this;
    }
}
