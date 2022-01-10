<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtapaOperativa
 *
 * @ORM\Table(name="etapa_operativa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EtapaOperativaRepository")
 */
class EtapaOperativa
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
     * @ORM\Column(name="proceso", type="string", length=875, nullable=true)
     */
    private $proceso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="materia_prima", type="string", length=875, nullable=true)
     */
    private $materiaPrima;

    /**
     * @var string|null
     *
     * @ORM\Column(name="producto", type="string", length=875, nullable=true)
     */
    private $producto;

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
     * @return EtapaOperativa
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
     * @return EtapaOperativa
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
     * Set proceso.
     *
     * @param string|null $proceso
     *
     * @return EtapaOperativa
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
     * Set materiaPrima.
     *
     * @param string|null $materiaPrima
     *
     * @return EtapaOperativa
     */
    public function setMateriaPrima($materiaPrima = null)
    {
        $this->materiaPrima = $materiaPrima;

        return $this;
    }

    /**
     * Get materiaPrima.
     *
     * @return string|null
     */
    public function getMateriaPrima()
    {
        return $this->materiaPrima;
    }

    /**
     * Set producto.
     *
     * @param string|null $producto
     *
     * @return EtapaOperativa
     */
    public function setProducto($producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto.
     *
     * @return string|null
     */
    public function getProducto()
    {
        return $this->producto;
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
