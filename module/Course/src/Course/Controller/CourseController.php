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
        $course = new Course();
        $course->exchangeArray($data['course']);
        $this->getCourseTable()->saveCourse($course);
        $data['course']['id']= $course->id;
        return new JsonModel($data);
    }

    public function update($id, $data)
    {   // Action used for PUT requests
        $data['course']['id']=$id;
        $course = $this->getCourseTable()->getCourse($id);
        $course->exchangeArray($data['course']);
        $this->getCourseTable()->saveCourse($course);

        return new JsonModel($data);
    }

    public function delete($id)
    {   // Action used for DELETE requests

        $this->getCourseTable()->deleteCourse($id);

        return new JsonModel(array('courses' => 'deleted'));

    }
}
