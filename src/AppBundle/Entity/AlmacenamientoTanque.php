<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AlmacenamientoTanque
 *
 * @ORM\Table(name="almacenamiento_tanque")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AlmacenamientoTanqueRepository")
 */
class AlmacenamientoTanque
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
     * @var int
     *
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_tanque", type="string", length=255)
     */
    private $tipoTanque;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="sustancia", type="string", length=255)
     */
    private $sustancia;
    
    /**
     * @var string
     *
     * @ORM\Column(name="presion", type="string", length=50)
     */
    private $presion;

    /**
     * @var int
     *
     * @ORM\Column(name="capacidad", type="integer")
     */
    private $capacidad;

    /**
     * @ORM\ManyToOne(targetEntity="TipoAlmacenamiento", inversedBy="almacenamientoTanque")
     * @ORM\JoinColumn(name="tipo_almacenamiento_id", referencedColumnName="id")
     */
    private $tipoAlmacenamiento;  
    
    /**
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="almacenamientoTanque")
     * @ORM\JoinColumn(name="planta_id", referencedColumnName="id")
     */
    private $planta;  

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
     * Set numero.
     *
     * @param int $numero
     *
     * @return AlmacenamientoTanque
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero.
     *
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set tipoTanque.
     *
     * @param string $tipoTanque
     *
     * @return AlmacenamientoTanque
     */
    public function setTipoTanque($tipoTanque)
    {
        $this->tipoTanque = $tipoTanque;

        return $this;
    }

    /**
     * Get tipoTanque.
     *
     * @return string
     */
    public function getTipoTanque()
    {
        return $this->tipoTanque;
    }

    /**
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return AlmacenamientoTanque
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
     * Set descripcion.
     *
     * @param string $descripcion
     *
     * @return AlmacenamientoTanque
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion.
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set sustancia.
     *
     * @param string $sustancia
     *
     * @return AlmacenamientoTanque
     */
    public function setSustancia($sustancia)
    {
        $this->sustancia = $sustancia;

        return $this;
    }

    /**
     * Get sustancia.
     *
     * @return string
     */
    public function getSustancia()
    {
        return $this->sustancia;
    }
    
    /**
     * Set presion.
     *
     * @param string $presion
     *
     * @return AlmacenamientoTanque
     */
    public function setPresion($presion)
    {
        $this->presion = $presion;

        return $this;
    }

    /**
     * Get presion.
     *
     * @return string
     */
    public function getPresion()
    {
        return $this->presion;
    }

    /**
     * Set capacidad.
     *
     * @param int $capacidad
     *
     * @return AlmacenamientoTanque
     */
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    /**
     * Get capacidad.
     *
     * @return int
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }
    
    /**
     * Set tipoAlmacenamiento.
     *
     * @param TipoAlmacenamiento $tipoAlmacenamiento
     *
     * @return TipoAlmacenamiento
     */
    public function setTipoAlmacenamiento($tipoAlmacenamiento)
    {
        $this->tipoAlmacenamiento = $tipoAlmacenamiento;

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
     * Get tipoAlmacenamiento.
     *
     * @return TipoAlmacenamiento
     */
    public function getTipoAlmacenamiento()
    {
        return $this->tipoAlmacenamiento;
    }
}
