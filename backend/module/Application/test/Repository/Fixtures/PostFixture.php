<?php
namespace ApplicationTest\Repository\Fixtures;

use Application\Model\Post;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class FaceFixture extends AbstractFixture //implements DependentFixtureInterface
{
    /**
     * Loads a Test Post Object
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $post = new Post();
        $post->setName('Test 1');
        $post->setDescription('Test Post 1');
        $manager->persist($post);
        $manager->flush();
    }

    /**
     * If this Fixture depends on other Fixtures i could be defined here.
     *
     * @return array
    public function getDependencies()
    {
        return [];
    }
    */
}