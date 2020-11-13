<?php

namespace App\Repository;

use App\Entity\Weather;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Weather|null find($id, $lockMode = null, $lockVersion = null)
 * @method Weather|null findOneBy(array $criteria, array $orderBy = null)
 * @method Weather[]    findAll()
 * @method Weather[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @author Karol Gancarczyk
 */
class WeatherRepository extends ServiceEntityRepository {

    private const TOP_CITY_QUERY = 'SELECT w.city, Count(w.id) as count FROM App\Entity\Weather w GROUP BY w.city ORDER BY count DESC';
    private const TOTAL_NUMBER_QUERY = 'SELECT Count(w.id) as count FROM App\Entity\Weather w';
    private const TEMPERATURE_STATS_QUERY = 'SELECT MIN(w.temperature) as min, MAX(w.temperature) as max, AVG(w.temperature) as avg FROM App\Entity\Weather w';

    private $entityManager;

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Weather::class);
        $this->entityManager = $registry->getManager();
    }

    public function save(Weather $weather): void {
        $this->entityManager->persist($weather);
        $this->entityManager->flush();
    }

    public function getTopCity(): string {
        $query = $this->entityManager->createQuery(self::TOP_CITY_QUERY);
        $query->setMaxResults(1);
        $result = $query->getSingleResult();
        return $result['city'];
    }

    public function getTotalNumberOfSearch(): int {
        $query = $this->entityManager->createQuery(self::TOTAL_NUMBER_QUERY);
        return $query->getSingleScalarResult();
    }

    public function getTemperatureStats(): array {
        $query = $this->entityManager->createQuery(self::TEMPERATURE_STATS_QUERY);
        return $query->getSingleResult();
    }

    public function findAllOrderedByIdQuery(): Query {
        $query = $this->createQueryBuilder('w')
                ->orderBy('w.id', 'DESC')
                ->getQuery();
        return $query;
    }
}
