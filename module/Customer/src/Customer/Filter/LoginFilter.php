<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/29/2016
 * Time: 11:46 AM
 */

namespace Customer\Filter;
use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'txtEmail',
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
            'name' => 'txtPass',
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