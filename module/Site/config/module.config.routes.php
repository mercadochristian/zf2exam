<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/29/2016
 * Time: 8:17 AM
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Product\Controller\Product',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    )
);