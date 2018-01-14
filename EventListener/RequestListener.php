<?php

namespace Lamp\MyBundle\EventListener;

use Lamp\MyBundle\Exception\RouteCollisionHttpException;
use Lamp\MyBundle\Service\EntityService;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
    private $router;
    private $entityService;
 
    public function __construct(Router $router, EntityService $entityService)
    {
        $this->router = $router;
        $this->entityService = $entityService;
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        $routes = $this->router->getRouteCollection()->all();
        $entitiesNames = $this->entityService->getAllEntitiesNames();
        
        if (!empty($entitiesNames)) {
            $routeCollisions = array();
            
            $pathArr=array();
            foreach ($routes as $key => $route) {
                $pathArr[] = $route->getPath();
                if (in_array($pathArr[0], $entitiesNames)) {
                    $routeCollisions[] = $route;
                }
            }
            
            
        }
        if (!empty($routeCollisions)) {
            throw new RouteCollisionHttpException();
        }
    }
}
