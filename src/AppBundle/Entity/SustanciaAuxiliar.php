<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SustanciaAuxiliar
 *
 * @ORM\Table(name="sustancia_auxiliar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SustanciaAuxiliarRepository")
 */
class SustanciaAuxiliar
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_fisico", type="string", length=255)
     */
    private $estadoFisico;

    /**
     * @var string
     *
     * @ORM\Column(name="produccion", type="string", length=255)
     */
    private $produccion;

    /**
     * @var string
     *
     * @ORM\Column(name="unidad", type="string", length=255)
     */
    private $unidad;

    /**
     * @var string
     *
     * @ORM\Column(name="almacenamiento", type="string", length=255)
     */
    private $almacenamiento;

    /**
     * @var int
     *
     * @ORM\Column(name="tipo", type="integer")
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="producto")
     * @ORM\JoinColumn(name="planta_id", referencedColumnName="id")
     */
    private $planta;


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
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return SustanciaAuxiliar
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set estadoFisico.
     *
     * @param string $estadoFisico
     *
     * @return SustanciaAuxiliar
     */
    public function setEstadoFisico($estadoFisico)
    {
        $this->estadoFisico = $estadoFisico;

        return $this;
    }

    /**
     * Get estadoFisico.
     *
     * @return string
     */
    public function getEstadoFisico()
    {
        return $this->estadoFisico;
    }

    /**
     * Set produccion.
     *
     * @param string $produccion
     *
     * @return SustanciaAuxiliar
     */
    public function setProduccion($produccion)
    {
        $this->produccion = $produccion;

        return $this;
    }

    /**
     * Get produccion.
     *
     * @return string
     */
    public function getProduccion()
    {
        return $this->produccion;
    }

    /**
     * Set unidad.
     *
     * @param string $unidad
     *
     * @return SustanciaAuxiliar
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad.
     *
     * @return string
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * Set almacenamiento.
     *
     * @param string $almacenamiento
     *
     * @return SustanciaAuxiliar
     */
    public function setAlmacenamiento($almacenamiento)
    {
        $this->almacenamiento = $almacenamiento;

        return $this;
    }

    /**
     * Get almacenamiento.
     *
     * @return string
     */
    public function getAlmacenamiento()
    {
        return $this->almacenamiento;
    }

    /**
     * Set tipo.
     *
     * @param int $tipo
     *
     * @return SustanciaAuxiliar
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return int
     */
    public function getTipo()
    {
        return $this->tipo;
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
