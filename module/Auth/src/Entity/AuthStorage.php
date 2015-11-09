<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 09.11.2015
 * Time: 14:52
 */

namespace Auth\Entity;


use Zend\Authentication\Storage;

class AuthStorage extends Storage\Session {

    const TIME_TO_REMEMBER_USER = 1209600;

    function __construct($namespace) {
        parent::__construct($namespace);
    }

    public function setRememberMe($rememberMe = 0, $time = -1) {

        if ($time < 0) {
            $time = self::TIME_TO_REMEMBER_USER;
        }

        if ($rememberMe) {
            $this->session->getManager()->rememberMe($time);
        }
    }

    public function forgetMe() {
        $this->session->getManager()->forgetMe();
    }
}