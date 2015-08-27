<?php
namespace Course\Model;
// Add these import statements
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Course implements InputFilterAwareInterface
{
    public $id;
    public $name;
    public $class_type;
    public $levels;
    public $who_join;
    public $how_join;
    public $when_join;
    public $how_long;
    public $cost_free;
    public $cost_condition;
    public $times;
    public $documentation_required;
    public $contact_phone;
    public $contact_email;
    public $contact_person;
    public $child_care;
    public $child_condition;
    public $organization_id;
    public $other_information;

    public $centres;

    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->class_type  = (!empty($data['class_type'])) ? $data['class_type'] : null;
        $this->levels = (!empty($data['levels'])) ? $data['levels'] : null;
        $this->who_join = (!empty($data['who_join'])) ? $data['who_join'] : null;
        $this->how_join = (!empty($data['how_join'])) ? $data['how_join'] : null;
        $this->when_join  = (!empty($data['when_join'])) ? $data['when_join'] : null;
        $this->how_long  = (!empty($data['how_long'])) ? $data['how_long'] : null;
        $this->cost_free = (!empty($data['cost_free'])) ? $data['cost_free'] : null;
        $this->cost_condition = (!empty($data['cost_condition'])) ? $data['cost_condition'] : null;
        $this->times  = (!empty($data['times'])) ? $data['times'] : null;
        $this->documentation_required = (!empty($data['documentation_required'])) ? $data['documentation_required'] : null;
        $this->contact_phone = (!empty($data['contact_phone'])) ? $data['contact_phone'] : null;
        $this->contact_email = (!empty($data['contact_email'])) ? $data['contact_email'] : null;
        $this->contact_person = (!empty($data['contact_person'])) ? $data['contact_person'] : null;
        $this->child_care = (!empty($data['child_care'])) ? $data['child_care'] : null;
        $this->child_condition  = (!empty($data['child_condition'])) ? $data['child_condition'] : null;
        $this->organization_id = (!empty($data['organization_id'])) ? $data['organization_id'] : null;
        $this->other_information = (!empty($data['other_information'])) ? $data['other_information'] : null;
    }

    // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'class_type',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 300,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'cost_free',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 1,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'times',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 60,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'contact_mail',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 200,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'organization',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}
?>
