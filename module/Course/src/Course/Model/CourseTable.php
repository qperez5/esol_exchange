<?php
namespace Course\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class CourseTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getCourse($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function findCourses($free, $disability, $child_care, $level, $area, $postcode){
        $where = new Where();

        if(isset($free)){
            if($free == 'true'){
                $where->in("cost_free",array("y","c"));
            } else {
                $where->equalTo("cost_free","n");
            }
        }

        if(isset($disability)){
            if($disability == 'true'){
                $where->in("accebility",array("y","c"));
            } else {
                $where->equalTo("accebility","n");
            }
        }

        if(isset($child_care)){
            if($child_care == 'true'){
                $where->in("child_care",array("y","c"));
            } else {
                $where->equalTo("child_care","n");
            }
        }

        //TODO terminar con el resto de los filtros de busqueda

        $rowset = $this->tableGateway->select($where);
        return $rowset;
    }

    public function findCourseCentres($courseId){
        $courseCentreTable = new TableGateway('course_centre', $this->tableGateway->getAdapter());
        $rowset = $courseCentreTable->select(array('course_id' => $courseId));

        return $rowset;
    }

    public function saveCourse(Course $course,array $centres)
    {
        $data = array(
            'name' => $course->name,
            'class_type' => $course->class_type,
            'levels'  => $course->levels,
            'who_join'  => $course->who_join,
            'how_join' => $course->how_join,
            'when_join'  => $course->when_join,
            'how_long' => $course->how_long,
            'cost_free'  => $course->cost_free,
            'cost_condition' => $course->cost_condition,
            'times'  => $course->times,
            'documentation_required' => $course->documentation_required,
            'contact_phone'  => $course->contact_phone,
            'contact_email' => $course->contact_email,
            'contact_person'  => $course->contact_person,
            'child_care' => $course->child_care,
            'child_condition'  => $course->child_condition,
            'organization_id' => $course->organization_id,
            'other_information' => $course->other_information,
        );

        $id = (int) $course->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $course->id = $this->tableGateway->getLastInsertValue();
        } else {
            if ($this->getCourse($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Course id does not exist');
            }
        }

        $this->saveCourseCentres($course,$centres);
    }

    private function saveCourseCentres(Course $course,array $centres){
        if(!empty($centres)){
            try {
                $this->beginTransaction();
                $sql = new Sql($this->tableGateway->getAdapter());

                //borrar relaciones antiguas entre cursos y centros
                //delete from course_centre where course_id = :idCurso
                $delete = $sql->delete("course_centre");
                $delete->where(array("course_id" => $course->id));
                $statement = $sql->prepareStatementForSqlObject($delete);
                $statement->execute();

                //crear nuevas relaciones entre cursos y centros
                foreach ($centres as $centreId) {
                    //insert into course_centre values (:cursoId,:centroId)
                    $insert = $sql->insert("course_centre");
                    $insert->values(array("course_id" => $course->id, "centre_id" => $centreId));
                    $statement = $sql->prepareStatementForSqlObject($insert);
                    $statement->execute();
                }
                $this->commitTransaction();
            } catch (Exception $e) {
                $this->rollbackTransaction();
            }
        }
    }

    public function deleteCourse($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }

    private function beginTransaction()
    {
        $this->getConnection()->beginTransaction();
    }

    private function commitTransaction()
    {
        $this->getConnection()->commit();
    }

    private function rollbackTransaction()
    {
        $this->getConnection()->rollback();
    }

    /**
     * @return \Zend\Db\Adapter\Driver\ConnectionInterface
     */
    private function getConnection()
    {
        return $this->tableGateway->getAdapter()->getDriver()->getConnection();
    }
}
?>
