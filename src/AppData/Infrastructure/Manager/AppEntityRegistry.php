<?php

declare(strict_types=1);

namespace App\AppData\Infrastructure\Manager;

use App\AppData\Infrastructure\AppEntityManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

/**
 * Main component to manager object entity
 *  with doctrine and no-doctrine managers
 */
final class AppEntityRegistry
{
    private const DEFAULT = 'default';

    /** @see vendor/doctrine/persistence/src/Persistence/AbstractManagerRegistry.php */
    public function __construct(
        private readonly ManagerRegistry $doctrineManagerRegistry,
        #[TaggedIterator(AppEntityManagerInterface::TAG)]
        private readonly iterable $noDoctrineEntityManagers,
        private readonly array $entityReplicasSupport,
        private readonly array $noDoctrineEntityManagersByNames,
    ) {
    }

    public function getDoctrine(): ManagerRegistry
    {
        return $this->doctrineManagerRegistry;
    }

    // @todo get no-doctrine managers

    public function getTableName(string $entityName): string
    {
        /** @var ObjectManager $manager */
        $manager = $this->doctrineManagerRegistry
            ->getManagerForClass($entityName);

        return $manager->getClassMetadata($entityName)->getTableName();
    }

    public function save(object $entity): void
    {
        // Create id
        $this->getDefaultDoctrineManager()->persist($entity);

        // other
        foreach ($this->getOtherDoctrineManagerByNames($entity) as $doctrineEntityManager) {
            $doctrineEntityManager->persist($entity);
        }
        $doctrineEntityManager->flush();

        // simili
        foreach ($this->getSimiliDoctrineManagerByNames($entity) as $noDoctrineManager) {
            $noDoctrineManager->save($entity);
        }
    }

    public function remove(object $entity): void
    {
        // no doctrine first
        foreach ($this->getSimiliDoctrineManagerByNames($entity) as $noDoctrineManager) {
            $noDoctrineManager->remove($entity);
        }

        // doctrine
        $this->getDefaultDoctrineManager()->remove($entity);
        foreach ($this->getOtherDoctrineManagerByNames($entity) as $doctrineEntityManager) {
            $doctrineEntityManager->remove($entity);
        }
        $doctrineEntityManager->flush();
    }

    private function getDefaultDoctrineManager(): EntityManagerInterface
    {
        return $this->doctrineManagerRegistry->getManager(self::DEFAULT);
    }

    /** @return array<EntityManagerInterface> */
    private function getOtherDoctrineManagerByNames(object $entity): array
    {
        $managers = [];
        foreach ($this->doctrineManagerRegistry->getManagers() as $managerName => $doctrineEntityManager) {
            /** @var EntityManagerInterface $doctrineEntityManager */
            if (!$this->isSupportedReplicasEntity($entity, $managerName)) {
                continue;
            }

            $managers[$managerName] = $doctrineEntityManager;
        }

        return $managers;
    }

    /** @return array<AppEntityManagerInterface> */
    private function getSimiliDoctrineManagerByNames(object $entity): array
    {
        $managers = [];
        foreach ($this->noDoctrineEntityManagersByNames as $managerName => $managerClassName) {
            if (!$this->isSupportedReplicasEntity($entity, $managerName)) {
                continue;
            }

            $managers[$managerName] =
                \array_filter(\iterator_to_array($this->noDoctrineEntityManagers),
                    fn (AppEntityManagerInterface $manager) => $manager::class === $managerClassName
                )[0];
        }

        return $managers;
    }

    private function isSupportedReplicasEntity(object $entity, string $managerName): bool
    {
        $supportedClasses = $this->entityReplicasSupport[$entity::class];
        $this->handleNotExistingManagerName($supportedClasses);

        return \in_array($managerName, $supportedClasses);
    }

    private function handleNotExistingManagerName(array $supportedClasses): void
    {
        $allManagerNames = \array_merge(
            \array_keys($this->doctrineManagerRegistry->getManagers()),
            \array_keys($this->noDoctrineEntityManagersByNames)
        );

        $diffClass = \array_diff($supportedClasses, $allManagerNames);
        if (0 !== \count($diffClass)) {
            throw new \DomainException("Manager '".\current($diffClass)."' not handled.");
        }
    }
}
