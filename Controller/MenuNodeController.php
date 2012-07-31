<?php

namespace Msi\Bundle\MenuBundle\Controller;

use Msi\Bundle\AdminBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MenuNodeController extends CrudController
{
    protected function configureListQuery($qb)
    {
        $qb->andWhere('a.lvl != :lvl')->setParameter('lvl', 0);
        $qb->orderBy('a.lft', 'ASC');
    }

    public function promoteAction()
    {
        $node = $this->admin->getModelManager()->findBy(array('a.id' => $this->id))->getQuery()->getOneOrNullResult();
        $this->admin->getModelManager()->moveUp($node);

        return new RedirectResponse($this->admin->genUrl('index'));
    }

    public function demoteAction()
    {
        $node = $this->admin->getModelManager()->findBy(array('a.id' => $this->id))->getQuery()->getOneOrNullResult();
        $this->admin->getModelManager()->moveDown($node);

        return new RedirectResponse($this->admin->genUrl('index'));
    }
}
