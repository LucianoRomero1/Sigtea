<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FactorAfectacion
 *
 * @ORM\Table(name="factor_afectacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FactorAfectacionRepository")
 */
class FactorAfectacion
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
     * @ORM\Column(name="factor", type="string", length=45, nullable=true)
     */
    private $factor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=1800, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="CaracterizacionEntorno", inversedBy="factor_afectacion")
     * @ORM\JoinColumn(name="caracterizacion_entorno_id", referencedColumnName="id")
     */
    private $caracterizacionEntorno;


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
     * Set factor.
     *
     * @param string|null $factor
     *
     * @return FactorAfectacion
     */
    public function setFactor($factor = null)
    {
        $this->factor = $factor;

        return $this;
    }

    /**
     * Get factor.
     *
     * @return string|null
     */
    public function getFactor()
    {
        return $this->factor;
    }

    /**
     * Set descripcion.
     *
     * @param string|null $descripcion
     *
     * @return FactorAfectacion
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
     * Set caracterizacionEntorno.
     *
     * @param CaracterizacionEntorno $caracterizacionEntorno
     *
     * @return Proyecto
     */
    public function setCaracterizacionEntorno($caracterizacionEntorno)
    {
        $this->caracterizacionEntorno = $caracterizacionEntorno;

        return $this;
    }

    /**
     * Get caracterizacionEntorno.
     *
     * @return CaracterizacionEntorno
     */
    public function getCaracterizacionEntorno()
    {
        return $this->caracterizacionEntorno;
    }
}
