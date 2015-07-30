<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Http\Response;

class AbstractRestfulJsonController extends AbstractRestfulController
{
    protected function methodNotAllowed()
    {
        $this->response->setStatusCode(405);
        throw new \Exception('Method Not Allowed');
    }

    # Override default actions as they do not return valid JsonModels
    public function create($data)
    {
        return $this->methodNotAllowed();
    }

}
