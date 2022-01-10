<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsoRecurso
 *
 * @ORM\Table(name="uso_recurso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsoRecursoRepository")
 */
class UsoRecurso
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
     * @ORM\Column(name="recurso", type="string", length=45, nullable=true)
     */
    private $recurso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="extraccion", type="string", length=875, nullable=true)
     */
    private $extraccion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="proceso", type="string", length=875, nullable=true)
     */
    private $proceso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cantidad_tiempo", type="string", length=875, nullable=true)
     */
    private $cantidadTiempo;

    /**
     * @ORM\ManyToOne(targetEntity="Proyecto", inversedBy="uso_recurso")
     * @ORM\JoinColumn(name="proyecto_id", referencedColumnName="id")
     */
    private $proyecto;


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
     * Set recurso.
     *
     * @param string|null $recurso
     *
     * @return UsoRecurso
     */
    public function setRecurso($recurso = null)
    {
        $this->recurso = $recurso;

        return $this;
    }

    /**
     * Get recurso.
     *
     * @return string|null
     */
    public function getRecurso()
    {
        return $this->recurso;
    }

    /**
     * Set extraccion.
     *
     * @param string|null $extraccion
     *
     * @return UsoRecurso
     */
    public function setExtraccion($extraccion = null)
    {
        $this->extraccion = $extraccion;

        return $this;
    }

    /**
     * Get extraccion.
     *
     * @return string|null
     */
    public function getExtraccion()
    {
        return $this->extraccion;
    }

    /**
     * Set proceso.
     *
     * @param string|null $proceso
     *
     * @return UsoRecurso
     */
    public function setProceso($proceso = null)
    {
        $this->proceso = $proceso;

        return $this;
    }

    /**
     * Get proceso.
     *
     * @return string|null
     */
    public function getProceso()
    {
        return $this->proceso;
    }

    /**
     * Set cantidadTiempo.
     *
     * @param string|null $cantidadTiempo
     *
     * @return UsoRecurso
     */
    public function setCantidadTiempo($cantidadTiempo = null)
    {
        $this->cantidadTiempo = $cantidadTiempo;

        return $this;
    }

    /**
     * Get cantidadTiempo.
     *
     * @return string|null
     */
    public function getCantidadTiempo()
    {
        return $this->cantidadTiempo;
    }

    /**
     * Set proyecto.
     *
     * @param Proyecto $proyecto
     *
     * @return Proyecto
     */
    public function setProyecto($proyecto)
    {
        $this->proyecto = $proyecto;

        return $this;
    }

    /**
     * Get proyecto.
     *
     * @return Proyecto
     */
    public function getProyecto()
    {
        return $this->proyecto;
    }
}
