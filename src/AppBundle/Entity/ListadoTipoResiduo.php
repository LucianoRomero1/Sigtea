<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListadoTipoResiduo
 *
 * @ORM\Table(name="listado_tipo_residuo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ListadoTipoResiduoRepository")
 */
class ListadoTipoResiduo
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
     * @ORM\Column(name="clase", type="string", length=5)
     */
    private $clase;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=50)
     */
    private $tipo;


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
     * Set clase.
     *
     * @param string $clase
     *
     * @return ListadoTipoResiduo
     */
    public function setClase($clase)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase.
     *
     * @return string
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set descripcion.
     *
     * @param string $descripcion
     *
     * @return ListadoTipoResiduo
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
     * Set tipo.
     *
     * @param string $tipo
     *
     * @return ListadoTipoResiduo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }
}
