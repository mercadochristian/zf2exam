<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/29/2016
 * Time: 8:17 AM
 */

return array(
    'controllers' => array(
        'invokables' => array(
            'Product\Controller\Product' => 'Product\Controller\ProductController'
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'session_vars'  => array(
        'namespace' => array("Zend_Auth"),
    ),
);