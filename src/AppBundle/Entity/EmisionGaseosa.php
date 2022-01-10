<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmisionGaseosa
 *
 * @ORM\Table(name="emision_gaseosa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmisionGaseosaRepository")
 */
class EmisionGaseosa
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
     * @ORM\Column(name="nombre", type="string", length=45)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="funcionamiento", type="string", length=45)
     */
    private $funcionamiento;

    /**
     * @var string
     *
     * @ORM\Column(name="caudal", type="string", length=45)
     */
    private $caudal;

    /**
     * @var string
     *
     * @ORM\Column(name="chimenea", type="string", length=255)
     */
    private $chimenea;

    /**
     * @var string
     *
     * @ORM\Column(name="contaminante", type="string", length=200)
     */
    private $contaminante;

    /**
     * @var string
     *
     * @ORM\Column(name="sitio", type="string", length=45)
     */
    private $sitio;

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
     * @ORM\Column(name="emision", type="string", length=255)
     */
    private $emision;

    /**
     * @var string
     *
     * @ORM\Column(name="proceso_generador", type="string", length=255)
     */
    private $procesoGenerador;

    /**
     * @var string
     *
     * @ORM\Column(name="tratamiento", type="string", length=255)
     */
    private $tratamiento;

    /**
     * @var string
     *
     * @ORM\Column(name="componente_relevante", type="string", length=255)
     */
    private $componenteRelevante;

    /**
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="emisionGaseosa")
     * @ORM\JoinColumn(name="planta_id", referencedColumnName="id")
     */
    private $planta;

    /**
     * @ORM\ManyToOne(targetEntity="EtapaConstructiva", inversedBy="emisionGaseosa")
     * @ORM\JoinColumn(name="etapa_constructiva_id", referencedColumnName="id")
     */
    private $etapaConstructiva;

    /**
     * @ORM\ManyToOne(targetEntity="EtapaOperativa", inversedBy="emisionGaseosa")
     * @ORM\JoinColumn(name="etapa_operativa_id", referencedColumnName="id")
     */
    private $etapaOperativa;

    /**
     * @ORM\ManyToOne(targetEntity="TipoEmision", inversedBy="emisionGaseosa")
     * @ORM\JoinColumn(name="tipo_emision_id", referencedColumnName="id")
     */
    private $tipoEmision;


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
     * @return EmisionGaseosa
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
     * @param string $tipo
     *
     * @return EmisionGaseosa
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
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return EmisionGaseosa
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
     * Get funcionamiento.
     *
     * @return string
     */
    public function getFuncionamiento()
    {
        return $this->funcionamiento;
    }

    /**
     * Set funcionamiento.
     *
     * @param string $funcionamiento
     *
     * @return EmisionGaseosa
     */
    public function setFuncionamiento($funcionamiento)
    {
        $this->funcionamiento = $funcionamiento;

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
     * Set caudal.
     *
     * @param string $caudal
     *
     * @return EmisionGaseosa
     */
    public function setCaudal($caudal)
    {
        $this->caudal = $caudal;

        return $this;
    }

    /**
     * Get chimenea.
     *
     * @return string
     */
    public function getChimenea()
    {
        return $this->chimenea;
    }

    /**
     * Set chimenea.
     *
     * @param string $chimenea
     *
     * @return EmisionGaseosa
     */
    public function setChimenea($chimenea)
    {
        $this->chimenea = $chimenea;

        return $this;
    }

    /**
     * Get contaminante.
     *
     * @return string
     */
    public function getContaminante()
    {
        return $this->contaminante;
    }

    /**
     * Set contaminante.
     *
     * @param string $contaminante
     *
     * @return EmisionGaseosa
     */
    public function setContaminante($contaminante)
    {
        $this->contaminante = $contaminante;

        return $this;
    }

    /**
     * Get sitio.
     *
     * @return string
     */
    public function getSitio()
    {
        return $this->sitio;
    }

    /**
     * Set sitio.
     *
     * @param string $sitio
     *
     * @return EmisionGaseosa
     */
    public function setSitio($sitio)
    {
        $this->sitio = $sitio;

        return $this;
    }


    /**
     * Set emision.
     *
     * @param string $emision
     *
     * @return EmisionGaseosa
     */
    public function setEmision($emision)
    {
        $this->emision = $emision;

        return $this;
    }

    /**
     * Get emision.
     *
     * @return string
     */
    public function getEmision()
    {
        return $this->emision;
    }

    /**
     * Set procesoGenerador.
     *
     * @param string $procesoGenerador
     *
     * @return EmisionGaseosa
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
     * Set tratamiento.
     *
     * @param string $tratamiento
     *
     * @return EmisionGaseosa
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
     * Set tipoEmision.
     *
     * @param TipoEmision $tipoEmision
     *
     * @return TipoEmision
     */
    public function setTipoEmision($tipoEmision)
    {
        $this->tipoEmision = $tipoEmision;

        return $this;
    }

    /**
     * Get tipoEmision.
     *
     * @return TipoEmision
     */
    public function getTipoEmision()
    {
        return $this->tipoEmision;
    }
}
