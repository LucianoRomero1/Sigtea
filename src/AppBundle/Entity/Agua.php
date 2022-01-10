<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agua
 *
 * @ORM\Table(name="agua")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AguaRepository")
 */
class Agua
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
     * @ORM\Column(name="nombre", type="string", length=45, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="ubicacionPlano", type="string", length=100, nullable=true)
     */
    private $ubicacionPlano;

    /**
     * @var float
     *
     * @ORM\Column(name="cantidad", type="float", nullable=true)
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="unidad", type="string", length=50, nullable=true)
     */
    private $unidad;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tiempo", type="string", length=50, nullable=true)
     */
    private $tiempo;

    /**
     * @var int
     *
     * @ORM\Column(name="nro_perforacion", type="integer", nullable=true)
     */
    private $nroPerforacion;
    
    /**
     * @var int
     *
     * @ORM\Column(name="tipo", type="integer", nullable=true)
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="Recurso", inversedBy="agua")
     * @ORM\JoinColumn(name="recurso_id", referencedColumnName="id")
     */
    private $recurso;

    
    /**
     * @ORM\OneToOne(targetEntity="TipoAgua")
     * @ORM\JoinColumn(name="tipo_agua_id", referencedColumnName="id")
     */
    public $tipoAgua;


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
     * Set tipo.
     *
     * @param int $tipo
     *
     * @return Agua
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
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return Agua
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
     * Set ubicacionPlano.
     *
     * @param string|null $ubicacionPlano
     *
     * @return Agua
     */
    public function setUbicacionPlano($ubicacionPlano= null)
    {
        $this->ubicacionPlano = $ubicacionPlano;

        return $this;
    }

    /**
     * Get ubicacionPlano.
     *
     * @return string|null
     */
    public function getUbicacionPlano()
    {
        return $this->ubicacionPlano;
    }

    /**
     * Set cantidad.
     *
     * @param float $cantidad
     *
     * @return Agua
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad.
     *
     * @return float
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set unidad.
     *
     * @param string $unidad
     *
     * @return Agua
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
     * Set tiempo.
     *
     * @param string $tiempo
     *
     * @return Agua
     */
    public function setTiempo($tiempo)
    {
        $this->tiempo = $tiempo;

        return $this;
    }

    /**
     * Get tiempo.
     *
     * @return string
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * Set nroPerforacion.
     *
     * @param int $nroPerforacion
     *
     * @return Agua
     */
    public function setNroPerforacion($nroPerforacion)
    {
        $this->nroPerforacion = $nroPerforacion;

        return $this;
    }

    /**
     * Get nroPerforacion.
     *
     * @return int
     */
    public function getNroPerforacion()
    {
        return $this->nroPerforacion;
    }

    /**
     * Set recurso.
     *
     * @param Recurso $recurso
     *
     * @return Recurso
     */
    public function setRecurso($recurso)
    {
        $this->recurso = $recurso;

        return $this;
    }

    /**
     * Get recurso.
     *
     * @return Recurso
     */
    public function getRecurso()
    {
        return $this->recurso;
    }

    /**
     * Set tipoAgua.
     *
     * @param TipoAgua $tipoAgua
     *
     * @return TipoAgua
     */
    public function setTipoAgua($tipoAgua)
    {
        $this->tipoAgua = $tipoAgua;

        return $this;
    }

    /**
     * Get tipoAgua.
     *
     * @return TipoAgua
     */
    public function getTipoAgua()
    {
        return $this->tipoAgua;
    }
}
