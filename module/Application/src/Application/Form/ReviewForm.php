<?php
namespace Application\Form;

use Zend\Form\Form;

class ReviewForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('review');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'userId',
            'attributes' => array(
                'type'  => 'hidden',
                'value' => '2'
            ),
        ));
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Movie Title',
            ),
        ));
        $this->add(array(
            'name' => 'text',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Review Text',
            ),
        ));
        $this->add(array(
            'name' => 'rating',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Rate It',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}