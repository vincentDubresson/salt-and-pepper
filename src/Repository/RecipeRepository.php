<?php

namespace App\Repository;

use App\Entity\Recipe;
use App\Repository\Trait\RepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 */
class RecipeRepository extends ServiceEntityRepository
{
    use RepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function findOneById(int $id): mixed
    {
        return $this
            ->getActiveOptimisedQb()
            ->andWhere('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getRandomRecipe(): mixed
    {
        return $this
            ->getActiveOptimisedQb()
            ->addOrderBy('RAND()')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    private function getOptimisedQb(): QueryBuilder
    {
        return $this
            ->createQueryBuilder('e')
            ->addSelect(
                'sc',
                'scc',
                'ct',
                'd',
                'c',
                'u',
                'rin',
                'rini',
                'rinu',
                'rs',
                'rim',
                'ruf',
                'rc',
                'rcu'
            )
            ->innerJoin('e.subcategory', 'sc')
            ->innerJoin('sc.category', 'scc')
            ->innerJoin('e.cookingType', 'ct')
            ->innerJoin('e.difficulty', 'd')
            ->innerJoin('e.cost', 'c')
            ->innerJoin('e.user', 'u')
            ->innerJoin('e.recipesIngredients', 'rin')
            ->innerJoin('rin.ingredient', 'rini')
            ->leftJoin('rin.unit', 'rinu')
            ->innerJoin('e.recipeSteps', 'rs')
            ->innerJoin('e.recipeImages', 'rim')
            ->leftJoin('e.recipeUserFavorites', 'ruf')
            ->leftJoin('e.recipesComments', 'rc')
            ->innerJoin('rc.user', 'rcu')
            ->addOrderBy('rin.sort', 'ASC')
            ->addOrderBy('rs.step', 'ASC')
            ->addOrderBy('rc.createdAt', 'ASC')
        ;
    }
}
