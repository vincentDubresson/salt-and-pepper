<?php

namespace App\Repository;

use App\Entity\Recipe;
use App\Entity\RecipeUserFavorites;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeUserFavorites>
 */
class RecipeUserFavoritesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeUserFavorites::class);
    }

    public function addNew(User $user, Recipe $recipe): void
    {
        $recipeFavorite = (new RecipeUserFavorites())
            ->setUser($user)
            ->setRecipe($recipe)
        ;

        $this->getEntityManager()->persist($recipeFavorite);
        $this->getEntityManager()->flush();
    }

    public function remove(RecipeUserFavorites $recipeFavorite): void
    {
        $this->getEntityManager()->remove($recipeFavorite);
        $this->getEntityManager()->flush();
    }
}
