<?php

namespace Msi\Bundle\MenuBundle\Controller;

use Msi\Bundle\AdminBundle\Controller\CrudController;

class RootController extends CrudController
{
    protected function configureIndexQuery($qb)
    {
        $qb->andWhere('a.lvl = :lvl')->setParameter('lvl', 0);
    }
}
