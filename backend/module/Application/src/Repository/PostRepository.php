<?php
namespace Application\Repository;

use Application\Model\Post;
use Doctrine\ORM\EntityRepository;

/**
 * Project Repository
 */
class PostRepository extends EntityRepository
{
    /**
     * @return Post[]
     */
    public function loadAllPostsWithCommentsLongerThan6Chars(): array
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p,c');
        $qb->leftJoin('p.comments', 'c');
        $qb->where('length(c.content) > 6');

        return $qb->getQuery()->getResult();
    }
}
