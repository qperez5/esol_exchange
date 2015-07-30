<?php
namespace Application\Controller;

 use Application\Controller\AbstractController;
 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;


 class ApplicationController extends AbstractActionController {
	
    public function indexAction()
    {

        $view = new ViewModel(array(
            'message' => 'Hello world',
        ));

        return $view;
    }
}
