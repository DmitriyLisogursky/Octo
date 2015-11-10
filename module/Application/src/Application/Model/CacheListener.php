<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 09.11.2015
 * Time: 23:04
 */

namespace Application\Model;


use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\RouteMatch;

class CacheListener extends AbstractListenerAggregate {

    protected $listeners = array();
    protected $cacheService;

    public function __construct($cacheService) {
        $this->cacheService = $cacheService;
    }

    public function attach(EventManagerInterface $events) {
        // The AbstractListenerAggregate we are extending from allows us to attach our even listeners
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'getCache'), -1000);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER, array($this, 'saveCache'), -10000);
    }

    public function getCache(MvcEvent $event) {
        /** @var RouteMatch $match */
        $match = $event->getRouteMatch();
        $response = false;

        if (!$match) {
            return $response;
        }

        if ($match->getParam('cache')) {
            $cacheKey = $this->genCacheName($match);

            $data = $this->cacheService->getItem($cacheKey);

            if ($data !== null) {
                $response = $event->getResponse();
                $response->setContent($data);
            }
        }

        return $response;
    }

    public function saveCache(MvcEvent $event) {
        /** @var RouteMatch $match */
        $match = $event->getRouteMatch();

        if (!$match) {
            return;
        }

        if ($match->getParam('cache')) {
            $response = $event->getResponse();
            $data = $response->getContent();

            $cacheKey = $this->genCacheName($match);
            $this->cacheService->setItem($cacheKey, $data);
        }
    }

    protected function genCacheName(RouteMatch $match) {
        return 'cache_'
        . str_replace('/', '-', $match->getMatchedRouteName());
    }
}