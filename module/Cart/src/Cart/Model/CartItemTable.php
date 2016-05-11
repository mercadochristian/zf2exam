<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 5/3/2016
 * Time: 10:25 AM
 */

namespace Cart\Model;


use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\TableGateway\TableGateway;

class CartItemTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function insertItemsInCartItems(Cart $Cart)
    {
        $data = array(
            'cart_id' => $Cart->cart_id,
            'product_id' => $Cart->product_id,
            'weight' => $Cart->weight,
            'qty' => (int)$Cart->qty,
            'unit_price' => $Cart->unit_price,
            'price' => $Cart->price
        );
        try {
            $this->tableGateway->insert($data);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    public function displayItemsInCart($cart_id)
    {
        try {
            $select = $this->tableGateway->getSql()->select();
            $select->join(array("p" => "products"), "p.product_id=cart_items.product_id", array("product_desc", "product_name"), "left");
            $select->where(array("cart_items.cart_id" => $cart_id));
            $select->group(array("cart_items.product_id"));
            $resultSet = $this->tableGateway->selectWith($select);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        $results = array();
        foreach ($resultSet as $r) {
            $results[] = $r;
        }

        return $results;
    }

    public function computeTotalAmount($cart_id)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(array(
            'total_amount' => new Expression('SUM(price)')
        ));
        $select->where(array('cart_id' => $cart_id));
        $resultSet = $this->tableGateway->selectWith($select);

        return $resultSet->current();
    }

    public function computeTotalWeight($cart_id)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(array(
            'total_weight' => new Expression('SUM(weight)')
        ));
        $select->where(array('cart_id' => $cart_id));
        $resultSet = $this->tableGateway->selectWith($select);

        return $resultSet->current();
    }

    public function getTotalWeightByCartID($cart_id)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(array(
            'total_weight' => new Expression('SUM(weight)')
        ));
        $select->where(array('cart_id' => $cart_id));
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet->current();
    }

    public function checkProductsIfExistingByID($product_id, $cart_id)
    {
        try {
            $select = $this->tableGateway->getSql()->select();
            $select->where(array('product_id' => $product_id, 'cart_id' => $cart_id));
            var_dump($select->getSqlString());
            $resultSet = $this->tableGateway->selectWith($select);
            var_dump($resultSet->current());
            return $resultSet->current();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    public function updateProductsInCartItems(Cart $cart)
    {
        $r = $this->checkProductsIfExistingByID($cart->product_id, $cart->cart_id);
        $newWeight = $r->weight + $cart->weight;
        $newQty = $r->qty + $cart->qty;
        $newPrice = $r->price + $cart->price;

        $data = array(
            'weight' => $newWeight,
            'qty' => $newQty,
            'price' => $newPrice
        );
        //var_dump($data);
        $this->tableGateway->update($data, array('product_id' => $cart->product_id, 'cart_id' => $cart->cart_id));
    }

    public function deleteCartItems($cart_id)
    {
        try {
            $this->tableGateway->delete(array('cart_id' => $cart_id));

        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}