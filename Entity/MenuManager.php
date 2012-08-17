<?php

namespace Msi\Bundle\MenuBundle\Entity;

use Msi\Bundle\AdminBundle\Entity\BaseManager;

class MenuManager extends BaseManager
{
    public function findRootById($id, $locale)
    {
        $qb = $this->findBy(array('c.enabled' => true, 'a.enabled' => true, 'a.id' => $id), array('a.children' => 'c', 'c.translations' => 'ct', 'c.page' => 'p', 'p.translations' => 'pt'), array());

        $orX = $qb->expr()->orX();

        $orX->add($qb->expr()->eq('pt.locale', ':ptlocale'));
        $qb->setParameter('ptlocale', $locale);

        $orX->add($qb->expr()->isNull('c.page'));

        $qb->andWhere($orX);

        $qb->andWhere($qb->expr()->eq('ct.locale', ':ctlocale'));
        $qb->setParameter('ctlocale', $locale);

        return $qb->getQuery()->getSingleResult();
    }
}
