<?php

declare(strict_types=1);

namespace UserDetails\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class AbstractRepositoryFactory implements AbstractFactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     *
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName): bool
    {
        $classNameParts = explode('\\', $requestedName);

        if (count($classNameParts) != 3) {
            return false;
        }

        list(, $subNamespace, $className) = $classNameParts;

        $repositorySuffix = 'Repository';
        $suffixLength = strlen($repositorySuffix);

        if ($subNamespace !== $repositorySuffix || substr($className, -1 * $suffixLength) !== $repositorySuffix) {
            return false;
        }

        $entityFqcn = $this->buildEntityClassName($requestedName);

        return class_exists($entityFqcn);
    }

    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return EntityRepository
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): EntityRepository
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $classNameWithNamespace = $this->buildEntityClassName($requestedName);

        return $entityManager->getRepository($classNameWithNamespace);
    }

    /**
     * @param string $requestedName
     *
     * @return string
     */
    private function buildEntityClassName(string $requestedName): string
    {
        list($module, , $className) = explode('\\', $requestedName);
        $entityClassName = substr($className, 0, strpos($className, 'Repository'));

        return sprintf('%s\\Entity\\%s', $module, $entityClassName);
    }
}