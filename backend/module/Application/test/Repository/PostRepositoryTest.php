<?php

namespace ApplicationTest\Repository;

use Application\Model\Post;
use Application\Repository\PostRepository;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Tests\Functional\Bundle\TestBundle\DependencyInjection\TestExtension;
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

        $this->loadFixtures(__DIR__ . '/Fixtures');

        parent::setUp();
    }

    /**
     * Truncates the Database and loads Fixtures from Fixture Path
     *
     * @param $path
     *
     * @return void
     */
    public function loadFixtures($path) : void
    {
        /** @var EntityManager $em */
        $em = $this->getApplicationServiceLocator()->get(EntityManager::class);
        $em->getConnection()->exec('SET foreign_key_checks = 0');
        $loader = new Loader();
        $loader->loadFromDirectory($path);
        $purger = new ORMPurger($em);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($loader->getFixtures());
        $em->getConnection()->exec('SET foreign_key_checks = 1');
    }

    /**
     * Tests if finds all gives us some Entities
     *
     * @return void
     */
    public function testFindAll() : void
    {
        /** @var EntityManager $em */
        $em = $this->getApplicationServiceLocator()->get(EntityManager::class);
        $postRepository = $em->getRepository(Post::class);
        static::assertNotEmpty($postRepository->findAll());
    }

    /**
     * Tests if the Name of First Post is as Expected
     *
     * @return void
     */
    public function testFindFist() : void
    {
        /** @var EntityManager $em */
        $em = $this->getApplicationServiceLocator()->get(EntityManager::class);
        $postRepository = $em->getRepository(Post::class);
        /** @var Post $post */
        $post = $postRepository->find(1);
        static::assertNotNull($post);
        static::assertEquals('Test 1', $post->getName());
    }

    public function testLoadAllPostsWithCommentsLongerThan4Chars()
    {
         /** @var EntityManager $em */
        $em = $this->getApplicationServiceLocator()->get(EntityManager::class);
        /** @var PostRepository $postRepository */
        $postRepository = $em->getRepository(Post::class);
        /** @var Post $post */
        $posts = $postRepository->loadAllPostsWithCommentsLongerThan6Chars();
        static::assertNotEmpty($posts);
        $firstPost = reset($posts);
        static::assertEquals(1, $firstPost->getComments()->count());
        /** @var Post $post */
        $post = $em->find(Post::class, 1);
        static::assertEquals(1, $post->getComments()->count());
        $em->clear();
        $post = $em->find(Post::class, 1);
        static::assertEquals(15, $post->getComments()->count());
    }
}
