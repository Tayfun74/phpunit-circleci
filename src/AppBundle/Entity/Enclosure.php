<?php

namespace AppBundle\Entity;

use AppBundle\Exception\DinosaursAreRunningRampantException;
use AppBundle\Exception\NotABuffetException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="enclosure")
 */
class Enclosure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Dinosaur", mappedBy="enclosure", cascade={"persist"})
     */
    private $dinosaurs;

    /**
     * @var Collection|Security[]
     * @ORM\OneToMany(targetEntity="Security", mappedBy="enclosure", cascade={"persist"})
     */
    private $securities;

    public function __construct(bool $basicSecurity = false)
    {
        $this->dinosaurs = new ArrayCollection();
        $this->securities = new ArrayCollection();
        if ($basicSecurity)
        {
            $this->addSecurity(new Security('Fence', true, $this));
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getDinosaurCount(): int
    {
        return $this->dinosaurs->count();
    }

    /**
     * @return Collection
     */
    public function getDinosaurs()
    {
        return $this->dinosaurs;
    }

    public function addDinosaur(Dinosaur $dinosaur)
    {
        if (!$this->canAddDinosaur($dinosaur))
        {
            throw new NotABuffetException();
        }
        if (!$this->isSecurityActive())
        {
            throw new DinosaursAreRunningRampantException('Are you craaazy?!?');
        }
        $this->dinosaurs[] = $dinosaur;
    }

    public function canAddDinosaur(Dinosaur $dinosaur): bool
    {
        return \count($this->dinosaurs) === 0 ||
            $this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous();
    }

    public function isSecurityActive(): bool
    {
        foreach ($this->securities as $security) {
            if ($security->getIsActive()) {
                return true;
            }
        }
        return false;
    }

    public function addSecurity(Security $param)
    {
        $this->securities[] = $param;
    }

    /**
     * @return Security[]|Collection
     */
    public function getSecurities()
    {
        return $this->securities;
    }
}