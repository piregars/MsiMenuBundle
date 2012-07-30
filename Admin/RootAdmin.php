<?php

namespace Msi\Bundle\MenuBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;
use Msi\Bundle\MenuBundle\Form\Type\RootTranslationType;

class RootAdmin extends Admin
{
    public function configure()
    {
        $this->controller = 'MsiMenuBundle:Root:';
        $this->setSearchFields(array('name'));
    }

    public function buildTable($builder)
    {
        $builder
            ->add('id')
            ->add('enabled', 'boolean')
            ->add('name')
            ->add('updatedAt', 'date')
            ->add('', 'action')
        ;
    }

    public function buildForm($builder)
    {
        $builder
            ->add('translations', 'collection', array('label' => ' ', 'type' => new RootTranslationType(), 'options' => array(
                'label' => ' ',
            )))
        ;
    }
}
