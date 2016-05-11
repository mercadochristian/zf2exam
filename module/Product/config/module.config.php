<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/29/2016
 * Time: 4:56 PM
 */

return array(
    'controllers' => array(
        'invokables'    => array(
            'Product\Controller\Product'  => 'Product\Controller\ProductController',
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'product' => __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'product' => array(
                'type'  => 'Segment',
                'options' => array(
                    'route'    => '/product[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Product\Controller\Product',
                        'action'     => 'index',
                    ),
                ),
            )
        )
    )
);