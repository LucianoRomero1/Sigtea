<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MemoriaDescriptivaFeedlot
 *
 * @ORM\Table(name="memoria_descriptiva_feedlot")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MemoriaDescriptivaFeedlotRepository")
 */
class MemoriaDescriptivaFeedlot
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
     * @ORM\Column(name="capacidadMaxima", type="integer", nullable=true)
     */
    private $capacidadMaxima;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cantidadAnimal", type="integer", nullable=true)
     */
    private $cantidadAnimal;

    /**
     * @var int|null
     *
     * @ORM\Column(name="superficieEstablecimiento", type="integer", nullable=true)
     */
    private $superficieEstablecimiento;

    /**
     * @var int|null
     *
     * @ORM\Column(name="superficieAnimal", type="integer", nullable=true)
     */
    private $superficieAnimal;

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
     * Set capacidadMaxima.
     *
     * @param int|null $capacidadMaxima
     *
     * @return MemoriaDescriptivaFeedlot
     */
    public function setCapacidadMaxima($capacidadMaxima = null)
    {
        $this->capacidadMaxima = $capacidadMaxima;

        return $this;
    }

    /**
     * Get capacidadMaxima.
     *
     * @return int|null
     */
    public function getCapacidadMaxima()
    {
        return $this->capacidadMaxima;
    }

    /**
     * Set cantidadAnimal.
     *
     * @param int|null $cantidadAnimal
     *
     * @return MemoriaDescriptivaFeedlot
     */
    public function setCantidadAnimal($cantidadAnimal = null)
    {
        $this->cantidadAnimal = $cantidadAnimal;

        return $this;
    }

    /**
     * Get cantidadAnimal.
     *
     * @return int|null
     */
    public function getCantidadAnimal()
    {
        return $this->cantidadAnimal;
    }

    /**
     * Set superficieEstablecimiento.
     *
     * @param int|null $superficieEstablecimiento
     *
     * @return MemoriaDescriptivaFeedlot
     */
    public function setSuperficieEstablecimiento($superficieEstablecimiento = null)
    {
        $this->superficieEstablecimiento = $superficieEstablecimiento;

        return $this;
    }

    /**
     * Get superficieEstablecimiento.
     *
     * @return int|null
     */
    public function getSuperficieEstablecimiento()
    {
        return $this->superficieEstablecimiento;
    }

    /**
     * Set superficieAnimal.
     *
     * @param int|null $superficieAnimal
     *
     * @return MemoriaDescriptivaFeedlot
     */
    public function setSuperficieAnimal($superficieAnimal = null)
    {
        $this->superficieAnimal = $superficieAnimal;

        return $this;
    }

    /**
     * Get superficieAnimal.
     *
     * @return int|null
     */
    public function getSuperficieAnimal()
    {
        return $this->superficieAnimal;
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
