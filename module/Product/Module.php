<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/29/2016
 * Time: 4:56 PM
 */

namespace Product;


use Product\Model\Product;
use Product\Model\ProductTable;
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
                'ProductTable' => function($sm){
                    $ProductTableGateway = $sm->get('ProductTableGateway');
                    return new ProductTable($ProductTableGateway);
                },
                'ProductTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Product());
                    return new TableGateway('products', $dbAdapter, null, $resultSetPrototype);
                },
                'Product' => function(){
                    return new Product();
                },
                /*'Container' => function(){
                    return new Container();
                }*/
            )
        );
    }
}