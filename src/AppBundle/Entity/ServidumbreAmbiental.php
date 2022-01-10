<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServidumbreAmbiental
 *
 * @ORM\Table(name="servidumbre_ambiental")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServidumbreAmbientalRepository")
 */
class ServidumbreAmbiental
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
     * @ORM\Column(name="electroducto", type="integer", nullable=true)
     */
    private $electroducto;

    /**
     * @var int|null
     *
     * @ORM\Column(name="gas", type="integer", nullable=true)
     */
    private $gas;

    /**
     * @var int|null
     *
     * @ORM\Column(name="hidrica", type="integer", nullable=true)
     */
    private $hidrica;

    /**
     * @var string|null
     *
     * @ORM\Column(name="otros", type="string", length=45, nullable=true)
     */
    private $otros;

    /**
     * @ORM\ManyToOne(targetEntity="Urbanizacion", inversedBy="ServidumbreAmbiental")
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
     * Set electroducto.
     *
     * @param int|null $electroducto
     *
     * @return ServidumbreAmbiental
     */
    public function setElectroducto($electroducto = null)
    {
        $this->electroducto = $electroducto;

        return $this;
    }

    /**
     * Get electroducto.
     *
     * @return int|null
     */
    public function getElectroducto()
    {
        return $this->electroducto;
    }

    /**
     * Set gas.
     *
     * @param int|null $gas
     *
     * @return ServidumbreAmbiental
     */
    public function setGas($gas = null)
    {
        $this->gas = $gas;

        return $this;
    }

    /**
     * Get gas.
     *
     * @return int|null
     */
    public function getGas()
    {
        return $this->gas;
    }

    /**
     * Set hidrica.
     *
     * @param int|null $hidrica
     *
     * @return ServidumbreAmbiental
     */
    public function setHidrica($hidrica = null)
    {
        $this->hidrica = $hidrica;

        return $this;
    }

    /**
     * Get hidrica.
     *
     * @return int|null
     */
    public function getHidrica()
    {
        return $this->hidrica;
    }

    /**
     * Set otros.
     *
     * @param string|null $otros
     *
     * @return ServidumbreAmbiental
     */
    public function setOtros($otros = null)
    {
        $this->otros = $otros;

        return $this;
    }

    /**
     * Get otros.
     *
     * @return string|null
     */
    public function getOtros()
    {
        return $this->otros;
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
}
