<?php

namespace App\Repository;

use App\Entity\Recipe;
use App\Entity\RecipesComments;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipesComments>
 */
class RecipesCommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipesComments::class);
    }

    public function addRecipeComment(Recipe $recipe, User $user, string $comment): void
    {
        $recipeComment = (new RecipesComments())
            ->setRecipe($recipe)
            ->setUser($user)
            ->setComment($comment)
            ->setEnabled(false)
        ;

        $this->getEntityManager()->persist($recipeComment);
        $this->getEntityManager()->flush();
    }
}
