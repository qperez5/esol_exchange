<?php
namespace Centre\Model;
// Add these import statements
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

 class Centre implements InputFilterAwareInterface
 {
     public $id;
     public $name;
     public $location;
     public $post_code;
     public $address;
     public $buses;
     public $tube;
     public $accebility;
     public $accebility_condition;
     public $other_information;
    
     protected $inputFilter;

     public function exchangeArray($data)
     {
         $this->id = (!empty($data['id'])) ? $data['id'] : null;
         $this->name = (!empty($data['name'])) ? $data['name'] : null;
         $this->location  = (!empty($data['location'])) ? $data['location'] : null;
	 $this->post_code = (!empty($data['post_code'])) ? $data['post_code'] : null;
         $this->address = (!empty($data['address'])) ? $data['address'] : null;
         $this->buses  = (!empty($data['buses'])) ? $data['buses'] : null;
	 $this->tube  = (!empty($data['tube'])) ? $data['tube'] : null;
	 $this->accebility = (!empty($data['accebility'])) ? $data['accebility'] : null;
         $this->accebility_condition = (!empty($data['accebility_condition'])) ? $data['accebility_condition'] : null;
         $this->other_information  = (!empty($data['other_information'])) ? $data['other_information'] : null;

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
                 'name'     => 'address',
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
                             'max'      => 200,
                         ),
                     ),
                 ),
             ));
	     
	     $inputFilter->add(array(
                 'name'     => 'post_code',
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
                             'max'      => 9,
                         ),
                     ),
                 ),
             ));

	     $inputFilter->add(array(
                 'name'     => 'location',
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

	     $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }

 }
?>
