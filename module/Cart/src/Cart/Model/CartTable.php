<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 5/3/2016
 * Time: 10:25 AM
 */

namespace Cart\Model;

use Zend\Db\TableGateway\TableGateway;

class CartTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function insertItemInCartTable()
    {
        //$date = time();
        $date = date('Y-m-d h:i:s');
        $data = array(
            'customer_id' => 0,
            'order_datetime' => $date,
            'sub_total' => 0,
            'taxable_amount' => 0,
            'discount' => 0,
            'tax' => 0,
            'shipping_total' => 0,
            'total_amount' => 0,
            'total_weight' => 0,
            'company_name' => '',
            'email' => '',
            'first_name' => '',
            'last_name' => '',
            'phone' => '',
            'shipping_mehod' => '',
            'shipping_name' => '',
            'shipping_address1' => '',
            'shipping_address2' => '',
            'shipping_address3' => '',
            'shipping_city' => '',
            'shipping_state' => '',
            'shipping_country' => ''
        );
        try {
            $this->tableGateway->insert($data);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
        echo 'insert';
        return $this->tableGateway->getLastInsertValue();
    }

    public function updateCartTable(Cart $cart)
    {
        $data = array(
            'customer_id' => $cart->customer_id,
            'order_datetime' => date('Y-m-d h:i:s'),
            'sub_total' => $cart->sub_total,
            'shipping_total' => $cart->shipping_total,
            'total_amount' => (float)$cart->sub_total + (float)$cart->shipping_total,
            'total_weight' => $cart->total_weight,
            'company_name' => $cart->company_name,
            'email' => $cart->email,
            'first_name' => $cart->first_name,
            'last_name' => $cart->last_name,
            'phone' => $cart->phone,
            'shipping_mehod' => $cart->shipping_mehod,
            'shipping_name' => $cart->shipping_name,
            'shipping_address1' => $cart->shipping_address1,
            'shipping_address2' => $cart->shipping_address2,
            'shipping_address3' => $cart->shipping_address3,
            'shipping_city' => $cart->shipping_city,
            'shipping_state' => $cart->shipping_state,
            'shipping_country' => $cart->shipping_country
        );
        var_dump($data);
        try {
            $this->tableGateway->update($data, array('cart_id' => $cart->cart_id));
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    public function computeTotalPayment($cart_id)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where(array('cart_id'=>$cart_id));
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet->current();
    }

    public function deleteCart($cart_id)
    {
        $this->tableGateway->delete(array('cart_id' => $cart_id));
    }
}