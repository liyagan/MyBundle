<?php

namespace Lamp\MyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;



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
    
    public function indexActionWithId($entityName,$id)
    {
        return $this->entityService->getById($entityName,$id);
    }
}
