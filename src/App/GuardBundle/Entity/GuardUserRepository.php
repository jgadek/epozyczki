<?php

namespace App\GuardBundle\Entity;

use Doctrine\ORM\EntityRepository;
use App\GuardBundle\Entity\GuardUser;

/**
 * GuardUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GuardUserRepository extends EntityRepository
{

    public function getData($arrFilter, $orderBy, $page, $limit)
    {
        $page = $page !== null ? $page : 1;
        $limit = $limit !== null ? $limit : GuardUser::DEFAULT_LIMIT;
        $offset = ($page - 1) * $limit;
        $join = 'WHERE';

        $idQuery = '';
        if (isset($arrFilter['id']) && $arrFilter['id'] !== null && $arrFilter['id'] !== '') {
            $idQuery = $join . " gu.id = " . $arrFilter['id'] . " ";
            $join = "AND";
        }

        $usernameQuery = '';
        if (isset($arrFilter['username']) && $arrFilter['username'] !== null && $arrFilter['username'] !== '') {
            $usernameQuery = $join . " gu.username like '%" . $arrFilter['username'] . "%' ";
            $join = "AND";
        }

        $emailQuery = '';
        if (isset($arrFilter['email']) && $arrFilter['email'] !== null && $arrFilter['email'] !== '') {
            $emailQuery = $join . " gu.email like '%" . $arrFilter['email'] . "%' ";
            $join = "AND";
        }

        $selectQuery = 'SELECT gu';
        $isCount = false;
        if (isset($arrFilter['count']) && $arrFilter['count'] !== null && $arrFilter['count'] !== '') {
            if ($arrFilter['count'] === 'true' || $arrFilter['count'] === 't') {
                $isCount = true;
                $selectQuery = 'SELECT count(gu)';
            }
        }

        $strOrderBy = $orderBy !== null ? "ORDER BY gu.$orderBy" : '';

        $queryInstance = $this->getEntityManager()->createQuery("
            $selectQuery
                FROM AppGuardBundle:GuardUser gu
                $idQuery
                $usernameQuery
                $emailQuery
                $strOrderBy
        ");
        if ($isCount) {
            return $queryInstance->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_SINGLE_SCALAR);
        }
        return $queryInstance
                        ->setMaxResults($limit)
                        ->setFirstResult($offset)
                        ->getResult();
    }
    
    public function getToRejectByOfferAccepted(\DataBundle\Entity\Offer $objOffer)
    {
        return $this
                ->createQueryBuilder('g')
                ->select('g')
                ->leftJoin('g.offers', 'o')
                ->where('o.id <> :id')
                ->setParameter(':id', $objOffer->getId())
                ->andWhere('o.credit = :credit')
                ->setParameter('credit', $objOffer->getCredit())
                ->getQuery()
                ->getResult();
    }
    
    public function getNewBorrowers()
    {
        $collUsers = $this
                ->createQueryBuilder('gu')
                ->where('gu.isNew = true')
                ->andWhere("gu.roles like '%".GuardUser::ROLE_BORROWER."%'")
                ->getQuery()
                ->getResult();
        $this
                ->createQueryBuilder('gu')
                ->update()
                ->set('gu.isNew', 'false')
                ->where('gu.isNew = true')
                ->andWhere("gu.roles like '%".GuardUser::ROLE_BORROWER."%'")
                ->getQuery()
                ->getResult();
        return $collUsers;
    }
    
    public function getNewLenders()
    {
        $collUsers = $this
                ->createQueryBuilder('gu')
                ->where('gu.isNew = true')
                ->andWhere("gu.roles like '%".GuardUser::ROLE_LENDER."%'")
                ->getQuery()
                ->getResult();
        $this
                ->createQueryBuilder('gu')
                ->update()
                ->set('gu.isNew', 'false')
                ->where('gu.isNew = true')
                ->andWhere("gu.roles like '%".GuardUser::ROLE_LENDER."%'")
                ->getQuery()
                ->getResult();
        return $collUsers;
    }

}