<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table(name="empresa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmpresaRepository")
 */
class Empresa
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
     * @var \DateTime
     *
     * @ORM\Column(name="fechaInicioActividad", type="datetime")
     */
    private $fechaInicioActividad;

    /**
     * @var int
     *
     * @ORM\Column(name="tipoPersona", type="integer")
     */
    private $tipoPersona;

    /**
     * @var int
     *
     * @ORM\Column(name="deposito", type="integer")
     */
    private $deposito;

    /**
     * @ORM\OneToMany(targetEntity="Formulario", mappedBy="empresa")
     */
    protected $formulario;
    
    /**
     * @ORM\OneToMany(targetEntity="Domicilio", mappedBy="empresa")
     */
    protected $domicilio;
    
    /**
     * @ORM\OneToMany(targetEntity="Planta", mappedBy="empresa")
     */
    protected $planta;
    
    /**
     * @ORM\OneToMany(targetEntity="EmpresaHasRepresentante", mappedBy="empresa")
     */
    protected $empresaHasRepresentante;
    
    /**
     * @ORM\OneToMany(targetEntity="EmpresaHasActividad", mappedBy="empresa")
     */
    protected $empresaHasActividad;
    
    /**
     * @ORM\OneToMany(targetEntity="EmpresaHasPerito", mappedBy="empresa")
     */
    protected $empresaHasPerito;
    
    /**
     * @ORM\OneToMany(targetEntity="MarcaBandera", mappedBy="empresa")
     */
    protected $marcaBandera;

    /**
     * @ORM\OneToOne(targetEntity="Persona")
     * @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
     */
    protected $persona;

    /**
     * @ORM\OneToMany(targetEntity="Urbanizacion", mappedBy="empresa")
     */
    protected $urbanizacion;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->formulario = new \Doctrine\Common\Collections\ArrayCollection();
        $this->domicilio = new \Doctrine\Common\Collections\ArrayCollection();
        $this->planta = new \Doctrine\Common\Collections\ArrayCollection();
        $this->empresaHasRepresentante = new \Doctrine\Common\Collections\ArrayCollection();
        $this->empresaHasActividad = new \Doctrine\Common\Collections\ArrayCollection();
        $this->empresaHasPerito = new \Doctrine\Common\Collections\ArrayCollection();
        $this->marcaBandera = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set fechaInicioActividad.
     *
     * @param \DateTime $fechaInicioActividad
     *
     * @return Empresa
     */
    public function setFechaInicioActividad($fechaInicioActividad)
    {
        $this->fechaInicioActividad = $fechaInicioActividad;

        return $this;
    }

    /**
     * Get fechaInicioActividad.
     *
     * @return \DateTime
     */
    public function getFechaInicioActividad()
    {
        return $this->fechaInicioActividad;
    }

    /**
     * Set tipoPersona.
     *
     * @param int $tipoPersona
     *
     * @return Empresa
     */
    public function setTipoPersona($tipoPersona)
    {
        $this->tipoPersona = $tipoPersona;

        return $this;
    }

    /**
     * Get tipoPersona.
     *
     * @return int
     */
    public function getTipoPersona()
    {
        return $this->tipoPersona;
    }

    /**
     * Set deposito.
     *
     * @param int $deposito
     *
     * @return Empresa
     */
    public function setDeposito($deposito)
    {
        $this->deposito = $deposito;

        return $this;
    }

    /**
     * Get deposito.
     *
     * @return int
     */
    public function getDeposito()
    {
        return $this->deposito;
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
