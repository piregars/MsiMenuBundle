<?php

namespace Msi\Bundle\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="menu")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @Gedmo\Tree(type="nested")
 * @ORM\HasLifecycleCallbacks
 */
class Menu implements \Knp\Menu\NodeInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column
     */
    protected $name;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    protected $lvl;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    protected $lft;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    protected $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer")
     */
    protected $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="children")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="parent", cascade={"remove"})
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    protected $children;
    public function getChildren() {
        $childNodes = array();
        foreach ($this->children as $child) {
            if ($child->getEnabled() != false)
                $childNodes[] = $child;
        }

        return $childNodes;
    }

    /**
     * @ORM\Column(nullable="true")
     */
    protected $route;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    public function getOptions()
    {
        $options = array();

        if (preg_match('#^@#', $this->route))
            $options['route'] = substr($this->route, 1);
        else
            $options['uri'] = $this->route;

        if ($this->lvl === 0)
            $options['attributes'] = array('class' => 'nav');

        return $options;
    }

    public function __toString()
    {
        return $this->name;
    }
}
