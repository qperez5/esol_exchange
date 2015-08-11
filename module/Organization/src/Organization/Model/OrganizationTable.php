<?php
namespace Organization\Model;

use Zend\Db\TableGateway\TableGateway;

class OrganizationTable
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

    public function getOrganization($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveOrganization(Organization $organization)
    {
        $data = array(
            'name' => $organization->name,
            'address'  => $organization->address,
            'post_code' => $organization->post_code,
            'contact_number'  => $organization->contact_number,
            'contact_email'  => $organization->contact_email,
            'contact_person' => $organization->contact_person,
            'contact_web'  => $organization->contact_web,
            'esol_assesment' => $organization->esol_assesment,
            'tutors_qualified'  => $organization->tutors_qualified,
            'tutors_qualified_condition' => $organization->tutors_qualified_condition,
            'courses_acreditated'  => $organization->courses_acreditated,
            'courses_acreditation_condition' => $organization->courses_acreditation_condition,
            'how_acreditated'  => $organization->how_acreditated,
            'core_curriculum' => $organization->core_curriculum,
            'core_curriculum_condition'  => $organization->core_curriculum_condition,
            'referral_system' => $organization->referral_system,
            'classes_outside_newham'  => $organization->classes_outside_newham,
            'other_information' => $organization->other_information,
        );

        $id = (int) $organization->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getOrganization($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Organization id does not exist');
            }
        }
    }

    public function deleteOrganization($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}
?>
