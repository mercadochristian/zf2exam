<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/29/2016
 * Time: 11:54 AM
 */

namespace Customer\Model;

use Zend\Db\TableGateway\TableGateway;

class CustomerTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getCustomerByEmail($email)
    {
        $resultSet = $this->tableGateway->select(array('email' => $email));
        return $resultSet->count() > 0 ? $resultSet->current() : null;
    }

    public function getCustomerByID($customer_id)
    {
        $resultSet = $this->tableGateway->select(array('customer_id' => $customer_id));
        return $resultSet->count() > 0 ? $resultSet->current() : null;
    }

    public function checkEmailForDuplication($email)
    {
        $resultSet = $this->tableGateway->select(array('email' => $email));
        return $resultSet->count() > 0 ? $resultSet->count() : 0;
    }

    public function registerNewUser(Customer $customer)
    {
        $data = array(
            "email"        => $customer->email,
            "password"     => $customer->password,
            "company_name" => $customer->company_name,
            "first_name"   => $customer->first_name,
            "last_name"    => $customer->last_name
        );
        $this->tableGateway->insert($data);
        return $this->tableGateway->getLastInsertValue();
    }
}