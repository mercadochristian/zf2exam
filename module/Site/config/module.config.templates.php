<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/29/2016
 * Time: 8:17 AM
 */

return array(
    'view_manager' => array(
        'layout'                    => 'MAINTEMP',
        'base_path'                 => '/',
        'display_not_found_reason'  => true,
        'display_exceptions'        => true,
        'doctype'                   => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'MAINTEMP'   => __DIR__ . '/../view/layout/templates/main.phtml',
            'APPNAV'     => __DIR__ . '/../view/layout/sections/header/nav.phtml',
            'APPCSS'     => __DIR__ . '/../view/layout/sections/header/app_css.phtml',
            'APPSCRIPTS' => __DIR__ . '/../view/layout/sections/header/app_scripts.phtml',
            'INDEX'      => __DIR__ . '/../view/layout/pages/index.phtml',

            'error/404'               => __DIR__ . '/../view/layout/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/layout/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    )
);