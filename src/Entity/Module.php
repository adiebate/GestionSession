<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModuleRepository")
 */
class Module
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $intitule;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contenir", mappedBy="module")
     */
    private $duree;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="appartenir")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    public function __construct()
    {
        $this->duree = new ArrayCollection();
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
     * @return Collection|Contenir[]
     */
    public function getDuree(): Collection
    {
        return $this->duree;
    }

    public function addDuree(Contenir $duree): self
    {
        if (!$this->duree->contains($duree)) {
            $this->duree[] = $duree;
            $duree->setModule($this);
        }

        return $this;
    }

    public function removeDuree(Contenir $duree): self
    {
        if ($this->duree->contains($duree)) {
            $this->duree->removeElement($duree);
            // set the owning side to null (unless already changed)
            if ($duree->getModule() === $this) {
                $duree->setModule(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
