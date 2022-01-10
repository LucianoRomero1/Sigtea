<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AreaMedioUrbanizacion
 *
 * @ORM\Table(name="area_medio_urbanizacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AreaMedioUrbanizacionRepository")
 */
class AreaMedioUrbanizacion
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
     * @ORM\Column(name="actividadIndustrial", type="integer", nullable=true)
     */
    private $actividadIndustrial;

    /**
     * @var int|null
     *
     * @ORM\Column(name="actividadServicio", type="integer", nullable=true)
     */
    private $actividadServicio;

    /**
     * @var int|null
     *
     * @ORM\Column(name="actividadAgropecuaria", type="integer", nullable=true)
     */
    private $actividadAgropecuaria;

    /**
     * @var int|null
     *
     * @ORM\Column(name="plantaTratamiento", type="integer", nullable=true)
     */
    private $plantaTratamiento;

    /**
     * @var int|null
     *
     * @ORM\Column(name="actividadPecuaria", type="integer", nullable=true)
     */
    private $actividadPecuaria;

    /**
     * @var int|null
     *
     * @ORM\Column(name="criaGanado", type="integer", nullable=true)
     */
    private $criaGanado;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aveCorral", type="integer", nullable=true)
     */
    private $aveCorral;

    /**
     * @var int|null
     *
     * @ORM\Column(name="proximidadRuta", type="integer", nullable=true)
     */
    private $proximidadRuta;

    /**
     * @var int|null
     *
     * @ORM\Column(name="transportePublico", type="integer", nullable=true)
     */
    private $transportePublico;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ferrocarriles", type="integer", nullable=true)
     */
    private $ferrocarriles;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aeropuerto", type="integer", nullable=true)
     */
    private $aeropuerto;

    /**
     * @var int|null
     *
     * @ORM\Column(name="actividadAgricola", type="integer", nullable=true)
     */
    private $actividadAgricola;

    /**
     * @var int|null
     *
     * @ORM\Column(name="vertederosRsu", type="integer", nullable=true)
     */
    private $vertederosRsu;

    /**
     * @var int|null
     *
     * @ORM\Column(name="generacionResiduo", type="integer", nullable=true)
     */
    private $generacionResiduo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="otros", type="string", length=45, nullable=true)
     */
    private $otros;

    /**
     * @ORM\ManyToOne(targetEntity="Urbanizacion", inversedBy="AreaMedioUrbanizacion")
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
     * Set actividadIndustrial.
     *
     * @param int|null $actividadIndustrial
     *
     * @return AreaMedioUrbanizacion
     */
    public function setActividadIndustrial($actividadIndustrial = null)
    {
        $this->actividadIndustrial = $actividadIndustrial;

        return $this;
    }

    /**
     * Get actividadIndustrial.
     *
     * @return int|null
     */
    public function getActividadIndustrial()
    {
        return $this->actividadIndustrial;
    }

    /**
     * Set actividadServicio.
     *
     * @param int|null $actividadServicio
     *
     * @return AreaMedioUrbanizacion
     */
    public function setActividadServicio($actividadServicio = null)
    {
        $this->actividadServicio = $actividadServicio;

        return $this;
    }

    /**
     * Get actividadServicio.
     *
     * @return int|null
     */
    public function getActividadServicio()
    {
        return $this->actividadServicio;
    }

    /**
     * Set actividadAgropecuaria.
     *
     * @param int|null $actividadAgropecuaria
     *
     * @return AreaMedioUrbanizacion
     */
    public function setActividadAgropecuaria($actividadAgropecuaria = null)
    {
        $this->actividadAgropecuaria = $actividadAgropecuaria;

        return $this;
    }

    /**
     * Get actividadAgropecuaria.
     *
     * @return int|null
     */
    public function getActividadAgropecuaria()
    {
        return $this->actividadAgropecuaria;
    }

    /**
     * Set plantaTratamiento.
     *
     * @param int|null $plantaTratamiento
     *
     * @return AreaMedioUrbanizacion
     */
    public function setPlantaTratamiento($plantaTratamiento = null)
    {
        $this->plantaTratamiento = $plantaTratamiento;

        return $this;
    }

    /**
     * Get plantaTratamiento.
     *
     * @return int|null
     */
    public function getPlantaTratamiento()
    {
        return $this->plantaTratamiento;
    }

    /**
     * Set actividadPecuaria.
     *
     * @param int|null $actividadPecuaria
     *
     * @return AreaMedioUrbanizacion
     */
    public function setActividadPecuaria($actividadPecuaria = null)
    {
        $this->actividadPecuaria = $actividadPecuaria;

        return $this;
    }

    /**
     * Get actividadPecuaria.
     *
     * @return int|null
     */
    public function getActividadPecuaria()
    {
        return $this->actividadPecuaria;
    }

    /**
     * Set criaGanado.
     *
     * @param int|null $criaGanado
     *
     * @return AreaMedioUrbanizacion
     */
    public function setCriaGanado($criaGanado = null)
    {
        $this->criaGanado = $criaGanado;

        return $this;
    }

    /**
     * Get criaGanado.
     *
     * @return int|null
     */
    public function getCriaGanado()
    {
        return $this->criaGanado;
    }

    /**
     * Set aveCorral.
     *
     * @param int|null $aveCorral
     *
     * @return AreaMedioUrbanizacion
     */
    public function setAveCorral($aveCorral = null)
    {
        $this->aveCorral = $aveCorral;

        return $this;
    }

    /**
     * Get aveCorral.
     *
     * @return int|null
     */
    public function getAveCorral()
    {
        return $this->aveCorral;
    }

    /**
     * Set proximidadRuta.
     *
     * @param int|null $proximidadRuta
     *
     * @return AreaMedioUrbanizacion
     */
    public function setProximidadRuta($proximidadRuta = null)
    {
        $this->proximidadRuta = $proximidadRuta;

        return $this;
    }

    /**
     * Get proximidadRuta.
     *
     * @return int|null
     */
    public function getProximidadRuta()
    {
        return $this->proximidadRuta;
    }

    /**
     * Set transportePublico.
     *
     * @param int|null $transportePublico
     *
     * @return AreaMedioUrbanizacion
     */
    public function setTransportePublico($transportePublico = null)
    {
        $this->transportePublico = $transportePublico;

        return $this;
    }

    /**
     * Get transportePublico.
     *
     * @return int|null
     */
    public function getTransportePublico()
    {
        return $this->transportePublico;
    }

    /**
     * Set ferrocarriles.
     *
     * @param int|null $ferrocarriles
     *
     * @return AreaMedioUrbanizacion
     */
    public function setFerrocarriles($ferrocarriles = null)
    {
        $this->ferrocarriles = $ferrocarriles;

        return $this;
    }

    /**
     * Get ferrocarriles.
     *
     * @return int|null
     */
    public function getFerrocarriles()
    {
        return $this->ferrocarriles;
    }

    /**
     * Set aeropuerto.
     *
     * @param int|null $aeropuerto
     *
     * @return AreaMedioUrbanizacion
     */
    public function setAeropuerto($aeropuerto = null)
    {
        $this->aeropuerto = $aeropuerto;

        return $this;
    }

    /**
     * Get aeropuerto.
     *
     * @return int|null
     */
    public function getAeropuerto()
    {
        return $this->aeropuerto;
    }

    /**
     * Set actividadAgricola.
     *
     * @param int|null $actividadAgricola
     *
     * @return AreaMedioUrbanizacion
     */
    public function setActividadAgricola($actividadAgricola = null)
    {
        $this->actividadAgricola = $actividadAgricola;

        return $this;
    }

    /**
     * Get actividadAgricola.
     *
     * @return int|null
     */
    public function getActividadAgricola()
    {
        return $this->actividadAgricola;
    }

    /**
     * Set vertederosRsu.
     *
     * @param int|null $vertederosRsu
     *
     * @return AreaMedioUrbanizacion
     */
    public function setVertederosRsu($vertederosRsu = null)
    {
        $this->vertederosRsu = $vertederosRsu;

        return $this;
    }

    /**
     * Get vertederosRsu.
     *
     * @return int|null
     */
    public function getVertederosRsu()
    {
        return $this->vertederosRsu;
    }

    /**
     * Set generacionResiduo.
     *
     * @param int|null $generacionResiduo
     *
     * @return AreaMedioUrbanizacion
     */
    public function setGeneracionResiduo($generacionResiduo = null)
    {
        $this->generacionResiduo = $generacionResiduo;

        return $this;
    }

    /**
     * Get generacionResiduo.
     *
     * @return int|null
     */
    public function getGeneracionResiduo()
    {
        return $this->generacionResiduo;
    }

    /**
     * Set otros.
     *
     * @param string|null $otros
     *
     * @return AreaMedioUrbanizacion
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
