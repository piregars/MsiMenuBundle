<?php

namespace Msi\Bundle\MenuBundle\Controller;

use Msi\Bundle\AdminBundle\Controller\AdminController;

class MenuNodeController extends AdminController
{
    public function promoteAction()
    {
        $node = $this->admin->getObjectManager()->findBy(array('a.id' => $this->entity->getId()))->getQuery()->getOneOrNullResult();
        $this->admin->getObjectManager()->moveUp($node);

        return $this->onSuccess();
    }

    public function demoteAction()
    {
        $node = $this->admin->getObjectManager()->findBy(array('a.id' => $this->entity->getId()))->getQuery()->getOneOrNullResult();
        $this->admin->getObjectManager()->moveDown($node);

        return $this->onSuccess();
    }
}
