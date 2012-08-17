<?php

namespace Msi\Bundle\MenuBundle\Controller;

use Msi\Bundle\AdminBundle\Controller\AdminController;

class MenuRootController extends AdminController
{
    protected function configureListQuery($qb)
    {
        $qb->andWhere('a.lvl = :lvl')->setParameter('lvl', 0);
    }
}
