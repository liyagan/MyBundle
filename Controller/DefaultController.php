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
        return new Response(json_encode($this->entityService->getAll($entityName)));
    }
    
    public function entityByIdAction($entityName,$id)
    {
        return $this->entityService->getById($entityName,$id);
    }
}
