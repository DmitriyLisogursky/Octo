<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 09.11.2015
 * Time: 15:17
 */

namespace Application\Controller;


use Zend\Mvc\Controller\AbstractRestfulController;

class CommonRestfulController extends AbstractRestfulController{

    public function getList() {
        return $this->redirect()->toRoute('home');
    }
}