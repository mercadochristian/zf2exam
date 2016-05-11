<?php
return array(
    'controllers' => array(
        'invokables'    => array(
            'Cart\Controller\Cart'  => 'Cart\Controller\CartController',
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'cart' => __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'cart' => array(
                'type'  => 'Segment',
                'options' => array(
                    'route'    => '/cart[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Cart\Controller\Cart',
                        'action'     => 'index',
                    ),
                ),
            )
        )
    )
);