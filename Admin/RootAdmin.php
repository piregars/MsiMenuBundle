<?php

namespace Msi\Bundle\MenuBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;
use Msi\Bundle\MenuBundle\Form\Type\MenuTranslationType;

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
            ->add('updatedAt', 'date')
            ->add('', 'action')
        ;
    }

    public function buildForm($builder)
    {
        $builder
            ->add('translations', 'collection', array('attr' => array('class' => 'lead bold'), 'type' => new MenuTranslationType(), 'options' => array(
                'attr' => array('class' => 'lead bold'),
            )))
        ;
    }
}
