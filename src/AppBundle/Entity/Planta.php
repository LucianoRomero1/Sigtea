<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planta
 *
 * @ORM\Table(name="planta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlantaRepository")
 */
class Planta
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio_actividades", type="datetime")
     */
    private $fechaInicioActividades;

    /**
     * @var int
     *
     * @ORM\Column(name="fuera_provincia", type="integer")
     */
    private $fueraProvincia;

    /**
     * @var float
     *
     * @ORM\Column(name="superficie_deposito", type="float")
     */
    private $superficieDeposito;

    /**
     * @var float
     *
     * @ORM\Column(name="superficie_total", type="float")
     */
    private $superficieTotal;

    /**
     * @var float
     *
     * @ORM\Column(name="superficie_cubierta", type="float")
     */
    private $superficieCubierta;

    /**
     * @var float
     *
     * @ORM\Column(name="potencia_instalada", type="float")
     */
    private $potencioInstalada;

    /**
     * @var string
     *
     * @ORM\Column(name="dotacion_personal", type="string", length=255)
     */
    private $dotacionPersonal;

    /**
     * @var string
     *
     * @ORM\Column(name="periodoServicio", type="string", length=255)
     */
    private $periodoServicio;

    /**
     * @ORM\OneToMany(targetEntity="PartidaInmobiliaria", mappedBy="planta")
     */
    private $partidaInmobiliaria;
    
    /**
     * @ORM\OneToMany(targetEntity="InmuebleAnexo", mappedBy="planta")
     */
    protected $InmuebleAnexo;
    
    /**
     * @ORM\OneToMany(targetEntity="Producto", mappedBy="planta")
     */
    protected $producto;
    
    /**
     * @ORM\OneToMany(targetEntity="SubProducto", mappedBy="planta")
     */
    protected $subProducto;
    
    /**
     * @ORM\OneToMany(targetEntity="MateriaPrima", mappedBy="planta")
     */
    protected $materiaPrima;
    
    /**
     * @ORM\OneToMany(targetEntity="Insumo", mappedBy="planta")
     */
    protected $insumo;
    
    /**
     * @ORM\OneToMany(targetEntity="SustanciaAuxiliar", mappedBy="planta")
     */
    protected $sustanciaAuxiliar;
    
    /**
     * @ORM\OneToMany(targetEntity="SustanciaRiesgosa", mappedBy="planta")
     */
    protected $sustanciaRiesgosa;
    
    /**
     * @ORM\OneToMany(targetEntity="Tanque", mappedBy="planta")
     */
    protected $tanque;
    
    /**
     * @ORM\OneToMany(targetEntity="Servicio", mappedBy="planta")
     */
    protected $servicio;
    
    /**
     * @ORM\OneToMany(targetEntity="DimencionamientoPlanta", mappedBy="planta")
     */
    protected $dimencionamientoPlanta;
   
    /**
     * @ORM\OneToMany(targetEntity="FormacionPersonal", mappedBy="planta")
     */
    protected $formacionPersonal;
   
    /**
     * @ORM\OneToMany(targetEntity="EmisionGaseosa", mappedBy="planta")
     */
    protected $emisionGaseosa;
    
    /**
     * @ORM\OneToMany(targetEntity="Efluente", mappedBy="planta")
     */
    protected $efluente;
    
    /**
     * @ORM\OneToMany(targetEntity="Residuo", mappedBy="planta")
     */
    protected $residuo;
    
    /**
     * @ORM\OneToMany(targetEntity="RiesgoPresunto", mappedBy="planta")
     */
    protected $riesgoPresunto;
    
    /**
     * @ORM\OneToMany(targetEntity="AlmacenamientoTanque", mappedBy="planta")
     */
    protected $almacenamientoTanque;
    
    /**
     * @ORM\OneToMany(targetEntity="Recurso", mappedBy="planta")
     */
    protected $recurso;
    
    /**
     * @ORM\OneToMany(targetEntity="Impacto", mappedBy="planta")
     */
    protected $impacto;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="planta")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;
    
    /**
     * @ORM\ManyToOne(targetEntity="Domicilio", inversedBy="planta")
     * @ORM\JoinColumn(name="domicilio_id", referencedColumnName="id")
     */
    private $domicilio;



    /**
     * @ORM\OneToMany(targetEntity="SitioContaminado", mappedBy="planta")
     */
    private $sitioContaminado;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->partidaInmobiliaria = new \Doctrine\Common\Collections\ArrayCollection();
        $this->InmuebleAnexo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->producto = new \Doctrine\Common\Collections\ArrayCollection();
        $this->subProducto = new \Doctrine\Common\Collections\ArrayCollection();
        $this->materiaPrima = new \Doctrine\Common\Collections\ArrayCollection();
        $this->insumo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sustanciaAuxiliar = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sustanciaRiesgosa = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tanque = new \Doctrine\Common\Collections\ArrayCollection();
        $this->servicio = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dimencionamientoPlanta = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formacionPersonal = new \Doctrine\Common\Collections\ArrayCollection();
        $this->emisionGaseosa = new \Doctrine\Common\Collections\ArrayCollection();
        $this->efluente = new \Doctrine\Common\Collections\ArrayCollection();
        $this->residuo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->riesgoPresunto = new \Doctrine\Common\Collections\ArrayCollection();
        $this->almacenamientoTanque = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recurso = new \Doctrine\Common\Collections\ArrayCollection();
        $this->impacto = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sitioContaminado = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return Planta
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
     * Set fechaInicioActividades.
     *
     * @param \DateTime $fechaInicioActividades
     *
     * @return Planta
     */
    public function setFechaInicioActividades($fechaInicioActividades)
    {
        $this->fechaInicioActividades = $fechaInicioActividades;

        return $this;
    }

    /**
     * Get fechaInicioActividades.
     *
     * @return \DateTime
     */
    public function getFechaInicioActividades()
    {
        return $this->fechaInicioActividades;
    }

    /**
     * Set fueraProvincia.
     *
     * @param int $fueraProvincia
     *
     * @return Planta
     */
    public function setFueraProvincia($fueraProvincia)
    {
        $this->fueraProvincia = $fueraProvincia;

        return $this;
    }

    /**
     * Get fueraProvincia.
     *
     * @return int
     */
    public function getFueraProvincia()
    {
        return $this->fueraProvincia;
    }

    /**
     * Set superficieDeposito.
     *
     * @param float $superficieDeposito
     *
     * @return Planta
     */
    public function setSuperficieDeposito($superficieDeposito)
    {
        $this->superficieDeposito = $superficieDeposito;

        return $this;
    }

    /**
     * Get superficieDeposito.
     *
     * @return float
     */
    public function getSuperficieDeposito()
    {
        return $this->superficieDeposito;
    }

    /**
     * Set superficieTotal.
     *
     * @param float $superficieTotal
     *
     * @return Planta
     */
    public function setSuperficieTotal($superficieTotal)
    {
        $this->superficieTotal = $superficieTotal;

        return $this;
    }

    /**
     * Get superficieTotal.
     *
     * @return float
     */
    public function getSuperficieTotal()
    {
        return $this->superficieTotal;
    }

    /**
     * Set superficieCubierta.
     *
     * @param float $superficieCubierta
     *
     * @return Planta
     */
    public function setSuperficieCubierta($superficieCubierta)
    {
        $this->superficieCubierta = $superficieCubierta;

        return $this;
    }

    /**
     * Get superficieCubierta.
     *
     * @return float
     */
    public function getSuperficieCubierta()
    {
        return $this->superficieCubierta;
    }

    /**
     * Set potencioInstalada.
     *
     * @param float $potencioInstalada
     *
     * @return Planta
     */
    public function setPotencioInstalada($potencioInstalada)
    {
        $this->potencioInstalada = $potencioInstalada;

        return $this;
    }

    /**
     * Get potencioInstalada.
     *
     * @return float
     */
    public function getPotencioInstalada()
    {
        return $this->potencioInstalada;
    }

    /**
     * Set dotacionPersonal.
     *
     * @param string $dotacionPersonal
     *
     * @return Planta
     */
    public function setDotacionPersonal($dotacionPersonal)
    {
        $this->dotacionPersonal = $dotacionPersonal;

        return $this;
    }

    /**
     * Get dotacionPersonal.
     *
     * @return string
     */
    public function getDotacionPersonal()
    {
        return $this->dotacionPersonal;
    }

      /**
     * Set periodoServicio.
     *
     * @param string $periodoServicio
     *
     * @return Planta
     */
    public function setPeriodoServicio($periodoServicio)
    {
        $this->periodoServicio = $periodoServicio;

        return $this;
    }

    /**
     * Get periodoServicio.
     *
     * @return string
     */
    public function getPeriodoServicio()
    {
        return $this->periodoServicio;
    }

    /**
     * Set empresa.
     *
     * @param Empresa $empresa
     *
     * @return Empresa
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa.
     *
     * @return Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set domicilio.
     *
     * @param Domicilio $domicilio
     *
     * @return Domicilio
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio.
     *
     * @return Domicilio
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }
}
