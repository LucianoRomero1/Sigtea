<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MonitoreoResiduo
 *
 * @ORM\Table(name="monitoreo_residuo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MonitoreoResiduoRepository")
 */
class MonitoreoResiduo
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
     * @ORM\Column(name="descripcion", type="string", length=500, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="TipoMonitoreo", inversedBy="monitoreo_residuo")
     * @ORM\JoinColumn(name="tipo_monitoreo_id", referencedColumnName="id")
     */
    private $tipoMonitoreo;

    /**
     * @ORM\ManyToOne(targetEntity="Residuo", inversedBy="monitoreo_residuo")
     * @ORM\JoinColumn(name="residuo_id", referencedColumnName="id")
     */
    private $residuo;


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
     * Set descripcion.
     *
     * @param string|null $descripcion
     *
     * @return MonitoreoResiduo
     */
    public function setDescripcion($descripcion = null)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion.
     *
     * @return string|null
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set tipoMonitoreo.
     *
     * @param TipoMonitoreo $tipoMonitoreo
     *
     * @return TipoMonitoreo
     */
    public function setTipoMonitoreo($tipoMonitoreo)
    {
        $this->tipoMonitoreo = $tipoMonitoreo;

        return $this;
    }

    /**
     * Get tipoMonitoreo.
     *
     * @return TipoMonitoreo
     */
    public function getTipoMonitoreo()
    {
        return $this->tipoMonitoreo;
    }

    /**
     * Set residuo.
     *
     * @param Residuo $residuo
     *
     * @return Residuo
     */
    public function SetResiduo($residuo)
    {
        $this->residuo = $residuo;

        return $this;
    }

    /**
     * Get residuo.
     *
     * @return Residuo
     */
    public function GetResiduo()
    {
        return $this->residuo;
    }
}
