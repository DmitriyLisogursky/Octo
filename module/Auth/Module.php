<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 09.11.2015
 * Time: 14:45
 */

namespace Auth;

use Auth\Entity\AuthStorage;
use Zend\Authentication\Adapter\DbTable;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'AuthStorage' => function () {
                    return new AuthStorage('wd_storage');
                },

                'AuthService' => function (ServiceManager $sm) {
                    /** @var Adapter $dbAdapter */
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter = new DbTable\CredentialTreatmentAdapter(
                        $dbAdapter,
                        'tbl_octo_users',
                        'login',
                        'password',
                        "MD5('staticSalt' || ? || password_salt)"
                    );
                    $authService = new AuthenticationService();

                    $authService->setAdapter($dbTableAuthAdapter);
                    $authService->setStorage($sm->get('AuthStorage'));

                    return $authService;
                },
            ),
        );
    }
}