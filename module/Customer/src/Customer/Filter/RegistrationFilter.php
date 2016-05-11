<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/29/2016
 * Time: 5:12 PM
 */

namespace Customer\Filter;

use Zend\InputFilter\InputFilter;

class RegistrationFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'txtRegEmail',
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
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'txtRegPass',
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
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'txtConfirm',
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
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'txtFName',
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
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'txtLName',
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
                    ),
                ),
            ),
        ));

    }
}