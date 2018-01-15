<?php

namespace Lamp\MyBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;

class EntityService{
    
    private $entityManager;
  
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /*
     * get entity class name
     */
    public function getEntityClassName($entityName)
    {
        $md = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $className = null;
        foreach ($md as $classData) {
            $pathArray = explode("\\", $classData->getName());
            if ($entityName === $pathArray[count($pathArray) - 1]) {
                $className = $classData->getName();
            }
        }
        return $className;
    }

    /*
     * get list of all (specific) enities
     */
    public function getAll($entityName) {
        
        $rep = $this->entityManager->getRepository($this->getEntityClassName($entityName));
        return new Response($this->serializer->serialize($rep->findAll(), 'json'));
    }
    
    public function getById($entityName, $id) {
        $rep = $this->entityManager->getRepository($this->getEntityClassName($entityName));
        return new Response($rep->findBy(array("id" => $id), 'json'));
    }
    
    public function getAllEntitiesNames(){
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $names = array();
        foreach ($metadata as $classMetadata) {
            $pathArr = explode("\\", $classMetadata->getName());
            $names[] = strtolower($pathArr[count($pathArr) - 1]);
        }
        return $names;
    }
    
    
}