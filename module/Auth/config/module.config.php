<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 09.11.2015
 * Time: 14:44
 */

return array(
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/login[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Auth\Controller',
                        'controller' => 'Login',
                        'action' => 'login',
                        'cache' => IS_PRODUCTION
                    ),
                ),
            ),
            'register' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/register[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Auth\Controller',
                        'controller' => 'Register',
                        'action' => 'register',
                        'cache' => IS_PRODUCTION
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Auth\Controller',
                        'controller' => 'Profile',
                        'action' => 'logout'
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'Auth\Service\UserServiceInterface' => 'Auth\Factory\UserServiceFactory',
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'Auth\Controller\Login' => 'Auth\Factory\LoginControllerFactory',
            'Auth\Controller\LoginRest' => 'Auth\Factory\LoginRestControllerFactory',
            'Auth\Controller\Register' => 'Auth\Factory\RegisterControllerFactory',
            'Auth\Controller\RegisterRest' => 'Auth\Factory\RegisterRestControllerFactory',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'template_map' => include __DIR__ . '/../template_map.php',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        )
    ),
    'module_layouts' => array(
        'Auth' => array(
            'default' => 'layout/application',
        )
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(),
        ),
    ),
);