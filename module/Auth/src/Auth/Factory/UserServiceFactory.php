<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.04.2015
 * Time: 16:22
 */

namespace Auth\Factory;


use Application\Factory\FactoryUtil;
use Auth\Model\User;
use Auth\Service\UserService;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserServiceFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return UserService
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $dbAdapter = FactoryUtil::initAdapter($serviceLocator);
        $hydrator = FactoryUtil::initHydrator();
        $userPrototype = new User();

        $resultSet = new HydratingResultSet($hydrator, $userPrototype);

        return new UserService(
            new TableGateway('tbl_octo_users', $dbAdapter, null, $resultSet),
            $hydrator,
            $userPrototype
        );
    }
}