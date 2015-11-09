<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 26-Oct-15
 * Time: 10:32
 */

namespace Auth\Service;


use Auth\Model\User;

interface UserServiceInterface {

    /**
     * @return array|User[]
     */
    public function findAll();
    
    /**
     * @param int $id
     * @return User
     */
    public function find($id);

    /**
     * @param string $login
     * @return User
     */
    public function findUserByLogin($login);

    /**
     * @param $email
     * @return User
     */
    public function findUserByEmail($email);

    /**
     * @param User $user
     * @return int
     */
    public function save($user);

    /**
     * @param int $id
     * @return int
     */
    public function delete($id);
}