<?php
  namespace Organization\Form;

 use Zend\Form\Form;

 class OrganizationForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('organization');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Name',
             ),
         ));
         $this->add(array(
             'name' => 'address',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Address',
             ),
         ));
	 $this->add(array(
             'name' => 'post_code',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Post Code',
             ),
         ));
	 $this->add(array(
             'name' => 'contact_number',
             'type' => 'Text',
             'options' => array(
                 'label' => 'contact_number',
             ),
         ));
         $this->add(array(
             'name' => 'contact_mail',
             'type' => 'Text',
             'options' => array(
                 'label' => 'contact_mail',
             ),
         ));
	 $this->add(array(
             'name' => 'contact_person',
             'type' => 'Text',
             'options' => array(
                 'label' => 'contact_person',
             ),
         ));
	 $this->add(array(
             'name' => 'contact_web',
             'type' => 'Text',
             'options' => array(
                 'label' => 'contact_web',
             ),
         ));
         $this->add(array(
             'name' => 'esol_assesment',
             'type' => 'Text',
             'options' => array(
                 'label' => 'esol_assesment',
             ),
         ));
	 $this->add(array(
             'name' => 'tutors_qualified',
             'type' => 'Text',
             'options' => array(
                 'label' => 'tutors_qualified',
             ),
         ));
	 $this->add(array(
             'name' => 'tutors_qualified_condition',
             'type' => 'Text',
             'options' => array(
                 'label' => 'tutors_qualified_condition',
             ),
         ));
         $this->add(array(
             'name' => 'courses_acreditated',
             'type' => 'Text',
             'options' => array(
                 'label' => 'courses_acreditated',
             ),
         ));
	 $this->add(array(
             'name' => 'courses_acreditation_condition',
             'type' => 'Text',
             'options' => array(
                 'label' => 'courses_acreditation_condition',
             ),
         ));
	  $this->add(array(
             'name' => 'how_acreditated',
             'type' => 'Text',
             'options' => array(
                 'label' => 'how_acreditated',
             ),
         ));
         $this->add(array(
             'name' => 'core_curriculum',
             'type' => 'Text',
             'options' => array(
                 'label' => 'core_curriculum',
             ),
         ));
	  $this->add(array(
             'name' => 'core_curriculum_condition',
             'type' => 'Text',
             'options' => array(
                 'label' => 'core_curriculum_condition',
             ),
         ));
	  $this->add(array(
             'name' => 'referral_system',
             'type' => 'Text',
             'options' => array(
                 'label' => 'referral_system',
             ),
         ));
	 $this->add(array(
             'name' => 'classes_outside_newham',
             'type' => 'Text',
             'options' => array(
                 'label' => 'classes_outside_newham',
             ),
         ));
	 $this->add(array(
             'name' => 'other_information',
             'type' => 'Text',
             'options' => array(
                 'label' => 'other_information',
             ),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }
?>
