<?php

namespace ApplicationTest\Repository;

use Application\Model\Post;
use Doctrine\ORM\EntityManager;
use Zend\Stdlib\ArrayUtils;
use \Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class PostRepositoryTest extends AbstractControllerTestCase
{
    /**
     * Setup Test
     *
     * @return void
     */
    public function setUp() : void
    {
        $configOverrides = [];
        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));
        parent::setUp();
    }

    /**
     * Tests if finds all gives us some Entities
     *
     * @return void
     */
    public function testFindAll() : void
    {
        /** @var EntityManager $em */
        $em = $this->getApplicationServiceLocator()->get('Doctrine\ORM\EntityManager');
        $postRepository = $em->getRepository(Post::class);
        $this->assertEmpty($postRepository->findAll());
    }
}
