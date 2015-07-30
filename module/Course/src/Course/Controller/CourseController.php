<?php
namespace Course\Controller;

 use Course\Controller\AbstractRestfulController;
 use Zend\View\Model\JsonModel;
 use Zend\View\Model\ViewModel;


 class CourseController extends AbstractRestfulJsonController

{	
	protected $courseTable;
	
     public function getCourseTable()
     {
         if (!$this->courseTable) {
             $sm = $this->getServiceLocator();
             $this->courseTable = $sm->get('Course\Model\CourseTable');
         }
         return $this->courseTable;
     }

    public function getList()
    {   
	    $results = $this->getCourseTable()->fetchAll();
    	$data = array();
    	foreach($results as $result) {
        	$data[] = $result;//->getArrayCopy()
    	}
    	return new JsonModel(array("courses" => $data));
    }
 
    public function get($id)
    {   // Action used for GET requests with resource Id
         $course = $this->getCourseTable()->getCourse($id);

        return new JsonModel(array("data" => $course));
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

        $this->getCourseTable()->deleteCourse($id);

        return new JsonModel(array('data' => 'deleted'));

        //return new JsonModel(array('data' => 'album id 3 deleted'));
    }
}
