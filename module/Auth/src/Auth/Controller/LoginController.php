<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 09.11.2015
 * Time: 18:27
 */

namespace Auth\Controller;


use Application\Controller\CommonController;
use Zend\View\Model\ViewModel;

class LoginController extends CommonController {

    public function __construct() {

    }

    public function loginAction() {
        $viewModel = new ViewModel();

        $viewModel->setTerminal(true);

        return $viewModel;
    }
}