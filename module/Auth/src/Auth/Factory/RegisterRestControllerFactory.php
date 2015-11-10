<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 10.11.2015
 * Time: 13:35
 */

namespace Auth\Factory;


use Auth\Controller\RegisterRestController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RegisterRestControllerFactory implements FactoryInterface {

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return RegisterRestController
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new RegisterRestController();
    }
}