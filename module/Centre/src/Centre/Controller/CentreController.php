<?php
namespace Centre\Controller;

 use Centre\Controller\AbstractRestfulController;
 use Centre\Model\Centre;
 use Zend\View\Model\JsonModel;


 class CentreController extends AbstractRestfulJsonController

{	
	protected $centreTable;


     public function getCentreTable()
     {
         if (!$this->centreTable) {
             $sm = $this->getServiceLocator();
             $this->centreTable = $sm->get('Centre\Model\CentreTable');
         }
         return $this->centreTable;
     }

    public function getList()
    {   
	    $results = $this->getCentreTable()->fetchAll();
    	$data = array();
    	foreach($results as $result) {
        	$data[] = $result;//->getArrayCopy()
    	}
    	return new JsonModel(array("centres" => $data));
    }
 
    public function get($id)
    {   // Action used for GET requests with resource Id
         $centre = $this->getCentreTable()->getCentre($id);

        return new JsonModel(array("data" => $centre));
    }

    public function create($data)
    {   // Action used for POST requests
        $centre = new Centre();
        $centre->exchangeArray($data['centre']);
        $this->getCentreTable()->saveCentre($centre);
        $data['centre']['id']= $centre->id;
        return new JsonModel($data);
    }

    public function update($id, $data)
    {   // Action used for PUT requests
        $data['centre']['id']=$id;
        $centre = $this->getCentreTable()->getCentre($id);
        $centre->exchangeArray($data['centre']);
        $this->getCentreTable()->saveCentre($centre);

        return new JsonModel($data);
    }

    public function delete($id)
    {   // Action used for DELETE requests

        $this->getCentreTable()->deleteCentre($id);

        return new JsonModel(array('centres' => 'deleted'));

    }
}
