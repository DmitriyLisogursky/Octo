<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 10.11.2015
 * Time: 13:30
 */

namespace Auth\Factory;


use Auth\Controller\RegisterController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RegisterControllerFactory implements FactoryInterface {

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return RegisterController
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new RegisterController();
    }
}