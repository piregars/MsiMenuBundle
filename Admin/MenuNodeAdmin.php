<?php

namespace Msi\Bundle\MenuBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;
use Msi\Bundle\MenuBundle\Form\Type\MenuNodeTranslationType;

class MenuNodeAdmin extends Admin
{
    public function configure()
    {
        $this->controller = 'MsiMenuBundle:MenuNode:';
        $this->likeFields = array('name');
    }

    public function buildIndexTable($builder)
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
        $i = 0;
        foreach ($this->object->getChildren() as $child) {
            $qb->andWhere('a.id != :match'.$i)->setParameter('match'.$i, $child->getId());
            $i++;
        }

        $choices = $qb->getQuery()->execute();

        $builder
            ->add('translations', 'collection', array('label' => ' ', 'type' => new MenuNodeTranslationType(), 'options' => array(
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
