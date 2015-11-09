<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 09.11.2015
 * Time: 18:27
 */

namespace Auth\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController{

    public function __construct() {

    }

    public function loginAction() {
        return new ViewModel();
    }
}