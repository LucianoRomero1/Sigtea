<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BocaExpendio
 *
 * @ORM\Table(name="boca_expendio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BocaExpendioRepository")
 */
class BocaExpendio
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
     * @ORM\Column(name="tipo_servicio", type="string", length=45)
     */
    private $tipoServicio;

    /**
     * @var int
     *
     * @ORM\Column(name="boca_expendio", type="integer")
     */
    private $bocaExpendio;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_producto", type="string", length=255)
     */
    private $nombreProducto;

    /**
     * @var string
     *
     * @ORM\Column(name="caudal", type="string", length=255)
     */
    private $caudal;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=500)
     */
    private $observacion;

    /**
     * @ORM\ManyToOne(targetEntity="ActividadServicio", inversedBy="bocaExpendio")
     * @ORM\JoinColumn(name="actividadServicio_id", referencedColumnName="id")
     */
    private $actividadServicio;


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
     * Set tipoServicio.
     *
     * @param string $tipoServicio
     *
     * @return BocaExpendio
     */
    public function setTipoServicio($tipoServicio)
    {
        $this->tipoServicio = $tipoServicio;

        return $this;
    }

    /**
     * Get tipoServicio.
     *
     * @return string
     */
    public function getTipoServicio()
    {
        return $this->tipoServicio;
    }

    /**
     * Set bocaExpendio.
     *
     * @param int $bocaExpendio
     *
     * @return BocaExpendio
     */
    public function setBocaExpendio($bocaExpendio)
    {
        $this->bocaExpendio = $bocaExpendio;

        return $this;
    }

    /**
     * Get bocaExpendio.
     *
     * @return int
     */
    public function getBocaExpendio()
    {
        return $this->bocaExpendio;
    }

    /**
     * Set nombreProducto.
     *
     * @param string $nombreProducto
     *
     * @return BocaExpendio
     */
    public function setNombreProducto($nombreProducto)
    {
        $this->nombreProducto = $nombreProducto;

        return $this;
    }

    /**
     * Get nombreProducto.
     *
     * @return string
     */
    public function getNombreProducto()
    {
        return $this->nombreProducto;
    }

    /**
     * Set caudal.
     *
     * @param string $caudal
     *
     * @return BocaExpendio
     */
    public function setCaudal($caudal)
    {
        $this->caudal = $caudal;

        return $this;
    }

    /**
     * Get caudal.
     *
     * @return string
     */
    public function getCaudal()
    {
        return $this->caudal;
    }

    /**
     * Set observacion.
     *
     * @param string $observacion
     *
     * @return BocaExpendio
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion.
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set actividadServicio.
     *
     * @param ActividadServicio $actividadServicio
     *
     * @return ActividadServicio
     */
    public function setActividadServicio($actividadServicio)
    {
        $this->actividadServicio = $actividadServicio;

        return $this;
    }

    /**
     * Get actividadServicio.
     *
     * @return ActividadServicio
     */
    public function getActividadServicio()
    {
        return $this->actividadServicio;
    }
}
