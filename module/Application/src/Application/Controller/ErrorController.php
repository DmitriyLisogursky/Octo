<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 10.11.2015
 * Time: 2:19
 */

namespace Application\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ErrorController extends AbstractActionController {

    public function indexAction() {
        return new ViewModel();
    }
}