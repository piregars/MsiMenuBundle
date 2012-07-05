<?php

namespace Msi\Bundle\MenuBundle\Entity;

use Msi\Bundle\AdminBundle\Entity\ModelManager;

class MenuManager extends ModelManager
{
    public function findRootById($id)
    {
        $qb = $this->findBy(array('c.enabled' => true, 'a.enabled' => true, 'a.id' => $id), array('a.children' => 'c', 'c.translations' => 'ct', 'c.page' => 'p', 'p.translations' => 'pt'), array());

        $orX = $qb->expr()->orX();

        $orX->add($qb->expr()->eq('pt.locale', ':ptlocale'));
        $qb->setParameter('ptlocale', $this->session->getLocale());

        $orX->add($qb->expr()->isNull('c.page'));

        $qb->andWhere($orX);

        $qb->andWhere($qb->expr()->eq('ct.locale', ':ctlocale'));
        $qb->setParameter('ctlocale', $this->session->getLocale());

        return $qb->getQuery()->getSingleResult();
    }
}
