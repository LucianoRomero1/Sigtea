<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Impacto
 *
 * @ORM\Table(name="impacto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImpactoRepository")
 */
class Impacto
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
     * @ORM\Column(name="descripcion", type="string", length=45, nullable=true)
     */
    private $descripcion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="proceso", type="string", length=45, nullable=true)
     */
    private $proceso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contaminante_relevante", type="string", length=45, nullable=true)
     */
    private $contaminanteRelevante;

    /**
     * @var string|null
     *
     * @ORM\Column(name="medida_mitigacion", type="string", length=45, nullable=true)
     */
    private $medidaMitigacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="plan_monitoreo", type="string", length=45, nullable=true)
     */
    private $planMonitoreo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="medida_implementacion", type="string", length=1800, nullable=true)
     */
    private $medidaImplementacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="plazo", type="string", length=300, nullable=true)
     */
    private $plazo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="parametro_monitoreo", type="string", length=300, nullable=true)
     */
    private $parametroMonitoreo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="frecuencia", type="string", length=300, nullable=true)
     */
    private $frecuencia;

    /**
     * @var string|null
     *
     * @ORM\Column(name="punto_muestreo", type="string", length=300, nullable=true)
     */
    private $puntoMuestreo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="normativa_referencia", type="string", length=300, nullable=true)
     */
    private $normativaReferencia;
   
    /**
     * @var string|null
     *
     * @ORM\Column(name="caudal", type="string", length=255, nullable=true)
     */
    private $caudal;
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="cuerpo_receptor", type="string", length=255, nullable=true)
     */
    private $cuerpoReceptor;
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="prevencion", type="string", length=255, nullable=true)
     */
    private $prevencion;
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="consecuencia", type="string", length=255, nullable=true)
     */
    private $consecuencia;

    /**
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="impacto")
     * @ORM\JoinColumn(name="planta_id", referencedColumnName="id")
     */
    private $planta;

    /**
     * @ORM\ManyToOne(targetEntity="TipoImpacto", inversedBy="impacto")
     * @ORM\JoinColumn(name="tipo_impacto_id", referencedColumnName="id")
     */
    private $tipoImpacto;
    
    /**
     * @ORM\OneToOne(targetEntity="Storage")
     * @ORM\JoinColumn(name="storage_id", referencedColumnName="id")
     */
    //private $storage;


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
     * @return Impacto
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
     * Set proceso.
     *
     * @param string|null $proceso
     *
     * @return Impacto
     */
    public function setProceso($proceso = null)
    {
        $this->proceso = $proceso;

        return $this;
    }

    /**
     * Get proceso.
     *
     * @return string|null
     */
    public function getProceso()
    {
        return $this->proceso;
    }

    /**
     * Set contaminanteRelevante.
     *
     * @param string|null $contaminanteRelevante
     *
     * @return Impacto
     */
    public function setContaminanteRelevante($contaminanteRelevante = null)
    {
        $this->contaminanteRelevante = $contaminanteRelevante;

        return $this;
    }

    /**
     * Get contaminanteRelevante.
     *
     * @return string|null
     */
    public function getContaminanteRelevante()
    {
        return $this->contaminanteRelevante;
    }

    /**
     * Set medidaMitigacion.
     *
     * @param string|null $medidaMitigacion
     *
     * @return Impacto
     */
    public function setMedidaMitigacion($medidaMitigacion = null)
    {
        $this->medidaMitigacion = $medidaMitigacion;

        return $this;
    }

    /**
     * Get medidaMitigacion.
     *
     * @return string|null
     */
    public function getMedidaMitigacion()
    {
        return $this->medidaMitigacion;
    }

    /**
     * Set planMonitoreo.
     *
     * @param string|null $planMonitoreo
     *
     * @return Impacto
     */
    public function setPlanMonitoreo($planMonitoreo = null)
    {
        $this->planMonitoreo = $planMonitoreo;

        return $this;
    }

    /**
     * Get planMonitoreo.
     *
     * @return string|null
     */
    public function getPlanMonitoreo()
    {
        return $this->planMonitoreo;
    }

    /**
     * Set medidaImplementacion.
     *
     * @param string|null $medidaImplementacion
     *
     * @return Impacto
     */
    public function setMedidaImplementacion($medidaImplementacion = null)
    {
        $this->medidaImplementacion = $medidaImplementacion;

        return $this;
    }

    /**
     * Get medidaImplementacion.
     *
     * @return string|null
     */
    public function getMedidaImplementacion()
    {
        return $this->medidaImplementacion;
    }

    /**
     * Set plazo.
     *
     * @param string|null $plazo
     *
     * @return Impacto
     */
    public function setPlazo($plazo = null)
    {
        $this->plazo = $plazo;

        return $this;
    }

    /**
     * Get plazo.
     *
     * @return string|null
     */
    public function getPlazo()
    {
        return $this->plazo;
    }

    /**
     * Set parametroMonitoreo.
     *
     * @param string|null $parametroMonitoreo
     *
     * @return Impacto
     */
    public function setParametroMonitoreo($parametroMonitoreo = null)
    {
        $this->parametroMonitoreo = $parametroMonitoreo;

        return $this;
    }

    /**
     * Get parametroMonitoreo.
     *
     * @return string|null
     */
    public function getParametroMonitoreo()
    {
        return $this->parametroMonitoreo;
    }

    /**
     * Set frecuencia.
     *
     * @param string|null $frecuencia
     *
     * @return Impacto
     */
    public function setFrecuencia($frecuencia = null)
    {
        $this->frecuencia = $frecuencia;

        return $this;
    }

    /**
     * Get frecuencia.
     *
     * @return string|null
     */
    public function getFrecuencia()
    {
        return $this->frecuencia;
    }

    /**
     * Set puntoMuestreo.
     *
     * @param string|null $puntoMuestreo
     *
     * @return Impacto
     */
    public function setPuntoMuestreo($puntoMuestreo = null)
    {
        $this->puntoMuestreo = $puntoMuestreo;

        return $this;
    }

    /**
     * Get puntoMuestreo.
     *
     * @return string|null
     */
    public function getPuntoMuestreo()
    {
        return $this->puntoMuestreo;
    }

    /**
     * Set normativaReferencia.
     *
     * @param string|null $normativaReferencia
     *
     * @return Impacto
     */
    public function setNormativaReferencia($normativaReferencia = null)
    {
        $this->normativaReferencia = $normativaReferencia;

        return $this;
    }

    /**
     * Get normativaReferencia.
     *
     * @return string|null
     */
    public function getNormativaReferencia()
    {
        return $this->normativaReferencia;
    }
    
    /**
     * Set caudal.
     *
     * @param string|null $caudal
     *
     * @return Impacto
     */
    public function setCaudal($caudal = null)
    {
        $this->caudal = $caudal;

        return $this;
    }

    /**
     * Get caudal.
     *
     * @return string|null
     */
    public function getCaudal()
    {
        return $this->caudal;
    }
    
    /**
     * Set cuerpoReceptor.
     *
     * @param string|null $cuerpoReceptor
     *
     * @return Impacto
     */
    public function setCuerpoReceptor($cuerpoReceptor = null)
    {
        $this->cuerpoReceptor = $cuerpoReceptor;

        return $this;
    }

    /**
     * Get cuerpoReceptor.
     *
     * @return string|null
     */
    public function getCuerpoReceptor()
    {
        return $this->cuerpoReceptor;
    }
    
    /**
     * Set prevencion.
     *
     * @param string|null $prevencion
     *
     * @return Impacto
     */
    public function setPrevencion($prevencion = null)
    {
        $this->prevencion = $prevencion;

        return $this;
    }

    /**
     * Get prevencion.
     *
     * @return string|null
     */
    public function getPrevencion()
    {
        return $this->prevencion;
    }

    /**
     * Set consecuencia.
     *
     * @param string|null $consecuencia
     *
     * @return Impacto
     */
    public function setConsecuencia($consecuencia = null)
    {
        $this->consecuencia = $consecuencia;

        return $this;
    }

    /**
     * Get consecuencia.
     *
     * @return string|null
     */
    public function getConsecuencia()
    {
        return $this->consecuencia;
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
     * Set tipoImpacto.
     *
     * @param TipoImpacto $tipoImpacto
     *
     * @return TipoImpacto
     */
    public function setTipoImpacto($tipoImpacto)
    {
        $this->tipoImpacto = $tipoImpacto;

        return $this;
    }

    /**
     * Get tipoImpacto.
     *
     * @return TipoImpacto
     */
    public function getTipoImpacto()
    {
        return $this->tipoImpacto;
    }
}
