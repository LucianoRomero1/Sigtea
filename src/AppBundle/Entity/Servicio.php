<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servicio
 *
 * @ORM\Table(name="servicio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServicioRepository")
 */
class Servicio
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
     * @var int
     *
     * @ORM\Column(name="energia_electrica", type="smallint")
     */
    private $energiaElectrica;

    /**
     * @var int
     *
     * @ORM\Column(name="cloacas", type="smallint")
     */
    private $cloacas;

    /**
     * @var int
     *
     * @ORM\Column(name="agua_red", type="smallint")
     */
    private $aguaRed;

    /**
     * @var int
     *
     * @ORM\Column(name="gas_natural", type="smallint")
     */
    private $gasNatural;

    /**
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="producto")
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
     * Set energiaElectrica.
     *
     * @param int $energiaElectrica
     *
     * @return Servicio
     */
    public function setEnergiaElectrica($energiaElectrica)
    {
        $this->energiaElectrica = $energiaElectrica;

        return $this;
    }

    /**
     * Get energiaElectrica.
     *
     * @return int
     */
    public function getEnergiaElectrica()
    {
        return $this->energiaElectrica;
    }

    /**
     * Set cloacas.
     *
     * @param int $cloacas
     *
     * @return Servicio
     */
    public function setCloacas($cloacas)
    {
        $this->cloacas = $cloacas;

        return $this;
    }

    /**
     * Get cloacas.
     *
     * @return int
     */
    public function getCloacas()
    {
        return $this->cloacas;
    }

    /**
     * Set aguaRed.
     *
     * @param int $aguaRed
     *
     * @return Servicio
     */
    public function setAguaRed($aguaRed)
    {
        $this->aguaRed = $aguaRed;

        return $this;
    }

    /**
     * Get aguaRed.
     *
     * @return int
     */
    public function getAguaRed()
    {
        return $this->aguaRed;
    }

    /**
     * Set gasNatural.
     *
     * @param int $gasNatural
     *
     * @return Servicio
     */
    public function setGasNatural($gasNatural)
    {
        $this->gasNatural = $gasNatural;

        return $this;
    }

    /**
     * Get gasNatural.
     *
     * @return int
     */
    public function getGasNatural()
    {
        return $this->gasNatural;
    }

    /**
     * Set planta.
     *
     * @param Planta $planta
     *
     * @return Planta
     */
    public function setPlanta($planta)
    {
        $this->planta = $planta;

        return $this;
    }

    /**
     * Get planta.
     *
     * @return Planta
     */
    public function getPlanta()
    {
        return $this->planta;
    }
}
