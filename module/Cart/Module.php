<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 5/3/2016
 * Time: 9:41 AM
 */

namespace Cart;

use Cart\Filter\ShippingFilter;
use Cart\Form\ShippingForm;
use Cart\Model\CartTable;
use Cart\Model\CartItemTable;
use Cart\Model\Cart;
use Cart\Model\JobItemsTable;
use Cart\Model\Jobs;
use Cart\Model\JobsTable;
use Cart\Model\Shipping;
use Cart\Model\ShippingTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'CartTable' => function($sm){
                    $CartTableGateway = $sm->get('CartTableGateway');
                    return new CartTable($CartTableGateway);
                },
                'CartTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Cart());
                    return new TableGateway('carts', $dbAdapter, null, $resultSetPrototype);
                },
                'JobsTable' => function($sm){
                    $JobsTableGateway = $sm->get('JobsTableGateway');
                    return new JobsTable($JobsTableGateway);
                },
                'JobsTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Jobs());
                    return new TableGateway('jobs', $dbAdapter, null, $resultSetPrototype);
                },
                'JobItemsTable' => function($sm){
                    $JobsItemsTableGateway = $sm->get('JobsItemsTableGateway');
                    return new JobItemsTable($JobsItemsTableGateway);
                },
                'JobsItemsTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Jobs());
                    return new TableGateway('job_items', $dbAdapter, null, $resultSetPrototype);
                },
                'Jobs' => function(){
                    return new Jobs();
                },
                'CartItemTable' => function($sm){
                    $CartItemTableGateway = $sm->get('CartItemTableGateway');
                    return new CartItemTable($CartItemTableGateway);
                },
                'CartItemTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Cart());
                    return new TableGateway('cart_items', $dbAdapter, null, $resultSetPrototype);
                },
                'Container' => function(){
                    return new Container();
                },
                'Cart' => function(){
                    return new Cart();;
                },
                'ShippingFilter' => function(){
                    return new ShippingFilter();
                },
                'ShippingForm' => function(){
                    return new ShippingForm();
                },
                'ShippingTable' => function($sm){
                    $ShippingTableGateway = $sm->get('ShippingTableGateway');
                    return new ShippingTable($ShippingTableGateway);
                },
                'ShippingTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Shipping());
                    return new TableGateway('shipping', $dbAdapter, null, $resultSetPrototype);
                }
            )
        );
    }
}