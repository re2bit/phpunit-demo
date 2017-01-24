<?php
namespace ApplicationTest\Controller\Fixtures;

use Application\Model\Post;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PostFixture extends AbstractFixture
{
    /**
     * Loads a Test Post Object
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $post = new Post();
        $post->setName('Controller Test 1');
        $post->setDescription('Controller Test Post 1');
        $manager->persist($post);
        $manager->flush();
    }
}