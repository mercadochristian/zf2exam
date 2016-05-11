<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/29/2016
 * Time: 8:14 AM
 */

namespace Site;


use Zend\Http\Client;
use Zend\Session\Container;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;
use Zend\Stdlib\ArrayUtils;

class Module
{
    public function onBootstrap (MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $config = $sm->get('Configuration');
        $application = $e->getParam('application');
        $viewModel = $application->getMvcEvent()->getViewModel();
        $viewModel->setVariables($config['app_config']);

        //start session
        $SessionManager = new SessionManager();
        $SessionManager->start();
    }

    public function getConfig()
    {
        $config = array();

        // get config files
        $configFiles = array(
            __DIR__ . '/config/module.config.php',
            __DIR__ . '/config/module.config.routes.php',
            __DIR__ . '/config/module.config.templates.php',
        );

        // Merge all module config options
        foreach($configFiles as $configFile) {
            $config = ArrayUtils::merge($config, include $configFile);
        }

        return $config;
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
}