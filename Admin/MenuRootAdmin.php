<?php

namespace Msi\Bundle\MenuBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;
use Msi\Bundle\MenuBundle\Form\Type\MenuRootTranslationType;

class MenuRootAdmin extends Admin
{
    public function buildIndexTable($builder)
    {
        $builder
            ->add('enabled', 'boolean')
            ->add('name')
            ->add('updatedAt', 'date')
            ->add('', 'action')
        ;
    }

    public function buildForm($builder)
    {
        $builder
            ->add('translations', 'collection', array('label' => ' ', 'type' => new MenuRootTranslationType(), 'options' => array(
                'label' => ' ',
            )))
        ;
    }
}
