<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class RestController extends AbstractRestfulController
{

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
        $jsonModel->setVariable('posts', []);
        return $jsonModel;
    }
}
