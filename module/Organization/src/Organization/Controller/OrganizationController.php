<?php
namespace Organization\Controller;

 use Organization\Controller\AbstractRestfulController;
 use Organization\Model\Organization;
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
        $organization = new Organization();
        $organization->exchangeArray($data['organization']);
        $this->getOrganizationTable()->saveOrganization($organization);
        $data['organization']['id']= $organization->id;
        return new JsonModel($data);
    }

    public function update($id, $data)
    {
        $data['organization']['id']=$id;
        $organization = $this->getOrganizationTable()->getOrganization($id);
        $organization->exchangeArray($data['organization']);
        $this->getOrganizationTable()->saveOrganization($organization);

        return new JsonModel($data);
    }

    public function delete($id)
    {   // Action used for DELETE requests

        $this->getOrganizationTable()->deleteOrganization($id);
        return new JsonModel(array('organizations' => 'deleted'));

    }

}
    