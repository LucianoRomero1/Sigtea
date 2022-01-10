<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ElectricaAdquirida
 *
 * @ORM\Table(name="electrica_adquirida")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ElectricaAdquiridaRepository")
 */
class ElectricaAdquirida
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
     * @var float
     *
     * @ORM\Column(name="cantidad", type="float")
     */
    private $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity="Recurso", inversedBy="electricaadquirida")
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
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return ElectricaAdquirida
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
     * Set cantidad.
     *
     * @param float $cantidad
     *
     * @return ElectricaAdquirida
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
}
