<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 10.11.2015
 * Time: 13:32
 */

namespace Auth\Factory;


use Auth\Controller\LoginRestController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginRestControllerFactory implements FactoryInterface {

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return LoginRestController
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new LoginRestController();
    }
}