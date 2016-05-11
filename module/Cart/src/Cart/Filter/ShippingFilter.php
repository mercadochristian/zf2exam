<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 5/4/2016
 * Time: 3:00 PM
 */

namespace Cart\Filter;

use Zend\InputFilter\InputFilter;

class ShippingFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'txtName',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 35
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'txtAdd1',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 35
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'txtAdd2',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 35
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'txtAdd3',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 35
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'txtCity',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 35
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'txtState',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 35
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'txtCountry',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 35
                    ),
                ),
            ),
        ));
    }
}