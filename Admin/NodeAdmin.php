<?php

namespace Msi\Bundle\MenuBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;

class NodeAdmin extends Admin
{
    public function configure()
    {
        $this->controller = 'MsiMenuBundle:Node:';
    }

    public function buildTable($builder)
    {
        $builder
            ->add('name', 'menu')
            ->add('lvl')
            ->add('lft')
            ->add('rgt')
            ->add('menu', 'text', array('label' => 'root_id'))
            ->add('', 'action', array('actions' => array(
                '<i class="icon-arrow-up"></i>' => 'promote',
                '<i class="icon-arrow-down"></i>' => 'demote',
            )))
        ;
    }

    public function buildForm($builder)
    {
        $qb = $this->getModelManager()->findBy(array('a.menu' => $this->container->get('request')->query->get('parentId')), array('a.children' => 'c'), array('a.lvl' => 'ASC', 'a.lft' => 'ASC'));
        if ($this->object->getId()) {
            $qb->andWhere('a.id != :match')->setParameter('match', $this->object->getId());
        }

        $choices = $qb->getQuery()->execute();

        $builder
            ->add('name')
            ->add('route', 'text', array('required' => true))
            ->add('parent', 'entity', array(
                'class' => 'Msi\Bundle\MenuBundle\Entity\Menu',
                'expanded' => false,
                'multiple' => false,
                'required' => true,
                'choices' => $choices,
            ))
        ;
    }
}
