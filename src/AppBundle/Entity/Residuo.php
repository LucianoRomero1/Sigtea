<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Residuo
 *
 * @ORM\Table(name="residuo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResiduoRepository")
 */
class Residuo
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
     * @ORM\Column(name="categoria", type="string", length=255)
     */
    private $categoria;

    /**
     * @var int
     *
     * @ORM\Column(name="tipo", type="integer")
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="proceso_generador", type="string", length=255)
     */
    private $procesoGenerador;

    /**
     * @var string
     *
     * @ORM\Column(name="componente_relevante", type="string", length=255)
     */
    private $componenteRelevante;

    /**
     * @var string
     *
     * @ORM\Column(name="volumen", type="string", length=255)
     */
    private $volumen;

    /**
     * @var string
     *
     * @ORM\Column(name="unidad", type="string", length=255)
     */
    private $unidad;

    /**
     * @var string
     *
     * @ORM\Column(name="periodo_tiempo", type="string", length=255)
     */
    private $periodoTiempo;

    /**
     * @var string
     *
     * @ORM\Column(name="gestion", type="string", length=255)
     */
    private $gestion;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_fisico", type="string", length=45)
     */
    private $estadoFisico;

    /**
     * @var int
     *
     * @ORM\Column(name="nro_generador", type="integer")
     */
    private $nroGenerador;

    /**
     * @var string
     *
     * @ORM\Column(name="receptor", type="string", length=250)
     */
    private $receptor;

    /**
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="residuo")
     * @ORM\JoinColumn(name="planta_id", referencedColumnName="id")
     */
    private $planta;

    /**
     * @ORM\ManyToOne(targetEntity="EtapaConstructiva", inversedBy="residuo")
     * @ORM\JoinColumn(name="etapa_constructiva_id", referencedColumnName="id")
     */
    private $etapaConstructiva;

    /**
     * @ORM\ManyToOne(targetEntity="EtapaOperativa", inversedBy="residuo")
     * @ORM\JoinColumn(name="etapa_operativa_id", referencedColumnName="id")
     */
    private $etapaOperativa;

    /**
     * @ORM\ManyToOne(targetEntity="TipoResiduo", inversedBy="residuo")
     * @ORM\JoinColumn(name="tipo_residuo_id", referencedColumnName="id")
     */
    private $tipoResiduo;

    /**
     * @ORM\ManyToOne(targetEntity="CategoriaResiduoPeligroso", inversedBy="residuo")
     * @ORM\JoinColumn(name="categoria_residuo_peligroso_id", referencedColumnName="id")
     */
    private $categoriaResiduoPeligroso;

    /**
     * @ORM\OneToMany(targetEntity="TratamientoPlantaExterior", mappedBy="residuo")
     */
    private $tratamientoPlanta;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tratamiento_planta_exterior = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set categoria.
     *
     * @param string $categoria
     *
     * @return Residuo
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria.
     *
     * @return string
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set tipo.
     *
     * @param int $tipo
     *
     * @return Residuo
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
     * Set nroGenerador.
     *
     * @param int $nroGenerador
     *
     * @return Residuo
     */
    public function setNroGenerador($nroGenerador)
    {
        $this->nroGenerador = $nroGenerador;

        return $this;
    }

    /**
     * Get nroGenerador.
     *
     * @return int
     */
    public function getNroGenerador()
    {
        return $this->nroGenerador;
    }

    /**
     * Set procesoGenerador.
     *
     * @param string $procesoGenerador
     *
     * @return Residuo
     */
    public function setProcesoGenerador($procesoGenerador)
    {
        $this->procesoGenerador = $procesoGenerador;

        return $this;
    }

    /**
     * Get procesoGenerador.
     *
     * @return string
     */
    public function getProcesoGenerador()
    {
        return $this->procesoGenerador;
    }

    /**
     * Set componenteRelevante.
     *
     * @param string $componenteRelevante
     *
     * @return Residuo
     */
    public function setComponenteRelevante($componenteRelevante)
    {
        $this->componenteRelevante = $componenteRelevante;

        return $this;
    }

    /**
     * Get componenteRelevante.
     *
     * @return string
     */
    public function getComponenteRelevante()
    {
        return $this->componenteRelevante;
    }

    /**
     * Set volumen.
     *
     * @param string $volumen
     *
     * @return Residuo
     */
    public function setVolumen($volumen)
    {
        $this->volumen = $volumen;

        return $this;
    }

    /**
     * Get volumen.
     *
     * @return string
     */
    public function getVolumen()
    {
        return $this->volumen;
    }

    /**
     * Set unidad.
     *
     * @param string $unidad
     *
     * @return Residuo
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
     * Set periodoTiempo.
     *
     * @param string $periodoTiempo
     *
     * @return Residuo
     */
    public function setPeriodoTiempo($periodoTiempo)
    {
        $this->periodoTiempo = $periodoTiempo;

        return $this;
    }

    /**
     * Get periodoTiempo.
     *
     * @return string
     */
    public function getPeriodoTiempo()
    {
        return $this->periodoTiempo;
    }

    /**
     * Set gestion.
     *
     * @param string $gestion
     *
     * @return Residuo
     */
    public function setGestion($gestion)
    {
        $this->gestion = $gestion;

        return $this;
    }

    /**
     * Get gestion.
     *
     * @return string
     */
    public function getGestion()
    {
        return $this->gestion;
    }

    /**
     * Set receptor.
     *
     * @param string $receptor
     *
     * @return Residuo
     */
    public function setReceptor($receptor)
    {
        $this->receptor = $receptor;

        return $this;
    }

    /**
     * Get receptor.
     *
     * @return string
     */
    public function getReceptor()
    {
        return $this->receptor;
    }

    /**
     * Set estadoFisico.
     *
     * @param string $estadoFisico
     *
     * @return Residuo
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
     * Set etapaConstructiva.
     *
     * @param EtapaConstructiva $etapaConstructiva
     *
     * @return EtapaConstructiva
     */
    public function setEtapaConstructiva($etapaConstructiva)
    {
        $this->etapaConstructiva = $etapaConstructiva;

        return $this;
    }

    /**
     * Get etapaConstructiva.
     *
     * @return EtapaConstructiva
     */
    public function getEtapaConstructiva()
    {
        return $this->etapaConstructiva;
    }

    /**
     * Set etapaOperativa.
     *
     * @param EtapaOperativa $etapaOperativa
     *
     * @return EtapaOperativa
     */
    public function setEtapaOperativa($etapaOperativa)
    {
        $this->etapaOperativa = $etapaOperativa;

        return $this;
    }

    /**
     * Get etapaOperativa.
     *
     * @return EtapaOperativa
     */
    public function getEtapaOperativa()
    {
        return $this->etapaOperativa;
    }

    /**
     * Set tipoResiduo.
     *
     * @param TipoResiduo $tipoResiduo
     *
     * @return TipoResiduo
     */
    public function setTipoResiduo($tipoResiduo)
    {
        $this->tipoResiduo = $tipoResiduo;

        return $this;
    }

    /**
     * Get tipoResiduo.
     *
     * @return TipoResiduo
     */
    public function getTipoResiduo()
    {
        return $this->tipoResiduo;
    }

    /**
     * Set categoriaResiduoPeligroso.
     *
     * @param CategoriaResiduoPeligroso $categoriaResiduoPeligroso
     *
     * @return CategoriaResiduoPeligroso
     */
    public function setCategoriaResiduoPeligroso($categoriaResiduoPeligroso)
    {
        $this->categoriaResiduoPeligroso = $categoriaResiduoPeligroso;

        return $this;
    }

    /**
     * Get categoriaResiduoPeligroso.
     *
     * @return CategoriaResiduoPeligroso
     */
    public function getCategoriaResiduoPeligroso()
    {
        return $this->categoriaResiduoPeligroso;
    }
}
