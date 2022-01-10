<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Almacenamiento
 *
 * @ORM\Table(name="almacenamiento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AlmacenamientoRepository")
 */
class Almacenamiento
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
     * @var int|null
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="unidad", type="string", length=255, nullable=true)
     */
    private $unidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="periodo", type="string", length=255, nullable=true)
     */
    private $periodo;

     /**
     * @ORM\OneToOne(targetEntity="Planta")
     * @ORM\JoinColumn(name="planta_id", referencedColumnName="id")
     */
    public $planta;

     /**
     * @ORM\OneToOne(targetEntity="TipoAlmacenamiento")
     * @ORM\JoinColumn(name="tipo_almacenamiento_id", referencedColumnName="id")
     */
    public $tipoAlmacenamiento;


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
     * Set cantidad.
     *
     * @param int|null $cantidad
     *
     * @return Almacenamiento
     */
    public function setCantidad($cantidad = null)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad.
     *
     * @return int|null
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set unidad.
     *
     * @param string|null $unidad
     *
     * @return Almacenamiento
     */
    public function setUnidad($unidad = null)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad.
     *
     * @return string|null
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * Set periodo.
     *
     * @param string|null $periodo
     *
     * @return Almacenamiento
     */
    public function setPeriodo($periodo = null)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo.
     *
     * @return string|null
     */
    public function getPeriodo()
    {
        return $this->periodo;
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

    
    /**
     * Set tipoAlmacenamiento.
     *
     * @param TipoAlmacenamiento $tipoAlmacenamiento
     *
     * @return TipoAlmacenamiento
     */
    public function setTipoAlmacenamiento($tipoAlmacenamiento)
    {
        $this->tipoAlmacenamiento = $tipoAlmacenamiento;

        return $this;
    }

    /**
     * Get tipoAlmacenamiento.
     *
     * @return TipoAlmacenamiento
     */
    public function getTipoAlmacenamiento()
    {
        return $this->tipoAlmacenamiento;
    }
}
