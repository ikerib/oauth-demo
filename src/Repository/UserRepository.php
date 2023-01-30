<?php

namespace App\Repository;

use App\Entity\User;
use App\Security\GenericUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOrCreateFromOauth(GenericUser $owner)
    {
        $user = $this->createQueryBuilder('u')
            ->where('u.username = :username')->setParameter('username', $owner->getId())
            ->getQuery()
            ->getOneOrNullResult();

        if ($user) {
            return $user;
        }

        $user = (new User())
            ->setUsername($owner->getId())
            ->setPassword('kk')
        ;
        $user->setRoles(['ROLE_ADMIN']);

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }
}
