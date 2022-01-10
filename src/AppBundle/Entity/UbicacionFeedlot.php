<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UbicacionFeedlot
 *
 * @ORM\Table(name="ubicacion_feedlot")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UbicacionFeedlotRepository")
 */
class UbicacionFeedlot
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
     * @ORM\Column(name="distanciaUrbana", type="integer", nullable=true)
     */
    private $distanciaUrbana;

    /**
     * @var int|null
     *
     * @ORM\Column(name="distanciaAsentamiento", type="integer", nullable=true)
     */
    private $distanciaAsentamiento;

    /**
     * @var int|null
     *
     * @ORM\Column(name="distanciaAnimal", type="integer", nullable=true)
     */
    private $distanciaAnimal;

    /**
     * @var int|null
     *
     * @ORM\Column(name="distanciaEspejoAgua", type="integer", nullable=true)
     */
    private $distanciaEspejoAgua;

    /**
     * @var int|null
     *
     * @ORM\Column(name="distanciaOtroEstablecimiento", type="integer", nullable=true)
     */
    private $distanciaOtroEstablecimiento;

    /**
     * @ORM\OneToOne(targetEntity="Planta")
     * @ORM\JoinColumn(name="planta_id", referencedColumnName="id")
     */
    public $planta;


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
     * Set distanciaUrbana.
     *
     * @param int|null $distanciaUrbana
     *
     * @return UbicacionFeedlot
     */
    public function setDistanciaUrbana($distanciaUrbana = null)
    {
        $this->distanciaUrbana = $distanciaUrbana;

        return $this;
    }

    /**
     * Get distanciaUrbana.
     *
     * @return int|null
     */
    public function getDistanciaUrbana()
    {
        return $this->distanciaUrbana;
    }

    /**
     * Set distanciaAsentamiento.
     *
     * @param int|null $distanciaAsentamiento
     *
     * @return UbicacionFeedlot
     */
    public function setDistanciaAsentamiento($distanciaAsentamiento = null)
    {
        $this->distanciaAsentamiento = $distanciaAsentamiento;

        return $this;
    }

    /**
     * Get distanciaAsentamiento.
     *
     * @return int|null
     */
    public function getDistanciaAsentamiento()
    {
        return $this->distanciaAsentamiento;
    }

    /**
     * Set distanciaAnimal.
     *
     * @param int|null $distanciaAnimal
     *
     * @return UbicacionFeedlot
     */
    public function setDistanciaAnimal($distanciaAnimal = null)
    {
        $this->distanciaAnimal = $distanciaAnimal;

        return $this;
    }

    /**
     * Get distanciaAnimal.
     *
     * @return int|null
     */
    public function getDistanciaAnimal()
    {
        return $this->distanciaAnimal;
    }

    /**
     * Set distanciaEspejoAgua.
     *
     * @param int|null $distanciaEspejoAgua
     *
     * @return UbicacionFeedlot
     */
    public function setDistanciaEspejoAgua($distanciaEspejoAgua = null)
    {
        $this->distanciaEspejoAgua = $distanciaEspejoAgua;

        return $this;
    }

    /**
     * Get distanciaEspejoAgua.
     *
     * @return int|null
     */
    public function getDistanciaEspejoAgua()
    {
        return $this->distanciaEspejoAgua;
    }

    /**
     * Set distanciaOtroEstablecimiento.
     *
     * @param int|null $distanciaOtroEstablecimiento
     *
     * @return UbicacionFeedlot
     */
    public function setDistanciaOtroEstablecimiento($distanciaOtroEstablecimiento = null)
    {
        $this->distanciaOtroEstablecimiento = $distanciaOtroEstablecimiento;

        return $this;
    }

    /**
     * Get distanciaOtroEstablecimiento.
     *
     * @return int|null
     */
    public function getDistanciaOtroEstablecimiento()
    {
        return $this->distanciaOtroEstablecimiento;
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
