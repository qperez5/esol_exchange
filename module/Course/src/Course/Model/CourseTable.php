<?php
namespace Course\Model;

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

    public function saveCourse(Course $course)
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
            'cost_condition' => $course->cost_free,
            'times'  => $course->times,
            'documentation_required' => $course->documentation_required,
            'contact_phone'  => $course->contact_phone,
            'contact_email' => $course->contact_email,
            'contact_person'  => $course->contact_person,
            'child_care' => $course->child_care,
            'child_care_condition'  => $course->child_care_condition,
            'organization_id' => $course->organization_id,
            'other_information' => $course->other_information,
        );

        $id = (int) $course->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCourse($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Course id does not exist');
            }
        }
    }

    public function deleteCourse($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}
?>
