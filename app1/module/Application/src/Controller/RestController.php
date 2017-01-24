<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Model\Post;
use Doctrine\ORM\EntityManager;
use Zend\Hydrator\ClassMethods;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class RestController extends AbstractRestfulController
{
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var ClassMethods
     */
    private $hydrator;

    public function __construct(EntityManager $em, $hydrator)
    {
        $this->em = $em;
        $this->hydrator = $hydrator;
    }


    /**
     * Id param Name
     *
     * @var string
     */
    protected $identifierName = 'post_id';

    /**
     * Get Status
     *
     * @return JsonModel
     */
    public function getList()
    {
        $jsonModel = new JsonModel();
        $repo = $this->em->getRepository(Post::class);
        $posts = $repo->findAll();
        $data = [];
        /** @var Post $post */
        foreach ($posts as $post) {
            $postEntry = [];
            $postEntry['name'] = $post->getName();
            $postEntry['description'] = $post->getDescription();
            $data[] = $postEntry;
        }
        $jsonModel->setVariable('posts', $data);
        return $jsonModel;
    }
}
