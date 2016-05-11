<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/29/2016
 * Time: 11:13 AM
 */

namespace Customer;


use Customer\Filter\LoginFilter;
use Customer\Filter\RegistrationFilter;
use Customer\Form\LoginForm;
use Customer\Form\RegistrationForm;
use Customer\Model\Customer;
use Customer\Model\CustomerTable;
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
              'CustomerTable' => function($sm){
                  $CustomerTableGateway = $sm->get('CustomerTableGateway');
                  return new CustomerTable($CustomerTableGateway);
              },
              'CustomerTableGateway' => function($sm){
                  $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                  $resultSetPrototype = new ResultSet();
                  $resultSetPrototype->setArrayObjectPrototype(new Customer());
                  return new TableGateway('customers', $dbAdapter, null, $resultSetPrototype);
              },
              'Customer' => function(){
                  return new Customer();
              },
              'LoginForm' => function(){
                  return new LoginForm();
              },
              'LoginFilter' => function(){
                  return new LoginFilter();
              },
              'RegistrationForm' => function(){
                  return new RegistrationForm();
              },
              'RegistrationFilter' => function(){
                  return new RegistrationFilter();
              },
              'Container' => function(){
                  return new Container();
              }
          )
        );
    }
}