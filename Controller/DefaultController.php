<?php

namespace Lamp\MyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lamp\MyBundle\Service\EntityService;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    
    private $entityService;
    
    public function __construct(EntityService $entityService)
    {
        $this->entityService = $entityService;
    }
  
    public function indexAction($entityName)
    {
        return new Response($this->entityService->getAll($entityName));
    }
    
    public function indexWithIdAction($entityName,$id)
    {
        return $this->entityService->getById($entityName,$id);
    }
}
