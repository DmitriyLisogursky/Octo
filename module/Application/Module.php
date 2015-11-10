<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Util\ZendErrorsHandler;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {
    
    public function onBootstrap(MvcEvent $e) {

        if (IS_PRODUCTION) {
            $e->getApplication()->getEventManager()->getSharedManager()->attach(
                'Zend\Mvc\Controller\AbstractActionController',
                'dispatch',
                array(new ZendErrorsHandler(), 'handleControllerCannotDispatchRequest'),
                1000
            );
            $e->getApplication()->getEventManager()->attach(
                '*',
                new ZendErrorsHandler(),
                1001
            );
        }

        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
