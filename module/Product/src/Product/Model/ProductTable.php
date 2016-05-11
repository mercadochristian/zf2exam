<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/30/2016
 * Time: 12:15 PM
 */

namespace Product\Model;

use Zend\Db\TableGateway\TableGateway;

class ProductTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getAllProducts()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getProductsByID($id)
    {
        $resultSet = $this->tableGateway->select(array('product_id' => $id));
        return $resultSet->count() > 0 ? $resultSet->current() : null;
    }
}