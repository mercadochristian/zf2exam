<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/29/2016
 * Time: 5:07 PM
 */

namespace Customer\Form;


use Zend\Form\Form;

class RegistrationForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('register');

        $this->add(array(
            'name' => 'txtRegEmail',
            'type' => 'email',
            'options' => array(
                'label' => 'Email Address: '
            )
        ));

        $this->add(array(
            'name' => 'txtRegPass',
            'type' => 'password',
            'options' => array(
                'label' => 'Password: '
            )
        ));

        $this->add(array(
            'name' => 'txtConfirm',
            'type' => 'password',
            'options' => array(
                'label' => 'Confirm Password: '
            )
        ));

        $this->add(array(
            'name' => 'txtCompanyName',
            'type' => 'text',
            'options' => array(
                'label' => 'Company Name: '
            )
        ));

        $this->add(array(
            'name' => 'txtFName',
            'type' => 'text',
            'options' => array(
                'label' => 'First Name: '
            )
        ));

        $this->add(array(
            'name' => 'txtLName',
            'type' => 'text',
            'options' => array(
                'label' => 'Last Name: '
            )
        ));

        $this->add(array(
            'name' => 'btnRegister',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Register',
                'id' => 'btnRegister',
            ),
        ));
    }
}