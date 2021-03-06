<?php
namespace Course\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class CourseTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select(function(Select $select){
            $select->order('name ASC');
        });
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

    public function findCourses($free, $disability, $child_care, $lat, $lng){
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql->select();

        $select->from(array("co" => "course"))
            ->join(array("cc"=>"course_centre"),"co.id = cc.course_id")
            ->join(array("ce"=>"centre"),"ce.id = cc.centre_id",
                array("centre_id" => "id",
                      "centreName" => "name",
                      "location"=>new Expression("AsWKT(location)"),
                      "post_code",
                      "address",
                      "buses",
                      "tube",
                      "accebility",
                      "accebility_condition",
                      "other_information"));

        //especificar las columnas que queremos en el resultados de las consultas.
        $select->columns(array(
            "id",
            "courseName" => "name",
            "class_type",
            "levels",
            "who_join",
            "how_join",
            "when_join",
            "how_long",
            "cost_free",
            "cost_condition",
            "times",
            "documentation_required",
            "contact_phone",
            "contact_email",
            "contact_person",
            "child_care",
            "child_condition",
            "organization_id",
            "other_information"));

        $where = new Where();
        //TODO terminar de poner prefijos a las tablas
        if(isset($free)){
            if($free == 'Yes'){
                $where->in("co.cost_free",array("y","c"));
            } else if($free == 'No')  {
                $where->equalTo("co.cost_free","n");
            }
        }

        if(isset($disability)){
            if($disability == 'Yes'){
                $where->in("ce.accebility",array("y","c"));
            } else if($disability == 'No') {
                $where->equalTo("ce.accebility","n");
            }
        }

        if(isset($child_care)){
            if($child_care == 'Yes'){
                $where->in("co.child_care",array("y","c"));
            } else if($child_care == 'No') {
                $where->equalTo("co.child_care","n");
            }
        }

        //hacemos busquedas en 3km a la redonda, se puede convertir en un parametro
        $R = 6371;//radio de la tierra en km
        if(isset($lat) && isset($lng)){
            $maxLat = $lat + rad2deg(1.5 / $R);
            $minLat = $lat - rad2deg(1.5 / $R);

            $maxLng = $lng + rad2deg(1.5/$R/cos(deg2rad($lat)));
            $minLng = $lng - rad2deg(1.5/$R/cos(deg2rad($lat)));

            $where->between(new Expression("X(ce.location)"),$minLat,$maxLat);
            $where->between(new Expression("y(ce.location)"),$minLng,$maxLng);
        }

        //TODO terminar con el resto de los filtros de busqueda

        $select->where($where);

        $statement = $sql->prepareStatementForSqlObject($select);
        $rowset = $statement->execute();

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

        try {
            $this->beginTransaction();
            $sql = new Sql($this->tableGateway->getAdapter());

            //borrar relaciones antiguas entre cursos y centros
            //delete from course_centre where course_id = :idCurso
            $delete = $sql->delete("course_centre");
            $delete->where(array("course_id" => $id));
            $statement = $sql->prepareStatementForSqlObject($delete);
            $statement->execute();

            $this->tableGateway->delete(array('id' => (int)$id));
            $this->commitTransaction();
        } catch (Exception $e) {
            $this->rollbackTransaction();
        }
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
