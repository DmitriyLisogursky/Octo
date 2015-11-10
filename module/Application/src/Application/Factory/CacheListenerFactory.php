<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 09.11.2015
 * Time: 23:03
 */

namespace Application\Factory;


use Application\Model\CacheListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CacheListenerFactory implements FactoryInterface {

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return CacheListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new CacheListener($serviceLocator->get('Zend\Cache'));
    }
}