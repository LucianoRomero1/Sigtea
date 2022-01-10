<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tramite
 *
 * @ORM\Table(name="tramite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TramiteRepository")
 */
class Tramite
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
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="tramite")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_creacion", type="datetime")
     */
    private $fechaCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modificacion", type="datetime",nullable=true)
     */
    private $fechaModificacion;

    /**
     * @ORM\OneToMany(targetEntity="Formulario", mappedBy="tramite")
     */
    protected $formulario;

    /**
     * @ORM\OneToOne(targetEntity="Perito")
     * @ORM\JoinColumn(name="perito_id", referencedColumnName="id")
     */
    private $perito;
    
    /**
     * @ORM\OneToOne(targetEntity="Empresa")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->formulario = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Tramite
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
     * Set estado.
     *
     * @param Estado $estado
     *
     * @return Estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado.
     *
     * @return Estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fechaCreacion.
     *
     * @param string $fechaCreacion
     *
     * @return Tramite
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion.
     *
     * @return string
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaModificacion.
     *
     * @param \DateTime $fechaModificacion
     *
     * @return Tramite
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion.
     *
     * @return \DateTime
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

    /**
     * Set perito.
     *
     * @param Perito $perito
     *
     * @return Perito
     */
    public function setPerito($perito)
    {
        $this->perito = $perito;

        return $this;
    }

    /**
     * Get perito.
     *
     * @return Perito
     */
    public function getPerito()
    {
        return $this->perito;
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
}
