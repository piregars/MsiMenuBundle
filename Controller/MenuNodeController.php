<?php

namespace Msi\Bundle\MenuBundle\Controller;

use Msi\Bundle\AdminBundle\Controller\AdminController;
use Doctrine\ORM\QueryBuilder;

class MenuNodeController extends AdminController
{
    public function promoteAction()
    {
        $node = $this->admin->getObjectManager()->getFindByQueryBuilder(array('a.id' => $this->admin->getObject()->getId()))->getQuery()->getOneOrNullResult();
        $this->admin->getObjectManager()->moveUp($node);

        return $this->onSuccess();
    }

    public function demoteAction()
    {
        $node = $this->admin->getObjectManager()->getFindByQueryBuilder(array('a.id' => $this->admin->getObject()->getId()))->getQuery()->getOneOrNullResult();
        $this->admin->getObjectManager()->moveDown($node);

        return $this->onSuccess();
    }

    public function configureIndexQueryBuilder(QueryBuilder $qb)
    {
        $qb->andWhere('a.lvl != :lvl')->setParameter('lvl', 0);
        $qb->orderBy('a.lft', 'ASC');
        $qb->leftJoin('a.translations', 't');
        $qb->addSelect('t');
    }
}
