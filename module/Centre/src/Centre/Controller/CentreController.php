<?php
namespace Centre\Controller;

 use Centre\Controller\AbstractRestfulController;
 use Zend\View\Model\JsonModel;
 use Zend\View\Model\ViewModel;


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
        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'New Album', 'band' => 'New Band')));
    }

    public function update($id, $data)
    {   // Action used for PUT requests
        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'Updated Album', 'band' => 'Updated Band')));
    }

    public function delete($id)
    {   // Action used for DELETE requests

        $this->getCentreTable()->deleteCentre($id);

        return new JsonModel(array('data' => 'deleted'));

        //return new JsonModel(array('data' => 'album id 3 deleted'));
    }
}
