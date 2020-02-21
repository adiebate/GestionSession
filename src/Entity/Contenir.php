<?php

namespace App\Entity;

use App\Entity\Module;
use App\Entity\Session;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContenirRepository")
 * @ORM\Table(name="contenir",
 *              uniqueConstraints={
 *                  @ORM\UniqueConstraint(name="contenir_unique",
 *                      columns={"module_id", "session_id"})
 *              })
 * 
 */
class Contenir
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $NbJours;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Module", inversedBy="contenir")
     * @ORM\JoinColumn(nullable=false)
     */
    private $module;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Session", inversedBy="contenir")
     * @ORM\JoinColumn(nullable=false)
     */
    private $session;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbJours(): ?int
    {
        return $this->NbJours;
    }

    public function setNbJours(int $NbJours): self
    {
        $this->NbJours = $NbJours;

        return $this;
    }



    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): self
    {
        
        $this->module = $module;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }
}