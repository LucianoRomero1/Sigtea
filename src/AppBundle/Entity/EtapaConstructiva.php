<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtapaConstructiva
 *
 * @ORM\Table(name="etapa_constructiva")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EtapaConstructivaRepository")
 */
class EtapaConstructiva
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
     * @ORM\Column(name="tarea", type="string", length=45, nullable=true)
     */
    private $tarea;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=875, nullable=true)
     */
    private $descripcion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="insumo", type="string", length=875, nullable=true)
     */
    private $insumo;

    /**
     * @ORM\ManyToOne(targetEntity="Proyecto", inversedBy="etapa_constructiva")
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
     * Set tarea.
     *
     * @param string|null $tarea
     *
     * @return EtapaConstructiva
     */
    public function setTarea($tarea = null)
    {
        $this->tarea = $tarea;

        return $this;
    }

    /**
     * Get tarea.
     *
     * @return string|null
     */
    public function getTarea()
    {
        return $this->tarea;
    }

    /**
     * Set descripcion.
     *
     * @param string|null $descripcion
     *
     * @return EtapaConstructiva
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
     * Set insumo.
     *
     * @param string|null $insumo
     *
     * @return EtapaConstructiva
     */
    public function setInsumo($insumo = null)
    {
        $this->insumo = $insumo;

        return $this;
    }

    /**
     * Get insumo.
     *
     * @return string|null
     */
    public function getInsumo()
    {
        return $this->insumo;
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
