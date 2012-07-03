<?php

namespace Msi\Bundle\MenuBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;

class RootAdmin extends Admin
{
    public function configure()
    {
        $this->controller = 'MsiMenuBundle:Root:';
    }

    public function buildTable($builder)
    {
        $builder
            ->add('id')
            ->add('enabled', 'logical')
            ->add('name')
            ->add('', 'action')
        ;
    }

    public function buildForm($builder)
    {
        $builder
            ->add('name')
        ;
    }
}
