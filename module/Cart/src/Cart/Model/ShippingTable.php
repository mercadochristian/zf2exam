<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 5/5/2016
 * Time: 9:27 AM
 */

namespace Cart\Model;


use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\TableGateway\TableGateway;

class ShippingTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getShippingByWeight($weight, $maxweight)
    {
        if ($weight > $maxweight) {
            $select = $this->tableGateway->getSql()->select();
            $select->where->lessThanOrEqualTo('min_weight',$maxweight)->AND->greaterThanOrEqualTo('max_weight',$maxweight);

            $resultSet = $this->tableGateway->selectWith($select);
        } else {
            $select = $this->tableGateway->getSql()->select();
            $select->where->lessThanOrEqualTo('min_weight',$weight)->AND->greaterThanOrEqualTo('max_weight',$weight);

            $resultSet = $this->tableGateway->selectWith($select);
        }

        $result = array();
        foreach ($resultSet as $r) {
            $result[] = $r;
        }
        return $result;
    }

    public function getMaximumWeight()
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(array(
            'max_weight' => new Expression('MAX(max_weight)')
        ));
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet->current();
        //var_dump($resultSet->current());
    }

    
}