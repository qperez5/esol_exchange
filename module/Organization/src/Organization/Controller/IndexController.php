<?php
namespace Organization\Controller;
use Organization\Controller\AbstractRestfulJsonController;
use Zend\View\Model\JsonModel;
class IndexController extends AbstractRestfulJsonController
{
    public function getList()
    {
        return new JsonModel(array('data' => "Welcome to the Zend Framework Organization API example"));
    }
}
