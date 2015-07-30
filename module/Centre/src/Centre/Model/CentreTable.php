<?php
namespace Centre\Model;

 use Zend\Db\TableGateway\TableGateway;

 class CentreTable
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

     public function getCentre($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveCentre(Centre $centre)
     {
         $data = array(
             'name' => $centre->name,
	     'location'  => $centre->location,
	     'post_code' => $centre->post_code,
             'address'  => $centre->address,
	     'buses'  => $centre->buses,
	     'tube' => $centre->tube,
             'accebility'  => $centre->accebility,
	     'accebility_condition' => $centre->accebility_condition,
             'other_information' => $centre->other_information,
           );

         $id = (int) $centre->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getCentre($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Centre id does not exist');
             }
         }
     }

     public function deleteCentre($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
?>
