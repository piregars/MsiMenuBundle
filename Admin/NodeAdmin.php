<?php

namespace Msi\Bundle\MenuBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;
use Msi\Bundle\MenuBundle\Form\Type\NodeTranslationType;

class NodeAdmin extends Admin
{
    public function configure()
    {
        $this->controller = 'MsiMenuBundle:Node:';
        $this->setSearchFields(array('name'));
    }

    public function buildTable($builder)
    {
        $builder
            ->add('id')
            ->add('enabled', 'boolean')
            ->add('name', 'menu')
            ->add('route')
            ->add('page')
            ->add('updatedAt', 'date')
            ->add('', 'action', array('tree' => true))
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
            ->add('translations', 'collection', array('label' => ' ', 'type' => new NodeTranslationType(), 'options' => array(
                'label' => ' ',
            )))
            ->add('page', 'entity', array('empty_value' => 'Choose a page', 'class' => 'Msi\Bundle\PageBundle\Entity\Page'))
            ->add('parent', 'entity', array(
                'class' => 'Msi\Bundle\MenuBundle\Entity\Menu',
                'choices' => $choices,
            ))
        ;
    }
}
