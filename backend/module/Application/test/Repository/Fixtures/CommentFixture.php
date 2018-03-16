<?php
namespace ApplicationTest\Repository\Fixtures;

use Application\Model\Comment;
use ApplicationTest\Controller\Fixtures\PostFixture;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixture extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Loads a Test Post Object
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            [ 'aaa1', 'test@test.com' ],
            [ 'aaa2', 'test@test.com' ],
            [ 'aaa3', 'test@test.com' ],
            [ 'aaa4', 'test@test.com' ],
            [ 'aaa5', 'test@test.com' ],
            [ 'aaa6', 'test@test.com' ],
            [ 'aaa7', 'test@test.com' ],
            [ 'aaa8', 'test@test.com' ],
            [ 'aaa9', 'test@test.com' ],
            [ 'aaa10', 'test@test.com' ],
            [ 'aaa11', 'test@test.com' ],
            [ 'aaa12', 'test@test.com' ],
            [ 'aaa13', 'test@test.com' ],
            [ 'aaa14', 'test@test.com' ],
            [ '1234567', 'test@test.com' ],
        ];

        $post = $this->getReference('post');

        foreach ($data as $commentData) {
            $comment = new Comment();
            $comment->setContent($commentData[0]);
            $comment->setEmail($commentData[1]);
            $comment->setPost($post);
            $manager->persist($comment);
        }

        $manager->flush();
    }

    /**
     * If this Fixture depends on other Fixtures i could be defined here.
     *
     * @return array
     */
    public function getDependencies()
    {
        return [PostFixture::class];
    }
}
