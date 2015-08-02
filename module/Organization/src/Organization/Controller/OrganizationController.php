<?php
namespace Organization\Controller;

 use Organization\Controller\AbstractRestfulController;
 use Zend\View\Model\JsonModel;
 use Zend\View\Model\ViewModel;


 class OrganizationController extends AbstractRestfulJsonController

{	
	protected $organizationTable;
	
     public function getOrganizationTable()
     {
         if (!$this->organizationTable) {
             $sm = $this->getServiceLocator();
             $this->organizationTable = $sm->get('Organization\Model\OrganizationTable');
         }
         return $this->organizationTable;
     }

    public function getList()
    {   
	    $results = $this->getOrganizationTable()->fetchAll();
    	$data = array();
    	foreach($results as $result) {
        	$data[] = $result;//->getArrayCopy()
    	}
    	return new JsonModel(array("organizations" => $data));
    }
 
    public function get($id)
    {   // Action used for GET requests with resource Id
         $organization = $this->getOrganizationTable()->getOrganization($id);

        return new JsonModel(array("organization" => $organization));
    }

    public function create($data)
    {   // Action used for POST requests
        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'New Album', 'band' => 'New Band')));
    }

    public function update($id, $data)
    {   // Action used  for PUT requests
        return new JsonModel(array('organizations' => array('id'=> 3, 'name' => 'Updated Album', 'band' => 'Updated Band')));
    }

    public function delete($id)
    {   // Action used for DELETE requests

        $this->getOrganizationTable()->deleteOrganization($id);
        return new JsonModel(array('organizations' => 'deleted'));

        //return new JsonModel(array('data' => 'album id 3 deleted'));
    }

}
    