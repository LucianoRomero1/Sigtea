<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * suelo
 *
 * @ORM\Table(name="suelo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\sueloRepository")
 */
class Suelo
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
     * @ORM\Column(name="descripcion_uso", type="string", length=500)
     */
    private $descripcionUso;

    /**
     * @var string
     *
     * @ORM\Column(name="sitio_extraccion", type="string", length=255)
     */
    private $sitioExtraccion;

    /**
     * @var string
     *
     * @ORM\Column(name="latitud", type="string", length=45)
     */
    private $latitud;

    /**
     * @var string
     *
     * @ORM\Column(name="longitud", type="string", length=45)
     */
    private $longitud;

     /**
     * @var string
     *
     * @ORM\Column(name="origen_gestion", type="string", length=255)
     */
    private $origenGestion;

    /**
     * @var float
     *
     * @ORM\Column(name="cantidad_tiempo", type="float")
     */
    private $cantidadTiempo;

    /**
     * @var int
     *
     * @ORM\Column(name="autorizacion_ministerio", type="integer")
     */
    private $autorizacionMinisterio;
    

    /**
     * @ORM\ManyToOne(targetEntity="Recurso", inversedBy="Suelo")
     * @ORM\JoinColumn(name="recurso_id", referencedColumnName="id")
     */
    private $recurso;


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
     * Set descripcionUso.
     *
     * @param string $descripcionUso
     *
     * @return suelo
     */
    public function setDescripcionUso($descripcionUso)
    {
        $this->descripcionUso = $descripcionUso;

        return $this;
    }

    /**
     * Get descripcionUso.
     *
     * @return string
     */
    public function getDescripcionUso()
    {
        return $this->descripcionUso;
    }

    /**
     * Set sitioExtraccion.
     *
     * @param string $sitioExtraccion
     *
     * @return suelo
     */
    public function setSitioExtraccion($sitioExtraccion)
    {
        $this->sitioExtraccion = $sitioExtraccion;

        return $this;
    }

    /**
     * Get sitioExtraccion.
     *
     * @return string
     */
    public function getSitioExtraccion()
    {
        return $this->sitioExtraccion;
    }

    /**
     * Set latitud.
     *
     * @param string $latitud
     *
     * @return suelo
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;

        return $this;
    }

    /**
     * Get latitud.
     *
     * @return string
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * Set longitud.
     *
     * @param string $longitud
     *
     * @return suelo
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;

        return $this;
    }

    /**
     * Get longitud.
     *
     * @return string
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

      /**
     * Set origenGestion.
     *
     * @param string $origenGestion
     *
     * @return suelo
     */
    public function setOrigenGestion($origenGestion)
    {
        $this->origenGestion = $origenGestion;

        return $this;
    }

    /**
     * Get origenGestion.
     *
     * @return string
     */
    public function getOrigenGestion()
    {
        return $this->origenGestion;
    }

    /**
     * Set cantidadTiempo.
     *
     * @param float $cantidadTiempo
     *
     * @return suelo
     */
    public function setCantidadTiempo($cantidadTiempo)
    {
        $this->cantidadTiempo = $cantidadTiempo;

        return $this;
    }

    /**
     * Get cantidadTiempo.
     *
     * @return float
     */
    public function getCantidadTiempo()
    {
        return $this->cantidadTiempo;
    }

    /**
     * Set autorizacionMinisterio.
     *
     * @param int $autorizacionMinisterio
     *
     * @return suelo
     */
    public function setAutorizacionMinisterio($autorizacionMinisterio)
    {
        $this->autorizacionMinisterio = $autorizacionMinisterio;

        return $this;
    }

    /**
     * Get autorizacionMinisterio.
     *
     * @return int
     */
    public function getAutorizacionMinisterio()
    {
        return $this->autorizacionMinisterio;
    }

    /**
     * Set recurso.
     *
     * @param int|null $recurso
     *
     * @return suelo
     */
    public function setRecurso($recurso = null)
    {
        $this->recurso = $recurso;

        return $this;
    }

    /**
     * Get recurso.
     *
     * @return int|null
     */
    public function getRecurso()
    {
        return $this->recurso;
    }
}
