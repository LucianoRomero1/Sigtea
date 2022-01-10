<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Domicilio
 *
 * @ORM\Table(name="domicilio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DomicilioRepository")
 */
class Domicilio
{

    const LEGAL = 1;
    const REAL = 2;
    const FiSCAL = 3;

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
     * @ORM\Column(name="calle", type="string", length=255, nullable=true)
     */
    private $calle;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=255,nullable=true)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="piso", type="string", length=255,nullable=true)
     */
    private $piso;

    /**
     * @var string
     *
     * @ORM\Column(name="depto", type="string", length=255,nullable=true)
     */
    private $depto;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255,nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255,nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="zonificacion", type="integer")
     */
    private $zonificacion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="titular_inmueble", type="string", length=100,nullable=true)
     */
    private $titularInmueble;

    /**
     * @var int
     *
     * @ORM\Column(name="tipo", type="integer")
     */
    private $tipo;

    /**
     * @ORM\OneToMany(targetEntity="Planta", mappedBy="domicilio")
     */
    protected $planta;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="domicilio")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;
    
    /**
     * @ORM\ManyToOne(targetEntity="Provincia", inversedBy="domicilio")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id")
     */
    private $provincia;
    
    /**
     * @ORM\ManyToOne(targetEntity="Localidad", inversedBy="domicilio")
     * @ORM\JoinColumn(name="localidad_id", referencedColumnName="id")
     */
    
     private $localidad;
    
     /**
     * @ORM\ManyToOne(targetEntity="Departamento", inversedBy="domicilio")
     * @ORM\JoinColumn(name="departamento_id", referencedColumnName="id")
     */
    private $departamento;

   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->planta = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set calle.
     *
     * @param string $calle
     *
     * @return Domicilio
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle.
     *
     * @return string
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set numero.
     *
     * @param string $numero
     *
     * @return Domicilio
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero.
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set piso.
     *
     * @param string $piso
     *
     * @return Domicilio
     */
    public function setPiso($piso)
    {
        $this->piso = $piso;

        return $this;
    }

    /**
     * Get piso.
     *
     * @return string
     */
    public function getPiso()
    {
        return $this->piso;
    }

    /**
     * Set depto.
     *
     * @param string $depto
     *
     * @return Domicilio
     */
    public function setDepto($depto)
    {
        $this->depto = $depto;

        return $this;
    }

    /**
     * Get depto.
     *
     * @return string
     */
    public function getDepto()
    {
        return $this->depto;
    }

    /**
     * Set telefono.
     *
     * @param string $telefono
     *
     * @return Domicilio
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono.
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Domicilio
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Set titularInmueble.
     *
     * @param string $titularInmueble
     *
     * @return Domicilio
     */
    public function setTitularInmueble($titularInmueble)
    {
        $this->titularInmueble = $titularInmueble;

        return $this;
    }

    /**
     * Get titularInmueble.
     *
     * @return string
     */
    public function getTitularInmueble()
    {
        return $this->titularInmueble;
    }

    /**
     * Set zonificacion.
     *
     * @param string $zonificacion
     *
     * @return Domicilio
     */
    public function setZonificacion($zonificacion)
    {
        $this->zonificacion = $zonificacion;

        return $this;
    }

    /**
     * Get zonificacion.
     *
     * @return string
     */
    public function getZonificacion()
    {
        return $this->zonificacion;
    }

    /**
     * Set tipo.
     *
     * @param int $tipo
     *
     * @return Domicilio
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
     * Set localidad.
     *
     * @param Localidad $localidad
     *
     * @return Localidad
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad.
     *
     * @return Localidad
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }
    
    /**
     * Set provincia.
     *
     * @param Provincia $provincia
     *
     * @return Provincia
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia.
     *
     * @return Provincia
     */
    public function getProvincia()
    {
        return $this->provincia;
    }
    
    /**
     * Set departamento.
     *
     * @param Departamento $departamento
     *
     * @return Departamento
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento.
     *
     * @return Departamento
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

  
}
