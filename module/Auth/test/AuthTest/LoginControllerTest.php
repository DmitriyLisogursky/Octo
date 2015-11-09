<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 09.11.2015
 * Time: 19:59
 */

namespace AuthTest;


use ApplicationTest\Bootstrap;
use Auth\Controller\LoginController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Mvc\Router\RouteMatch;

class LoginControllerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var AbstractActionController
     */
    private $controller;
    /**
     * @var RouteMatch
     */
    private $routeMatch;
    private $request;
    private $event;

    protected function setUp() {
        $serviceManager = Bootstrap::getServiceManager();
        $this->controller = new LoginController();
        $this->request = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'login'));
        $this->event = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);

        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
    }

    public function testLoginActionCanBeAccessed() {
        $this->routeMatch->setParam('action', 'login');
        /** @var Response $response */
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }
}
