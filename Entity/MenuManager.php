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

        return $qb->getQuery()->getSingleResult();
    }
}
