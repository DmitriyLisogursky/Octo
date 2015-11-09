<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 26-Oct-15
 * Time: 10:32
 */

namespace Application\Factory;


use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ArraySerializable;

class FactoryUtil {

    /**
     * @return ArraySerializable
     */
    public static function initHydrator() {
        $hydrator = new ArraySerializable();
        $hydrator->addFilter("nonCamelColumns", function ($property) {
            $filter = array("nonCamelColumns", "count", "origin");

            if (in_array($property, $filter)) {

                return false;
            }

            return true;
        });

        return $hydrator;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return  AdapterInterface
     */
    public static function initAdapter(ServiceLocatorInterface $serviceLocator) {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');

        return $dbAdapter;
    }
}