<?php
namespace Course\Controller;

 use Application\Controller\AbstractRestfulJsonController;
 use Zend\View\Model\JsonModel;
 use Course\Model\Course;


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

        if($this->hasFilterParameters()){
            //filter results
            $results = $this->findCourses();
        } else {
            //all results
            return $this->allCourses();
        }

    }

    public function hasFilterParameters(){
        return isset($_GET["free"]) || isset($_GET["disability"]) || isset($_GET["child_care"])
            || isset($_GET["level"]) || isset($_GET["postcode"]) || isset($_GET["area"]);
    }

    private function allCourses(){
        $results = $this->getCourseTable()->fetchAll();
        $data = array();
        foreach($results as $result) {
            $data[] = $result;
        }
        return new JsonModel(array("courses" => $data));
    }
 
    public function get($id)
    {   // Action used for GET requests with resource Id
        $course = $this->getCourseTable()->getCourse($id);
        $courseData = $this->convertToJson($course);

        //TODO move to function
        $courseCentres = $this->getCourseTable()->findCourseCentres($id);
        $centresData = array();
        foreach($courseCentres as $courseCentre) {
            $centresData[] = $courseCentre["centre_id"];
        }
        $courseData["centres"] = $centresData;

        return new JsonModel(array("data" => $courseData));
    }

    private function convertToJson($course){
        $courseData = $course->getArrayCopy();
        $courseData["organization"] = $course->organization;
    }

    public function create($data)
    {   // Action used for POST requests
        $course = new Course();
        $this->setCourseData($course,$data);
        $this->getCourseTable()->saveCourse($course);
        $data['course']['id']= $course->id;
        return new JsonModel($data);
    }

    public function update($id, $data)
    {   // Action used for PUT requests
        $data['course']['id']=$id;
        $course = $this->getCourseTable()->getCourse($id);
        $this->setCourseData($course,$data);
        $this->getCourseTable()->saveCourse($course);

        return new JsonModel($data);
    }

    private function setCourseData($course,$data){
        $course->id = (!empty($data['course']['id'])) ? $data['course']['id'] : null;
        $course->name = (!empty($data['course']['name'])) ? $data['course']['name'] : null;
        $course->class_type  = (!empty($data['course']['class_type'])) ? $data['course']['class_type'] : null;
        $course->levels = (!empty($data['course']['levels'])) ? $data['course']['levels'] : null;
        $course->who_join = (!empty($data['course']['who_join'])) ? $data['course']['who_join'] : null;
        $course->how_join = (!empty($data['course']['how_join'])) ? $data['course']['how_join'] : null;
        $course->when_join  = (!empty($data['course']['when_join'])) ? $data['course']['when_join'] : null;
        $course->how_long  = (!empty($data['course']['how_long'])) ? $data['course']['how_long'] : null;
        $course->cost_free = (!empty($data['course']['cost_free'])) ? $data['course']['cost_free'] : null;
        $course->cost_condition = (!empty($data['course']['cost_condition'])) ? $data['course']['cost_condition'] : null;
        $course->times  = (!empty($data['course']['times'])) ? $data['course']['times'] : null;
        $course->documentation_required = (!empty($data['course']['documentation_required'])) ? $data['course']['documentation_required'] : null;
        $course->contact_phone = (!empty($data['course']['contact_phone'])) ? $data['course']['contact_phone'] : null;
        $course->contact_email = (!empty($data['course']['contact_email'])) ? $data['course']['contact_email'] : null;
        $course->contact_person = (!empty($data['course']['contact_person'])) ? $data['course']['contact_person'] : null;
        $course->child_care = (!empty($data['course']['child_care'])) ? $data['course']['child_care'] : null;
        $course->child_condition  = (!empty($data['course']['child_condition'])) ? $data['course']['child_condition'] : null;
        $course->organization = (!empty($data['course']['organization'])) ? $data['course']['organization'] : null;
        $course->other_information = (!empty($data['course']['other_information'])) ? $data['course']['other_information'] : null;
    }

    public function delete($id)
    {   // Action used for DELETE requests

        $this->getCourseTable()->deleteCourse($id);

        return new JsonModel(array('courses' => 'deleted'));

    }

     private function findCourses() {
         $results = $this->getCourseTable()->findCourses($_GET["free"],$_GET["disability"],$_GET["child_care"],
             $_GET["level"], $_GET["area"], $_GET["postcode"]);
         $data = array();
         foreach($results as $result) {
             $data[] = $result;
         }
         return new JsonModel(array("courses" => $data));
     }
 }
