<?php

namespace Msi\Bundle\MenuBundle\Controller;

use Msi\Bundle\AdminBundle\Controller\CrudController;

class MenuRootController extends CrudController
{
    protected function configureListQuery($qb)
    {
        $qb->andWhere('a.lvl = :lvl')->setParameter('lvl', 0);
    }
}
