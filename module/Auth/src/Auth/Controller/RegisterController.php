<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 10.11.2015
 * Time: 13:29
 */

namespace Auth\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\ViewModel;

class RegisterController extends AbstractActionController {

    public function registerAction() {
        return new ViewModel();
    }
}