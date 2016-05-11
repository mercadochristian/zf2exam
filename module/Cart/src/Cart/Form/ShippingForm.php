<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 5/4/2016
 * Time: 2:26 PM
 */

namespace Cart\Form;
use Zend\Form\Form;

class ShippingForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('shipping');

        $this->add(array(
            'name' => 'txtName',
            'type' => 'text',
            'options' => array(
                'label' => 'Name: '
            )
        ));

        $this->add(array(
            'name' => 'txtAdd1',
            'type' => 'text',
            'options' => array(
                'label' => 'Address1: '
            )
        ));

        $this->add(array(
            'name' => 'txtAdd2',
            'type' => 'text',
            'options' => array(
                'label' => 'Address2: '
            )
        ));

        $this->add(array(
            'name' => 'txtAdd3',
            'type' => 'text',
            'options' => array(
                'label' => 'Address3: '
            )
        ));

        $this->add(array(
            'name' => 'txtCity',
            'type' => 'text',
            'options' => array(
                'label' => 'City: '
            )
        ));

        $this->add(array(
            'name' => 'txtState',
            'type' => 'text',
            'options' => array(
                'label' => 'State: '
            )
        ));

        $this->add(array(
            'name' => 'txtCountry',
            'type' => 'text',
            'options' => array(
                'label' => 'Country: '
            )
        ));

        $this->add(array(
            'name' => 'shipping_mehod',
            'type' => 'Hidden',
            'attributes' => array(
                'id' => 'shipping_mehod',
            ),
        ));

        $this->add(array(
            'name' => 'shipping_rate',
            'type' => 'Hidden',
            'attributes' => array(
                'id' => 'shipping_rate',
            ),
        ));

        $this->add(array(
            'name' => 'btnShip',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Continue',
                'id' => 'btnShip',
            ),
        ));
    }
}