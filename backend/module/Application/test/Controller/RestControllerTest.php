<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ApplicationTest\Controller;

use Application\Controller\RestController;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class RestControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        $this->loadFixtures(__DIR__ . '/Fixtures');

        parent::setUp();
    }

    public function testGetReturnsJsonAsResult()
    {
        $this->dispatch('/posts', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(RestController::class);
        $this->assertControllerClass('RestController');
        $this->assertMatchedRouteName('rest');
        $this->assertEquals(json_encode(
                [
                    'posts'=>[
                        [
                            'name'=>'Controller Test 1',
                            'description'=>'Controller Test Post 1'
                        ]
                    ]
                ]
            ),
            $this->getResponse()->getContent()
        );
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
}
