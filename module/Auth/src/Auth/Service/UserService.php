<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 26-Oct-15
 * Time: 10:32
 */

namespace Auth\Service;


use Application\Service\CommonService;
use Auth\Model\User;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

class UserService extends CommonService implements UserServiceInterface {

    /**
     * @var TableGateway
     */
    protected $userTable;
    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    protected $hydrator;
    /**
     * @var \Auth\Model\User
     */
    protected $userPrototype;

    /**
     * @param TableGateway $userTable
     * @param HydratorInterface $hydrator
     * @param User $userPrototype
     */
    public function __construct(TableGateway $userTable, HydratorInterface $hydrator, User $userPrototype) {
        $this->table = $userTable;
        $this->hydrator = $hydrator;
        $this->userPrototype = $userPrototype;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return UserServiceInterface
     */
    public static function newInstance($serviceLocator) {
        return CommonService::newService('User', $serviceLocator, 'Auth');
    }

    /**
     * @param int|string $id
     * @return User
     * @throws \InvalidArgumentException
     */
    public function find($id) {
        return $this->findUserByColumnValue('id', $id);
    }

    /**
     * @param null $where
     * @param array $order
     * @param array $limit
     * @return array|\Auth\Model\User[]
     */
    public function findAll($where = null, $order = array(), $limit = array()) {
        $where = $where ?: new Where();
        $where->notEqualTo('tbl_octo_users.id', "-1");
        $users = parent::findAll($where, $order, $limit);

        return $users;
    }


    public function save($user) {
        $userArray = array_filter($this->hydrator->extract($user), function ($e) {
            return $e !== null;
        });

        if ($user->getId() > 0) {
            $this->table->update($userArray, array('id' => $user->getId()));

            return $user->getId();
        } else {
            $this->table->insert($userArray);

            return $this->table->getAdapter()->getDriver()->getLastGeneratedValue($this->table->getTable() . '_id_seq');
        }
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete($id) {
        $ordersId = null;
        $currentUserId = $this->getCurrentUserId();

            if ($id === $currentUserId) {
                $this->getServiceLocator()
                    ->get('AuthStorage')
                    ->forgetMe();
                $this->getServiceLocator()->get('AuthService')->clearIdentity();
            }

        return parent::delete($id);
    }

    /**
     * @param string $login
     * @return User
     */
    public function findUserByLogin($login) {
        return $this->findUserByColumnValue('login', $login);
    }

    /**
     * @param string $email
     * @return User
     */
    public function findUserByEmail($email) {
        return $this->findUserByColumnValue('email', $email);
    }

    /**
     * @param $column
     * @param $value
     * @return UserService
     */
    public function findUserByColumnValue($column, $value) {
        $result = $this->table->select(array($column . ' = ?' => $value));

        return $result->count() > 0 ? $result->current() : null;
    }

    private function getCurrentUserId() {
        $login = $this->getServiceLocator()->get('AuthService')->getIdentity()['login'];
        $user = $this->findUserByLogin($login);

        return $user->getId();
    }
}