<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SitioContaminado
 *
 * @ORM\Table(name="sitio_contaminado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SitioContaminadoRepository")
 */
class SitioContaminado
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
     * @ORM\Column(name="ubicacion_georeferencial", type="string", length=250)
     */
    private $ubicacionGeoreferencial;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=250)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="parametros_interes", type="string", length=250)
     */
    private $parametrosIntereses;

    /**
     * @var string
     *
     * @ORM\Column(name="plan_monitoreo", type="string", length=250)
     */
    private $planMonitoreo;

    /**
     * @var string
     *
     * @ORM\Column(name="plan_remediacion", type="string", length=250)
     */
    private $planRemediacion;

    /**
     * @ORM\OneToOne(targetEntity="Planta")
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
     * Set ubicacionGeoreferencial.
     *
     * @param string $ubicacionGeoreferencial
     *
     * @return SitioContaminado
     */
    public function setUbicacionGeoreferencial($ubicacionGeoreferencial)
    {
        $this->ubicacionGeoreferencial = $ubicacionGeoreferencial;

        return $this;
    }

    /**
     * Get ubicacionGeoreferencial.
     *
     * @return string
     */
    public function getUbicacionGeoreferencial()
    {
        return $this->ubicacionGeoreferencial;
    }

    /**
     * Set descripcion.
     *
     * @param string $descripcion
     *
     * @return SitioContaminado
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion.
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set parametrosIntereses.
     *
     * @param string $parametrosIntereses
     *
     * @return SitioContaminado
     */
    public function setParametrosIntereses($parametrosIntereses)
    {
        $this->parametrosIntereses = $parametrosIntereses;

        return $this;
    }

    /**
     * Get parametrosIntereses.
     *
     * @return string
     */
    public function getParametrosIntereses()
    {
        return $this->parametrosIntereses;
    }

    /**
     * Set planMonitoreo.
     *
     * @param string $planMonitoreo
     *
     * @return SitioContaminado
     */
    public function setPlanMonitoreo($planMonitoreo)
    {
        $this->planMonitoreo = $planMonitoreo;

        return $this;
    }

    /**
     * Get planMonitoreo.
     *
     * @return string
     */
    public function getPlanMonitoreo()
    {
        return $this->planMonitoreo;
    }

    /**
     * Set planRemediacion.
     *
     * @param string $planRemediacion
     *
     * @return SitioContaminado
     */
    public function setPlanRemediacion($planRemediacion)
    {
        $this->planRemediacion = $planRemediacion;

        return $this;
    }

    /**
     * Get planRemediacion.
     *
     * @return string
     */
    public function getPlanRemediacion()
    {
        return $this->planRemediacion;
    }

    /**
     * Set planta.
     *
     * @param int|null $planta
     *
     * @return Planta
     */
    public function setPlanta($planta = null)
    {
        $this->planta = $planta;

        return $this;
    }

    /**
     * Get planta.
     *
     * @return int|null
     */
    public function getPlanta()
    {
        return $this->planta;
    }
}
