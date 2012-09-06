<?php

namespace Msi\Bundle\MenuBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;
use Msi\Bundle\MenuBundle\Form\Type\MenuNodeTranslationType;
use Msi\Bundle\MenuBundle\Entity\Menu;

class MenuNodeAdmin extends Admin
{
    public function configure()
    {
        $this->options = array(
            'controller' => 'MsiMenuBundle:MenuNode:',
        );
    }

    public function buildIndexTable($builder)
    {
        $builder
            ->add('enabled', 'boolean')
            ->add('name', 'tree')
            ->add('page')
            ->add('updatedAt', 'date')
            ->add('', 'action', array('tree' => true))
        ;
    }

    public function buildForm($builder)
    {
        $qb = $this->getObjectManager()->getFindByQueryBuilder(array('a.menu' => $this->container->get('request')->query->get('parentId')), array('a.children' => 'c'), array('a.lvl' => 'ASC', 'a.lft' => 'ASC'));
        if ($this->getObject()->getId()) {
            $qb->andWhere('a.id != :match')->setParameter('match', $this->getObject()->getId());

            $i = 0;
            foreach ($this->getObject()->getChildren() as $child) {
                $qb->andWhere('a.id != :match'.$i)->setParameter('match'.$i, $child->getId());
                $i++;
            }
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
