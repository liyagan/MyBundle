<?php

namespace Lamp\MyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lamp\MyBundle\Service\EntityService;

class DefaultController extends Controller
{
    
    private $entityService;
    
    public function __construct(EntityService $entityService)
    {
        $this->entityService = $entityService;
    }
  
    public function indexAction($entityName)
    {
        return $this->entityService->getAll($entityName);
    }
    
    public function indexWithIdAction($entityName,$id)
    {
        return $this->entityService->getById($entityName,$id);
    }
}
