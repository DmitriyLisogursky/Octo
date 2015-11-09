<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 09.11.2015
 * Time: 18:30
 */

namespace Auth\Factory;


use Auth\Controller\LoginController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginControllerFactory implements FactoryInterface {

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return LoginController
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new LoginController();
    }
}