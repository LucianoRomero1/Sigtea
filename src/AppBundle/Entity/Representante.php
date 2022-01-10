<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representante
 *
 * @ORM\Table(name="representante")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RepresentanteRepository")
 */
class Representante
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
     * @ORM\Column(name="cargo", type="string", length=255, nullable=true)
     */
    private $cargo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="tipo", type="integer", nullable=true)
     */
    private $tipo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firma", type="string", length=255, nullable=true)
     */
    private $firma;

    /**
     * @ORM\OneToOne(targetEntity="Persona")
     * @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
     */
    public $persona;

    /**
     * @ORM\OneToMany(targetEntity="EmpresaHasRepresentante", mappedBy="representante")
     */
    protected $empresaHasRepresentante;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->empresaHasRepresentante = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set cargo.
     *
     * @param string $cargo
     *
     * @return Representante
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo.
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set tipo.
     *
     * @param int|null $tipo
     *
     * @return Representante
     */
    public function setTipo($tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return int|null
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set firma.
     *
     * @param string|null $firma
     *
     * @return Representante
     */
    public function setFirma($firma = null)
    {
        $this->firma = $firma;

        return $this;
    }

    /**
     * Get firma.
     *
     * @return string|null
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
