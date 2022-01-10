<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoOperacion
 *
 * @ORM\Table(name="tipo_operacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoOperacionRepository")
 */
class TipoOperacion
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
     * @ORM\Column(name="operacion", type="string", length=255, nullable=true)
     */
    private $operacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detalle_operacion", type="string", length=500, nullable=true)
     */
    private $detalleOperacion;

    /**
     * @var int|null
     *
     * @ORM\Column(name="numero_operacion", type="integer", nullable=true)
     */
    private $numeroOperacion;

      /**
     * @ORM\ManyToOne(targetEntity="TratamientoPlantaPropia", inversedBy="tipoOperacion")
     * @ORM\JoinColumn(name="tratamiento_planta_propia_id", referencedColumnName="id")
     */
    private $tratamientoPlantaPropia;


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
     * Set operacion.
     *
     * @param string|null $operacion
     *
     * @return TipoOperacion
     */
    public function setOperacion($operacion = null)
    {
        $this->operacion = $operacion;

        return $this;
    }

    /**
     * Get operacion.
     *
     * @return string|null
     */
    public function getOperacion()
    {
        return $this->operacion;
    }

    /**
     * Set detalleOperacion.
     *
     * @param string|null $detalleOperacion
     *
     * @return TipoOperacion
     */
    public function setDetalleOperacion($detalleOperacion = null)
    {
        $this->detalleOperacion = $detalleOperacion;

        return $this;
    }

    /**
     * Get detalleOperacion.
     *
     * @return string|null
     */
    public function getDetalleOperacion()
    {
        return $this->detalleOperacion;
    }

    /**
     * Set numeroOperacion.
     *
     * @param int|null $numeroOperacion
     *
     * @return TipoOperacion
     */
    public function setNumeroOperacion($numeroOperacion = null)
    {
        $this->numeroOperacion = $numeroOperacion;

        return $this;
    }

    /**
     * Get numeroOperacion.
     *
     * @return int|null
     */
    public function getNumeroOperacion()
    {
        return $this->numeroOperacion;
    }


        /**
     * Set tratamientoPlantaPropia.
     *
     * @param TratamientoPlantaPropia $tratamientoPlantaPropia
     *
     * @return TratamientoPlantaPropia
     */
    public function setTratamientoPlantaPropia($tratamientoPlantaPropia)
    {
        $this->tratamientoPlantaPropia = $tratamientoPlantaPropia;

        return $this;
    }

    /**
     * Get tratamientoPlantaPropia.
     *
     * @return TratamientoPlantaPropia
     */
    public function getTratamientoPlantaPropia()
    {
        return $this->tratamientoPlantaPropia;
    }

}
