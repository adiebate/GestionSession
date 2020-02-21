<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SessionRepository")
 * @UniqueEntity(fields={"intitule"}, message="Session déjà existante")
 */
class Session
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
     * @ORM\Column(type="date")
     *
     * 
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="date")
     *    @Assert\Expression(
     *      "this.getDateDebut() <= this.getDateFin()",
     *      message="La date de fin ne doit pas être antérieure à la date début"
     *      )
     */
    private $DateFin;

    /**
     * @ORM\Column(type="integer")
     */
    private $NbPlaces;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contenir", mappedBy="session")
     */
    private $contenir;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stagiaire", mappedBy="sessions")
     */
    private $stagiaires;



    public function __construct()
    {
        $this->contenir = new ArrayCollection();
        $this->stagiaires = new ArrayCollection();
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->NbPlaces;
    }

    public function setNbPlaces(int $NbPlaces): self
    {
        $this->NbPlaces = $NbPlaces;

        return $this;
    }

    public function getIsFull(){
        return ($this->nbPlaces == count($this->stagiaires)) ? true : false;
    }

    /**
     * @return Collection|Contenir[]
     */
    public function getContenir(): Collection
    {
        return $this->contenir;
    }

    public function addContenir(Contenir $contenir): self
    {
        if (!$this->contenir->contains($contenir)) {
            $this->contenir[] = $contenir;
            $contenir->setSession($this);
        }

        return $this;
    }

    public function removeContenir(Contenir $contenir): self
    {
        if ($this->contenir->contains($contenir)) {
            $this->contenir->removeElement($contenir);
            // set the owning side to null (unless already changed)
            if ($contenir->getSession() === $this) {
                $contenir->setSession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stagiaire[]
     */
    public function getStagiaires(): Collection
    {
        return $this->stagiaires;
    }

    public function addStagiaire(Stagiaire $stagiaire): self
    {
        if (!$this->stagiaires->contains($stagiaire)) {
            
            if($this->getNbPlaces() > count($this->stagiaires)){
                $this->stagiaires[] = $stagiaire;
                $stagiaire->addSession($this);
        
            }
        }
        return $this;
    }

    public function removeStagiaire(Stagiaire $stagiaire): self
    {
        if ($this->stagiaires->contains($stagiaire)) {
            $this->stagiaires->removeElement($stagiaire);
            $stagiaire->removeSession($this);
        }

        return $this;
    }

}
