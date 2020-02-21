<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $intitule;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Module", mappedBy="categorie")
     */
    private $appartenir;

    public function __construct()
    {
        $this->appartenir = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }


    /**
     * @return Collection|Module[]
     */
    public function getModule(): Collection
    {
        return $this->appartenir;
    }

    public function addModule(Module $module): self
    {
        if (!$this->module->contains($module)) {
            $this->module[] = $module;
            $module->setCategorie($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->module->contains($module)) {
            $this->module->removeElement($module);
            // set the owning side to null (unless already changed)
            if ($module->getCategorie() === $this) {
                $module->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getAppartenir(): Collection
    {
        return $this->appartenir;
    }

    public function addAppartenir(Module $appartenir): self
    {
        if (!$this->appartenir->contains($appartenir)) {
            $this->appartenir[] = $appartenir;
            $appartenir->setCategorie($this);
        }

        return $this;
    }

    public function removeAppartenir(Module $appartenir): self
    {
        if ($this->appartenir->contains($appartenir)) {
            $this->appartenir->removeElement($appartenir);
            // set the owning side to null (unless already changed)
            if ($appartenir->getCategorie() === $this) {
                $appartenir->setCategorie(null);
            }
        }

        return $this;
    }
}
