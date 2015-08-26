<?php
namespace Centre\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;

class CentreTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql->select("centre");
        $select->columns(array("id","name","location" =>
            new Expression("AsWKT(location)"),"post_code","address","buses","tube","accebility",
            "accebility_condition","other_information"));
        $statement = $sql->prepareStatementForSqlObject($select);
        $rowset = $statement->execute();

        return $rowset;
    }

    public function getCentre($id)
    {
        $id  = (int) $id;
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql->select("centre");
        $select->where(array("id" => $id));

        $select->columns(array("id","name","location" =>
            new Expression("AsWKT(location)"),"post_code","address","buses","tube","accebility",
            "accebility_condition","other_information"));

        $statement = $sql->prepareStatementForSqlObject($select);
        $rowset = $statement->execute();



        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        $centre = new Centre();
        $centre->exchangeArray($row);

        return $centre;
    }

    public function saveCentre(Centre $centre)
    {
        $data = array(
            'name' => $centre->name,
            'location'  => (!empty($centre->location)) ? new Expression("GeomFromText('". $centre->location ."')") : null,
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
