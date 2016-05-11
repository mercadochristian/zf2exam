<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 5/5/2016
 * Time: 6:43 PM
 */

namespace Cart\Model;

use Zend\Db\TableGateway\TableGateway;

class JobItemsTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function insertToJobItems($Cart)
    {
        foreach ($Cart as $c) {
            $data = array(
                'job_order_id' => $c->cart_id,
                'product_id' => $c->product_id,
                'weight' => $c->weight,
                'qty' => $c->qty,
                'unit_price' => $c->unit_price,
                'price' => $c->price
            );

            $this->tableGateway->insert($data);
            //$this->tableGateway->delete(array('cart_id' => $c->cart_id));
        }
    }
}