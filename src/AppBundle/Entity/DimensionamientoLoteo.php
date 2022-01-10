<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DimensionamientoLoteo
 *
 * @ORM\Table(name="dimensionamiento_loteo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DimensionamientoLoteoRepository")
 */
class DimensionamientoLoteo
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
     * @ORM\Column(name="superficieTotal", type="integer", nullable=true)
     */
    private $superficieTotal;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cantidadLotes", type="integer", nullable=true)
     */
    private $cantidadLotes;

    /**
     * @var int|null
     *
     * @ORM\Column(name="superficieTotalLoteada", type="integer", nullable=true)
     */
    private $superficieTotalLoteada;

    /**
     * @ORM\ManyToOne(targetEntity="Urbanizacion", inversedBy="dimensionamiento")
     * @ORM\JoinColumn(name="urbanizacion_id", referencedColumnName="id")
     */
    private $urbanizacion;


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
     * Set superficieTotal.
     *
     * @param int|null $superficieTotal
     *
     * @return DimensionamientoLoteo
     */
    public function setSuperficieTotal($superficieTotal = null)
    {
        $this->superficieTotal = $superficieTotal;

        return $this;
    }

    /**
     * Get superficieTotal.
     *
     * @return int|null
     */
    public function getSuperficieTotal()
    {
        return $this->superficieTotal;
    }

    /**
     * Set cantidadLotes.
     *
     * @param int|null $cantidadLotes
     *
     * @return DimensionamientoLoteo
     */
    public function setCantidadLotes($cantidadLotes = null)
    {
        $this->cantidadLotes = $cantidadLotes;

        return $this;
    }

    /**
     * Get cantidadLotes.
     *
     * @return int|null
     */
    public function getCantidadLotes()
    {
        return $this->cantidadLotes;
    }

    /**
     * Set superficieTotalLoteada.
     *
     * @param int|null $superficieTotalLoteada
     *
     * @return DimensionamientoLoteo
     */
    public function setSuperficieTotalLoteada($superficieTotalLoteada = null)
    {
        $this->superficieTotalLoteada = $superficieTotalLoteada;

        return $this;
    }

    /**
     * Get superficieTotalLoteada.
     *
     * @return int|null
     */
    public function getSuperficieTotalLoteada()
    {
        return $this->superficieTotalLoteada;
    }


    /**
     * Set urbanizacion.
     *
     * @param Urbanizacion $urbanizacion
     *
     * @return Urbanizacion
     */
    public function setUrbanizacion($urbanizacion)
    {
        $this->urbanizacion = $urbanizacion;

        return $this;
    }

    /**
     * Get urbanizacion.
     *
     * @return Urbanizacion
     */
    public function getUrbanizacion()
    {
        return $this->urbanizacion;
    }
}
