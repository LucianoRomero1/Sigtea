<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AreaUrbanizacionMedio
 *
 * @ORM\Table(name="area_urbanizacion_medio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AreaUrbanizacionMedioRepository")
 */
class AreaUrbanizacionMedio
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
     * @ORM\Column(name="ofertaNuevaVivienda", type="integer", nullable=true)
     */
    private $ofertaNuevaVivienda;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aspectoSocioEconomico", type="integer", nullable=true)
     */
    private $aspectoSocioEconomico;

    /**
     * @var int|null
     *
     * @ORM\Column(name="incrementoTraficoVehicular", type="integer", nullable=true)
     */
    private $incrementoTraficoVehicular;

    /**
     * @var int|null
     *
     * @ORM\Column(name="afectacionMedioFisico", type="integer", nullable=true)
     */
    private $afectacionMedioFisico;

    /**
     * @var int|null
     *
     * @ORM\Column(name="usoAguasSubterranea", type="integer", nullable=true)
     */
    private $usoAguasSubterranea;

    /**
     * @var string|null
     *
     * @ORM\Column(name="otros", type="string", length=45, nullable=true)
     */
    private $otros;

    /**
     * @ORM\ManyToOne(targetEntity="Urbanizacion", inversedBy="AreaUrbanizacionMedio")
     * @ORM\JoinColumn(name="urbanizacion_id", referencedColumnName="id")
     */
    private $urbanizacion;


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
     * Set ofertaNuevaVivienda.
     *
     * @param int|null $ofertaNuevaVivienda
     *
     * @return AreaUrbanizacionMedio
     */
    public function setOfertaNuevaVivienda($ofertaNuevaVivienda = null)
    {
        $this->ofertaNuevaVivienda = $ofertaNuevaVivienda;

        return $this;
    }

    /**
     * Get ofertaNuevaVivienda.
     *
     * @return int|null
     */
    public function getOfertaNuevaVivienda()
    {
        return $this->ofertaNuevaVivienda;
    }

    /**
     * Set aspectoSocioEconomico.
     *
     * @param int|null $aspectoSocioEconomico
     *
     * @return AreaUrbanizacionMedio
     */
    public function setAspectoSocioEconomico($aspectoSocioEconomico = null)
    {
        $this->aspectoSocioEconomico = $aspectoSocioEconomico;

        return $this;
    }

    /**
     * Get aspectoSocioEconomico.
     *
     * @return int|null
     */
    public function getAspectoSocioEconomico()
    {
        return $this->aspectoSocioEconomico;
    }

    /**
     * Set incrementoTraficoVehicular.
     *
     * @param int|null $incrementoTraficoVehicular
     *
     * @return AreaUrbanizacionMedio
     */
    public function setIncrementoTraficoVehicular($incrementoTraficoVehicular = null)
    {
        $this->incrementoTraficoVehicular = $incrementoTraficoVehicular;

        return $this;
    }

    /**
     * Get incrementoTraficoVehicular.
     *
     * @return int|null
     */
    public function getIncrementoTraficoVehicular()
    {
        return $this->incrementoTraficoVehicular;
    }

    /**
     * Set afectacionMedioFisico.
     *
     * @param int|null $afectacionMedioFisico
     *
     * @return AreaUrbanizacionMedio
     */
    public function setAfectacionMedioFisico($afectacionMedioFisico = null)
    {
        $this->afectacionMedioFisico = $afectacionMedioFisico;

        return $this;
    }

    /**
     * Get afectacionMedioFisico.
     *
     * @return int|null
     */
    public function getAfectacionMedioFisico()
    {
        return $this->afectacionMedioFisico;
    }

    /**
     * Set usoAguasSubterranea.
     *
     * @param int|null $usoAguasSubterranea
     *
     * @return AreaUrbanizacionMedio
     */
    public function setUsoAguasSubterranea($usoAguasSubterranea = null)
    {
        $this->usoAguasSubterranea = $usoAguasSubterranea;

        return $this;
    }

    /**
     * Get usoAguasSubterranea.
     *
     * @return int|null
     */
    public function getUsoAguasSubterranea()
    {
        return $this->usoAguasSubterranea;
    }

    /**
     * Set otros.
     *
     * @param string|null $otros
     *
     * @return AreaUrbanizacionMedio
     */
    public function setOtros($otros = null)
    {
        $this->otros = $otros;

        return $this;
    }

    /**
     * Get otros.
     *
     * @return string|null
     */
    public function getOtros()
    {
        return $this->otros;
    }

    /**
     * Get urbanizacion.
     *
     * @return Urbanizacion
     */
    public function getUrbanizacion()
    {
        return $this->urbanizacion;
    }
    
    /**
     * Set urbanizacion.
     *
     * @param Urbanizacion $urbanizacion
     *
     * @return Urbanizacion
     */
    public function setUrbanizacion($urbanizacion)
    {
        $this->urbanizacion = $urbanizacion;

        return $this;
    }
}
