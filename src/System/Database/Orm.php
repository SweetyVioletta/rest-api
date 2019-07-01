<?php
namespace App\System\Database;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class Orm implements OrmInterface
{
    private $params;
    private $entityManager;

    /**
     * Orm constructor.
     *
     * @param array $params
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct(array $params)
    {
        $this->params = $params;
        $config = Setup::createAnnotationMetadataConfiguration(['src/Entity'], true);
        $entityManager = EntityManager::create($this->params, $config);
        $this->setEntityManager($entityManager);
    }

    /**
     * @param $entityManager
     */
    public function setEntityManager(EntityManager $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return mixed
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }
}