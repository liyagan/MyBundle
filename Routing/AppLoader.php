<?php

namespace Lamp\MyBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Lamp\MyBundle\Service\EntityService;

class AppLoader extends Loader
{
   
    private $loaded = false;
    private $entityService;
    
    public function __construct(EntityService $entityService)
    {
        $this->entityService = $entityService;
    }
    
    public function load($resource, $type = null)
    {
       
        if ($this->loaded === true) {
            throw new \RuntimeException('Do not add the "app" loader twice');
        }
        
        $routes = new RouteCollection();
        $entityNames = $this->entityService->getAllEntitiesNames();
        
        if (empty($entityNames)) return $routes;
        
        $path1 = '/{entityName}/';
        $path2 = '/{entityName}/{id}';
        
        $defaults1 = array(
            '_controller' => 'LampMyBundle:Default:index'
        );
        $defaults2 = array(
            '_controller' => 'LampMyBundle:Default:indexWithId'
        );
   
        
        $regexpNames = $this->entityNamesToRequirements($entityNames);
        
        $requirements = array(
            'id' => '\d+',
            'entityName' => strtolower(strval($regexpNames))
        );
       
        $route1 = new Route($path1, $defaults1, $requirements);
        $route2 = new Route($path2, $defaults2, $requirements);
        
        $routes->add('entityRoute', $route1);
        $routes->add('entityByIdRoute', $route2);
        
        $this->loaded = true;
        return $routes;
    }
    
    /**
     * Returns whether this class supports the given resource.
     *
     * @param mixed $resource A resource
     * @param string|null $type The resource type or null if unknown
     *
     * @return bool True if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return 'extra' == $type;
    }
    
    private function entityNamesToRequirements(array $names)
    {
        $requiremets = '';
        if (empty($names)){
            return '\\';
        }
        foreach ($names as $name) {
            $requiremets .= $name . '|';
        }
        return substr($requiremets, 0, -1);
    }
}
