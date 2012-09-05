<?php

namespace Msi\Bundle\MenuBundle\Controller;

use Msi\Bundle\AdminBundle\Controller\AdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MenuNodeController extends AdminController
{
    public function promoteAction()
    {
        $node = $this->admin->getObjectManager()->findBy(array('a.id' => $this->id))->getQuery()->getOneOrNullResult();
        $this->admin->getObjectManager()->moveUp($node);

        return new RedirectResponse($this->admin->genUrl('index'));
    }

    public function demoteAction()
    {
        $node = $this->admin->getObjectManager()->findBy(array('a.id' => $this->id))->getQuery()->getOneOrNullResult();
        $this->admin->getObjectManager()->moveDown($node);

        return new RedirectResponse($this->admin->genUrl('index'));
    }
}
