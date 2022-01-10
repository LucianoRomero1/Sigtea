<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * proceso
 *
 * @ORM\Table(name="proceso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\procesoRepository")
 */
class Proceso
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
     * @var int|null
     *
     * @ORM\Column(name="tipo", type="integer", nullable=true)
     */
    private $tipo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=3000, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="Proceso")
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
     * Set tipo.
     *
     * @param int|null $tipo
     *
     * @return proceso
     */
    public function setTipo($tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return int|null
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set descripcion.
     *
     * @param string|null $descripcion
     *
     * @return proceso
     */
    public function setDescripcion($descripcion = null)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion.
     *
     * @return string|null
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set planta.
     *
     * @param int|null $planta
     *
     * @return proceso
     */
    public function setPlanta($planta = null)
    {
        $this->planta = $planta;

        return $this;
    }

    /**
     * Get planta.
     *
     * @return int|null
     */
    public function getPlanta()
    {
        return $this->planta;
    }
}
