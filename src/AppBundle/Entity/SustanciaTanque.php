<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SustanciaTanque
 *
 * @ORM\Table(name="sustancia_tanque")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SustanciaTanqueRepository")
 */
class SustanciaTanque
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
     * @var string|null
     *
     * @ORM\Column(name="sustancia", type="string", length=255, nullable=true)
     */
    private $sustancia;

    /**
     * @var string|null
     *
     * @ORM\Column(name="capacidad", type="string", length=255, nullable=true)
     */
    private $capacidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="estado_fisico", type="string", length=255, nullable=true)
     */
    private $estadoFisico;

    /**
     * @var string|null
     *
     * @ORM\Column(name="presurizado", type="string", length=255, nullable=true)
     */
    private $presurizado;

    /**
     * @var string|null
     *
     * @ORM\Column(name="peligrosidad", type="string", length=255, nullable=true)
     */
    private $peligrosidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="norma_seguridad", type="string", length=255, nullable=true)
     */
    private $normaSeguridad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nro_norma", type="string", length=255, nullable=true)
     */
    private $nroNorma;

     /**
     * @ORM\OneToOne(targetEntity="Tanque")
     * @ORM\JoinColumn(name="tanque_id", referencedColumnName="id")
     */
    public $tanque;


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
     * Set sustancia.
     *
     * @param string|null $sustancia
     *
     * @return SustanciaTanque
     */
    public function setSustancia($sustancia = null)
    {
        $this->sustancia = $sustancia;

        return $this;
    }

    /**
     * Get sustancia.
     *
     * @return string|null
     */
    public function getSustancia()
    {
        return $this->sustancia;
    }

    /**
     * Set capacidad.
     *
     * @param string|null $capacidad
     *
     * @return SustanciaTanque
     */
    public function setCapacidad($capacidad = null)
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    /**
     * Get capacidad.
     *
     * @return string|null
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * Set estadoFisico.
     *
     * @param string|null $estadoFisico
     *
     * @return SustanciaTanque
     */
    public function setEstadoFisico($estadoFisico = null)
    {
        $this->estadoFisico = $estadoFisico;

        return $this;
    }

    /**
     * Get estadoFisico.
     *
     * @return string|null
     */
    public function getEstadoFisico()
    {
        return $this->estadoFisico;
    }

    /**
     * Set presurizado.
     *
     * @param string|null $presurizado
     *
     * @return SustanciaTanque
     */
    public function setPresurizado($presurizado = null)
    {
        $this->presurizado = $presurizado;

        return $this;
    }

    /**
     * Get presurizado.
     *
     * @return string|null
     */
    public function getPresurizado()
    {
        return $this->presurizado;
    }

    /**
     * Set peligrosidad.
     *
     * @param string|null $peligrosidad
     *
     * @return SustanciaTanque
     */
    public function setPeligrosidad($peligrosidad = null)
    {
        $this->peligrosidad = $peligrosidad;

        return $this;
    }

    /**
     * Get peligrosidad.
     *
     * @return string|null
     */
    public function getPeligrosidad()
    {
        return $this->peligrosidad;
    }

    /**
     * Set normaSeguridad.
     *
     * @param string|null $normaSeguridad
     *
     * @return SustanciaTanque
     */
    public function setNormaSeguridad($normaSeguridad = null)
    {
        $this->normaSeguridad = $normaSeguridad;

        return $this;
    }

    /**
     * Get normaSeguridad.
     *
     * @return string|null
     */
    public function getNormaSeguridad()
    {
        return $this->normaSeguridad;
    }

    /**
     * Set nroNorma.
     *
     * @param string|null $nroNorma
     *
     * @return SustanciaTanque
     */
    public function setNroNorma($nroNorma = null)
    {
        $this->nroNorma = $nroNorma;

        return $this;
    }

    /**
     * Get nroNorma.
     *
     * @return string|null
     */
    public function getNroNorma()
    {
        return $this->nroNorma;
    }

    /**
     * Set tanque.
     *
     * @param Tanque $tanque
     *
     * @return Tanque
     */
    public function setTanque($tanque)
    {
        $this->tanque = $tanque;

        return $this;
    }

    /**
     * Get tanque.
     *
     * @return Tanque
     */
    public function getTanque()
    {
        return $this->tanque;
    }
}
