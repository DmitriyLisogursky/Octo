<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 26-Oct-15
 * Time: 10:32
 */

namespace Auth\Model;


use Application\Model\Model;

class User extends Model {

    protected $login;
    protected $password;
    protected $passwordSalt;
    protected $firstName;
    protected $middleName;
    protected $lastName;
    protected $email;
    protected $status;
    protected $loginAttempts;

    public function populate($data) {
        $this->login = (!empty($data['login'])) ? $data['login'] : $this->login;
        $this->password = (!empty($data['password'])) ? $data['password'] : $this->password;
        $this->firstName = (!empty($data['firstName'])) ? $data['firstName'] : '';
        $this->middleName = (!empty($data['middleName'])) ? $data['middleName'] : '';
        $this->lastName = (!empty($data['lastName'])) ? $data['lastName'] : '';
        $this->email = (!empty($data['login'])) ? $data['login'] : $this->email;
    }

    /**
     * @return mixed
     */
    public function getLogin() {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login) {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPasswordSalt() {
        return $this->passwordSalt;
    }

    /**
     * @param mixed $passwordSalt
     */
    public function setPasswordSalt($passwordSalt) {
        $this->passwordSalt = $passwordSalt;
    }

    /**
     * @return mixed
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getMiddleName() {
        return $this->middleName;
    }

    /**
     * @param mixed $middleName
     */
    public function setMiddleName($middleName) {
        $this->middleName = $middleName;
    }

    /**
     * @return mixed
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getLoginAttempts() {
        return $this->loginAttempts;
    }

    /**
     * @param mixed $loginAttempts
     */
    public function setLoginAttempts($loginAttempts) {
        $this->loginAttempts = $loginAttempts;
    }

    /**
     * @return mixed
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    protected function hydrateJoinedColumns($data) {
        // TODO: Implement hydrateJoinedColumns() method.
    }
}