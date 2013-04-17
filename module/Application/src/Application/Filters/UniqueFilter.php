<?php
namespace Application;
use Doctrine\ORM\Mapping\ClassMetaData,
    Doctrine\ORM\Query\Filter\SQLFilter;

class UniqueFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        // Check if the entity is unique

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        return $targetTableAlias.'.locale = ' . $this->getParameter('locale'); // getParameter applies quoting automatically
    }
}