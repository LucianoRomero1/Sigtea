<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DestinoSuelo
 *
 * @ORM\Table(name="destino_suelo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DestinoSueloRepository")
 */
class DestinoSuelo
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
     * @ORM\Column(name="tipo", type="string", length=255, nullable=true)
     */
    private $tipo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var int|null
     *
     * @ORM\Column(name="superficie", type="integer", nullable=true)
     */
    private $superficie;

    /**
     * @var int|null
     *
     * @ORM\Column(name="porcentaje", type="integer", nullable=true)
     */
    private $porcentaje;

    
    /**
     * @ORM\ManyToOne(targetEntity="Urbanizacion", inversedBy="destinoSuelo")
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
     * Set tipo.
     *
     * @param string|null $tipo
     *
     * @return DestinoSuelo
     */
    public function setTipo($tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return string|null
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set nombre.
     *
     * @param string|null $nombre
     *
     * @return DestinoSuelo
     */
    public function setNombre($nombre = null)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string|null
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set superficie.
     *
     * @param int|null $superficie
     *
     * @return DestinoSuelo
     */
    public function setSuperficie($superficie = null)
    {
        $this->superficie = $superficie;

        return $this;
    }

    /**
     * Get superficie.
     *
     * @return int|null
     */
    public function getSuperficie()
    {
        return $this->superficie;
    }

    /**
     * Set porcentaje.
     *
     * @param int|null $porcentaje
     *
     * @return DestinoSuelo
     */
    public function setPorcentaje($porcentaje = null)
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * Get porcentaje.
     *
     * @return int|null
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
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

    /**
     * Get urbanizacion.
     *
     * @return Urbanizacion
     */
    public function getUrbanizacion()
    {
        return $this->urbanizacion;
    }
}
