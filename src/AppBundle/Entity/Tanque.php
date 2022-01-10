<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tanque
 *
 * @ORM\Table(name="tanque")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TanqueRepository")
 */
class Tanque
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
     * @ORM\Column(name="cantidad", type="string", length=255)
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="capacidad_total", type="string", length=255)
     */
    private $capacidadTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="unidad", type="string", length=255)
     */
    private $unidad;

    /**
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="tanque")
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
     * Set cantidad.
     *
     * @param string $cantidad
     *
     * @return Tanque
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad.
     *
     * @return string
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set capacidadTotal.
     *
     * @param string $capacidadTotal
     *
     * @return Tanque
     */
    public function setCapacidadTotal($capacidadTotal)
    {
        $this->capacidadTotal = $capacidadTotal;

        return $this;
    }

    /**
     * Get capacidadTotal.
     *
     * @return string
     */
    public function getCapacidadTotal()
    {
        return $this->capacidadTotal;
    }

    /**
     * Set unidad.
     *
     * @param string $unidad
     *
     * @return Tanque
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
}
