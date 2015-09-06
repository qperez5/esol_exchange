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
            return $results;
        } else {
            //all results
            return $this->allCourses();
        }

    }

    public function hasFilterParameters(){
        return isset($_GET["free"]) || isset($_GET["disability"]) || isset($_GET["child_care"])
            || isset($_GET["level"]) || isset($_GET["postcode"]) || isset($_GET["area"])
            || isset($_GET["lat"]) || isset($_GET["lon"]);
    }

    private function allCourses(){
        $results = $this->getCourseTable()->fetchAll();
        $data = array();
        foreach($results as $result) {
            $data[] = $this->convertToJson($result);
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

        return new JsonModel(array("course" => $courseData));
    }

    private function convertToJson(Course $course){
        $courseData = array();
        $courseData["id"] = $course->id;
        $courseData["name"] = $course->name;
        $courseData["class_type"] = $course->class_type;
        $courseData["levels"] = $course->levels;
        $courseData["who_join"] = $course->who_join;
        $courseData["how_join"] = $course->how_join;
        $courseData["when_join"] = $course->when_join;
        $courseData["how_long"] = $course->how_long;
        $courseData["cost_free"] = $course->cost_free;
        $courseData["cost_condition"] = $course->cost_condition;
        $courseData["times"] = $course->times;
        $courseData["documentation_required"] = $course->documentation_required;
        $courseData["contact_phone"] = $course->contact_phone;
        $courseData["contact_email"] = $course->contact_email;
        $courseData["contact_person"] = $course->contact_person;
        $courseData["child_care"] = $course->child_care;
        $courseData["child_condition"] = $course->child_condition;
        $courseData["other_information"] = $course->other_information;
        $courseData["organization"] = $course->organization_id;

        return $courseData;
    }

    private function extractCourseJson(array $resultRow){
        $courseData = array();
        $courseData["id"] = $resultRow["id"];
        $courseData["name"] = $resultRow["name"];
        $courseData["class_type"] = $resultRow["class_type"];
        $courseData["levels"] = $resultRow["levels"];
        $courseData["who_join"] = $resultRow["who_join"];
        $courseData["how_join"] = $resultRow["how_join"];
        $courseData["when_join"] = $resultRow["when_join"];
        $courseData["how_long"] = $resultRow["how_long"];
        $courseData["cost_free"] = $resultRow["cost_free"];
        $courseData["cost_condition"] = $resultRow["cost_condition"];
        $courseData["times"] = $resultRow["times"];
        $courseData["documentation_required"] = $resultRow["documentation_required"];
        $courseData["contact_phone"] = $resultRow["contact_phone"];
        $courseData["contact_email"] = $resultRow["contact_email"];
        $courseData["contact_person"] = $resultRow["contact_person"];
        $courseData["child_care"] = $resultRow["child_care"];
        $courseData["child_condition"] = $resultRow["child_condition"];
        $courseData["other_information"] = $resultRow["other_information"];
        $courseData["organization"] = $resultRow["organization_id"];
        $courseData["centres"] = array();
        return $courseData;
    }

    private function extractCentreJson(array $resultRow){
        //TODO implementar
        $centreData = array();
        $centreData["id"] = $resultRow["centre_id"];
        $centreData["name"] = $resultRow["name"];
        $centreData["location"] = $resultRow["location"];
        $centreData["post_code"] = $resultRow["post_code"];
        $centreData["address"] = $resultRow["address"];
        $centreData["buses"] = $resultRow["buses"];
        $centreData["tube"] = $resultRow["tube"];
        $centreData["accebility"] = $resultRow["accebility"];
        $centreData["accebility_condition"] = $resultRow["accebility_condition"];
        $centreData["other_information"] = $resultRow["other_information"];

        return $centreData;
    }

    public function create($data)
    {   // Action used for POST requests
        $course = new Course();
        $this->setCourseData($course,$data);
        $this->getCourseTable()->saveCourse($course, $data["course"]["centres"]);
        $data['course']['id']= $course->id;
        return new JsonModel($data);
    }

    public function update($id, $data)
    {   // Action used for PUT requests
        $data['course']['id']=$id;
        $course = $this->getCourseTable()->getCourse($id);
        $this->setCourseData($course,$data);
        $this->getCourseTable()->saveCourse($course, $data["course"]["centres"]);

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
        $course->organization_id = (!empty($data['course']['organization'])) ? $data['course']['organization'] : null;
        $course->other_information = (!empty($data['course']['other_information'])) ? $data['course']['other_information'] : null;
    }

    public function delete($id)
    {   // Action used for DELETE requests
        $this->getCourseTable()->deleteCourse($id);
        return new JsonModel(array('courses' => 'deleted'));
    }

     private function findCourses() {
         $results = $this->getCourseTable()->findCourses(
             $_GET["free"],$_GET["disability"],$_GET["child_care"],
             $_GET["lat"], $_GET["lng"]
             //,$_GET["level"], $_GET["area"], $_GET["postcode"]
         );
         $courses = array();
         $coursesMap = array();
         $centres = array();
         $centresMap = array();

         foreach($results as $result) {
             $courseId = $result["id"];
             if(!array_key_exists($courseId,$coursesMap)){
                 $coursesMap[$courseId] = $this->extractCourseJson($result);
             }
             $centreId = $result["centre_id"];
             $coursesMap[$courseId]["centres"][] = $centreId;

             if(!array_key_exists($centreId,$centresMap)){
                 $centresMap[$centreId] = $this->extractCentreJson($result);
             }
         }

         foreach($coursesMap as $course){
             $courses[] = $course;
         }

         foreach($centresMap as $centre){
             $centres[] = $centre;
         }

         return new JsonModel(array("courses" => $courses, "centres" => $centres));
     }
 }
