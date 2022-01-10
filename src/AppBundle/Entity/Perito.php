<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Persona
 *
 * @ORM\Table(name="perito")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PeritoRepository")
 */
class Perito
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="profesion", type="string", length=255, nullable = true)
     */
    private $profesion;

    /**
     * @var string
     *
     * @ORM\Column(name="firma", type="string", length=255, nullable=true)
     */
    private $firma;

    /**
     * @ORM\OneToMany(targetEntity="Tramite", mappedBy="persona")
     */
    public $tramite;

    /**
     * @ORM\OneToOne(targetEntity="Persona")
     * @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
     */
    public $persona;

    /**
     * @ORM\OneToMany(targetEntity="EmpresaHasPerito", mappedBy="empresa")
     */
    public $empresaHasPerito;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tramite = new \Doctrine\Common\Collections\ArrayCollection();
        $this->empresaHasPerito = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set profesion.
     *
     * @param string $profesion
     *
     * @return Persona
     */
    public function setProfesion($profesion)
    {
        $this->profesion = $profesion;

        return $this;
    }

    /**
     * Get profesion.
     *
     * @return string
     */
    public function getProfesion()
    {
        return $this->profesion;
    }

    /**
     * Set firma.
     *
     * @param string $firma
     *
     * @return Persona
     */
    public function setFirma($firma)
    {
        $this->firma = $firma;

        return $this;
    }

    /**
     * Get firma.
     *
     * @return string
     */
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * Set persona.
     *
     * @param Persona $persona
     *
     * @return Persona
     */
    public function setPersona($persona)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona.
     *
     * @return Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }
}
