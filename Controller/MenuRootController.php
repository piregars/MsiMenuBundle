<?php

namespace Msi\Bundle\MenuBundle\Controller;

use Msi\Bundle\AdminBundle\Controller\AdminController;
use Doctrine\ORM\QueryBuilder;

class MenuRootController extends AdminController
{
    public function configureIndexQueryBuilder(QueryBuilder $qb)
    {
        $qb->andWhere('a.lvl = :lvl')->setParameter('lvl', 0);

        if (!$this->admin->getContainer()->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $qb->andWhere('a.isSuperAdmin = false');
        }
    }
}
