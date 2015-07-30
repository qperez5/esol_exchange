<?php
namespace Application\Controller;
use Application\Controller\AbstractRestfulJsonController;
use Zend\View\Model\JsonModel;
class IndexController extends AbstractRestfulJsonController
{
    public function getList()
    {
        return new JsonModel(array('data' => "Welcome to the Zend Framework Application API example"));
    }
}
