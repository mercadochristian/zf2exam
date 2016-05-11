<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/29/2016
 * Time: 11:41 AM
 */

namespace Customer\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('frmLogin');

        $this->add(array(
            'name' => 'customer_id',
            'type' => 'Hidden'
        ));

        $this->add(array(
            'name' => 'login',
            'type' => 'Hidden',
            'attributes' => array(
                'value' => 'login'
            )
        ));

        $this->add(array(
            'name' => 'txtEmail',
            'type' => 'email',
            'options' => array(
                'label' => 'Email Address: '
            ),
            'attributes' => array(
                //'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'txtPass',
            'type' => 'password',
            'options' => array(
                'label' => 'Password: '
            ),
            'attributes' => array(
                //'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'btnLogin',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Log In',
                'id' => 'btnLogin',
                //'class' => 'btn btn-primary'
            ),
        ));
    }
}