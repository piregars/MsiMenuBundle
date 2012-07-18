<?php

namespace Msi\Bundle\MenuBundle\Controller;

use Msi\Bundle\AdminBundle\Controller\CrudController;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NodeController extends CrudController
{
    protected function configureIndexQuery($qb)
    {
        $qb->andWhere('a.lvl != :lvl')->setParameter('lvl', 0);
        $qb->orderBy('a.lft', 'ASC');
    }

    /**
     * @Route("/{_locale}/admin/msi_menu_node/promote.html", name="admin_msi_menu_node_promote")
     */
    public function promoteAction()
    {
        $node = $this->admin->getModelManager()->findBy(array('a.id' => $this->id), array(), array(), 1)->getQuery()->getSingleResult();
        $this->admin->getModelManager()->moveUp($node);

        return new RedirectResponse($this->admin->genUrl('index'));
    }

    /**
     * @Route("/{_locale}/admin/msi_menu_node/demote.html", name="admin_msi_menu_node_demote")
     */
    public function demoteAction()
    {
        $node = $this->admin->getModelManager()->findBy(array('a.id' => $this->id), array(), array(), 1)->getQuery()->getSingleResult();
        $this->admin->getModelManager()->moveDown($node);

        return new RedirectResponse($this->admin->genUrl('index'));
    }
}
