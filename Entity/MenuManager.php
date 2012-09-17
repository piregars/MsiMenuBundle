<?php

namespace Msi\Bundle\MenuBundle\Entity;

use Msi\Bundle\AdminBundle\Entity\BaseManager;
use Doctrine\ORM\QueryBuilder;

class MenuManager extends BaseManager
{
    public function findRootById($id, $locale)
    {
        $qb = $this->findBy(array('c.enabled' => true, 'a.enabled' => true, 'a.id' => $id), array('a.translations' => 't', 'a.children' => 'c', 'c.translations' => 'ct', 'c.page' => 'p', 'p.translations' => 'pt'), array());

        $orX = $qb->expr()->orX();

        $orX->add($qb->expr()->eq('pt.locale', ':ptlocale'));
        $qb->setParameter('ptlocale', $locale);

        $orX->add($qb->expr()->isNull('c.page'));

        $qb->andWhere($orX);

        $qb->andWhere($qb->expr()->eq('ct.locale', ':ctlocale'));
        $qb->setParameter('ctlocale', $locale);

        return $qb->getQuery()->getSingleResult();
    }

    public function findRootByName($name, $locale)
    {
        $qb = $this->findBy(array('c.enabled' => true, 'a.enabled' => true, 't.name' => $name), array('a.translations' => 't', 'a.children' => 'c', 'c.translations' => 'ct', 'c.page' => 'p', 'p.translations' => 'pt'), array());

        $orX = $qb->expr()->orX();

        $orX->add($qb->expr()->eq('pt.locale', ':ptlocale'));
        $qb->setParameter('ptlocale', $locale);

        $orX->add($qb->expr()->isNull('c.page'));

        $qb->andWhere($orX);

        $qb->andWhere($qb->expr()->eq('ct.locale', ':ctlocale'));
        $qb->setParameter('ctlocale', $locale);

        return $qb->getQuery()->getSingleResult();
    }

    protected function configureAdminListQuery(QueryBuilder $qb)
    {
        if (!$qb->getParameter('eqMatch1')) {
            $qb->andWhere('a.lvl = :lvl')->setParameter('lvl', 0);
        } else {
            $qb->andWhere('a.lvl != :lvl')->setParameter('lvl', 0);
            $qb->orderBy('a.lft', 'ASC');
        }
    }
}
