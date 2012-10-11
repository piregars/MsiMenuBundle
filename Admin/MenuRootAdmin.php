<?php

namespace Msi\Bundle\MenuBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;
use Msi\Bundle\MenuBundle\Form\Type\MenuRootTranslationType;

class MenuRootAdmin extends Admin
{
    public function configure()
    {
        $this->options = array(
            'controller' => 'MsiMenuBundle:MenuRoot:',
        );
    }

    public function buildIndexTable($builder)
    {
        if ($this->getContainer()->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $builder->add('isSuperAdmin', 'boolean');
        }

        $builder
            ->add('name')
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
