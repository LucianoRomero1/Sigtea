<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Efluente
 *
 * @ORM\Table(name="efluente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EfluenteRepository")
 */
class Efluente
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
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45)
     */
    //private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="tratamiento", type="string", length=45, nullable=true)
     */
    private $tratamiento;

    /**
     * @var string
     *
     * @ORM\Column(name="caudal", type="string", length=45)
     */
    private $caudal;

    /**
     * @var string
     *
     * @ORM\Column(name="proceso_generador", type="string", length=255)
     */
    private $procesoGenerador;

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
     * @var int
     *
     * @ORM\Column(name="descarga", type="smallint")
     */
    private $descarga;

    /**
     * @var string
     *
     * @ORM\Column(name="receptor", type="string", length=255)
     */
    private $receptor;

    /**
     * @var string
     *
     * @ORM\Column(name="componente_relevante", type="string", length=255)
     */
    private $componenteRelevante;

    /**
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="efluente")
     * @ORM\JoinColumn(name="planta_id", referencedColumnName="id")
     */
    private $planta;

    /**
     * @ORM\ManyToOne(targetEntity="EtapaConstructiva", inversedBy="efluente")
     * @ORM\JoinColumn(name="etapa_constructiva_id", referencedColumnName="id")
     */
    private $etapaConstructiva;

    /**
     * @ORM\ManyToOne(targetEntity="EtapaOperativa", inversedBy="efluente")
     * @ORM\JoinColumn(name="etapa_operativa_id", referencedColumnName="id")
     */
    private $etapaOperativa;

    /**
     * @ORM\ManyToOne(targetEntity="TipoEfluente", inversedBy="efluente")
     * @ORM\JoinColumn(name="tipo_efluente_id", referencedColumnName="id")
     */
    private $tipoEfluente;



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
     * @return Efluente
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
     * Get nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return Efluente
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set tratamiento.
     *
     * @param string $tratamiento
     *
     * @return Efluente
     */
    public function setTratamiento($tratamiento)
    {
        $this->tratamiento = $tratamiento;

        return $this;
    }

    /**
     * Get tratamiento.
     *
     * @return string
     */
    public function getTratamiento()
    {
        return $this->tratamiento;
    }

    /**
     * Set caudal.
     *
     * @param string $caudal
     *
     * @return Efluente
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
     * Set tipo.
     *
     * @param string $tipo
     *
     * @return Efluente
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set procesoGenerador.
     *
     * @param string $procesoGenerador
     *
     * @return Efluente
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
     * Set volumen.
     *
     * @param string $volumen
     *
     * @return Efluente
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
     * @return Efluente
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
     * @return Efluente
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
     * @return Efluente
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
     * Set descarga.
     *
     * @param int $descarga
     *
     * @return Efluente
     */
    public function setDescarga($descarga)
    {
        $this->descarga = $descarga;

        return $this;
    }

    /**
     * Get descarga.
     *
     * @return int
     */
    public function getDescarga()
    {
        return $this->descarga;
    }

    /**
     * Set receptor.
     *
     * @param string $receptor
     *
     * @return Efluente
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
     * Set componenteRelevante.
     *
     * @param string $componenteRelevante
     *
     * @return EmisionGaseosa
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
     * Set tipoEfluente.
     *
     * @param TipoEfluente $tipoEfluente
     *
     * @return TipoEfluente
     */
    public function setTipoEfluente($tipoEfluente)
    {
        $this->tipoEfluente = $tipoEfluente;

        return $this;
    }

    /**
     * Get tipoEfluente.
     *
     * @return TipoEfluente
     */
    public function getTipoEfluente()
    {
        return $this->tipoEfluente;
    }
}
