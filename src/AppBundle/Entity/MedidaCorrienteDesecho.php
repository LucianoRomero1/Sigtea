<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MedidaCorrienteDesecho
 *
 * @ORM\Table(name="medida_corriente_desecho")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MedidaCorrienteDesechoRepository")
 */
class MedidaCorrienteDesecho
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
     * @ORM\Column(name="tipo", type="string", length=45, nullable=true)
     */
    private $tipo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=true)
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=500, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="Residuo", inversedBy="medida_corriente_desecho")
     * @ORM\JoinColumn(name="residuo_id", referencedColumnName="id")
     */
    private $residuo;


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
     * @return MedidaCorrienteDesecho
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
     * @return MedidaCorrienteDesecho
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
     * Set descripcion.
     *
     * @param string|null $descripcion
     *
     * @return MedidaCorrienteDesecho
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
     * Set residuo.
     *
     * @param Residuo $residuo
     *
     * @return Residuo
     */
    public function SetResiduo($residuo)
    {
        $this->residuo = $residuo;

        return $this;
    }

    /**
     * Get residuo.
     *
     * @return Residuo
     */
    public function GetResiduo()
    {
        return $this->residuo;
    }
}
