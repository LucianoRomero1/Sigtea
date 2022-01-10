<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Topografia
 *
 * @ORM\Table(name="topografia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TopografiaRepository")
 */
class Topografia
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
     * @ORM\Column(name="descripcionSitio", type="string", length=45, nullable=true)
     */
    private $descripcionSitio;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcionPendientes", type="string", length=45, nullable=true)
     */
    private $descripcionPendientes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tipoSuelo", type="string", length=45, nullable=true)
     */
    private $tipoSuelo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="permeabilidad", type="string", length=45, nullable=true)
     */
    private $permeabilidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tratamientoSuelo", type="string", length=45, nullable=true)
     */
    private $tratamientoSuelo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="abastecimientoAgua", type="string", length=45, nullable=true)
     */
    private $abastecimientoAgua;

    /**
     * @var string|null
     *
     * @ORM\Column(name="profundidad", type="string", length=45, nullable=true)
     */
    private $profundidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="distanciaBombeo", type="string", length=45, nullable=true)
     */
    private $distanciaBombeo;

    /**
     * @ORM\OneToOne(targetEntity="Planta")
     * @ORM\JoinColumn(name="planta_id", referencedColumnName="id")
     */
    public $planta;


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
     * Set descripcionSitio.
     *
     * @param string|null $descripcionSitio
     *
     * @return Topografia
     */
    public function setDescripcionSitio($descripcionSitio = null)
    {
        $this->descripcionSitio = $descripcionSitio;

        return $this;
    }

    /**
     * Get descripcionSitio.
     *
     * @return string|null
     */
    public function getDescripcionSitio()
    {
        return $this->descripcionSitio;
    }

    /**
     * Set descripcionPendientes.
     *
     * @param string|null $descripcionPendientes
     *
     * @return Topografia
     */
    public function setDescripcionPendientes($descripcionPendientes = null)
    {
        $this->descripcionPendientes = $descripcionPendientes;

        return $this;
    }

    /**
     * Get descripcionPendientes.
     *
     * @return string|null
     */
    public function getDescripcionPendientes()
    {
        return $this->descripcionPendientes;
    }

    /**
     * Set tipoSuelo.
     *
     * @param string|null $tipoSuelo
     *
     * @return Topografia
     */
    public function setTipoSuelo($tipoSuelo = null)
    {
        $this->tipoSuelo = $tipoSuelo;

        return $this;
    }

    /**
     * Get tipoSuelo.
     *
     * @return string|null
     */
    public function getTipoSuelo()
    {
        return $this->tipoSuelo;
    }

    /**
     * Set permeabilidad.
     *
     * @param string|null $permeabilidad
     *
     * @return Topografia
     */
    public function setPermeabilidad($permeabilidad = null)
    {
        $this->permeabilidad = $permeabilidad;

        return $this;
    }

    /**
     * Get permeabilidad.
     *
     * @return string|null
     */
    public function getPermeabilidad()
    {
        return $this->permeabilidad;
    }

    /**
     * Set tratamientoSuelo.
     *
     * @param string|null $tratamientoSuelo
     *
     * @return Topografia
     */
    public function setTratamientoSuelo($tratamientoSuelo = null)
    {
        $this->tratamientoSuelo = $tratamientoSuelo;

        return $this;
    }

    /**
     * Get tratamientoSuelo.
     *
     * @return string|null
     */
    public function getTratamientoSuelo()
    {
        return $this->tratamientoSuelo;
    }

    /**
     * Set abastecimientoAgua.
     *
     * @param string|null $abastecimientoAgua
     *
     * @return Topografia
     */
    public function setAbastecimientoAgua($abastecimientoAgua = null)
    {
        $this->abastecimientoAgua = $abastecimientoAgua;

        return $this;
    }

    /**
     * Get abastecimientoAgua.
     *
     * @return string|null
     */
    public function getAbastecimientoAgua()
    {
        return $this->abastecimientoAgua;
    }

    /**
     * Set profundidad.
     *
     * @param string|null $profundidad
     *
     * @return Topografia
     */
    public function setProfundidad($profundidad = null)
    {
        $this->profundidad = $profundidad;

        return $this;
    }

    /**
     * Get profundidad.
     *
     * @return string|null
     */
    public function getProfundidad()
    {
        return $this->profundidad;
    }

    /**
     * Set distanciaBombeo.
     *
     * @param string|null $distanciaBombeo
     *
     * @return Topografia
     */
    public function setDistanciaBombeo($distanciaBombeo = null)
    {
        $this->distanciaBombeo = $distanciaBombeo;

        return $this;
    }

    /**
     * Get distanciaBombeo.
     *
     * @return string|null
     */
    public function getDistanciaBombeo()
    {
        return $this->distanciaBombeo;
    }

    /**
     * Set planta.
     *
     * @param Planta $planta
     *
     * @return Planta
     */
    public function setPlanta($planta)
    {
        $this->planta = $planta;

        return $this;
    }

    /**
     * Get planta.
     *
     * @return Planta
     */
    public function getPlanta()
    {
        return $this->planta;
    }
}
