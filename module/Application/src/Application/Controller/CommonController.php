<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 26-Oct-15
 * Time: 10:32
 */

namespace Application\Controller;


use Auth\Service\UserService;
use Auth\Service\UserServiceInterface;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;

abstract class CommonController extends AbstractActionController {

    private $authService;
    private $userService;

    /**
     * @return AuthenticationServiceInterface
     */
    protected function getAuthService() {

        if (!$this->authService) {
            $this->authService = $this->getServiceLocator()->get('AuthService');
        }

        return $this->authService;
    }

    /**
     * @return UserServiceInterface
     */
    protected function getUserService() {

        if (!$this->userService) {
            $this->userService = UserService::newInstance($this->getServiceLocator());
        }

        return $this->userService;
    }
}