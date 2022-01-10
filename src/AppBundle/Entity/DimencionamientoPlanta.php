<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DimencionamientoPlanta
 *
 * @ORM\Table(name="dimensionamiento_planta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DimencionamientoPlantaRepository")
 */
class DimencionamientoPlanta
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
     * @ORM\Column(name="superficie_total", type="string", length=255)
     */
    private $superficieTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="superficie_cubierta", type="string", length=255)
     */
    private $superficieCubierta;

    /**
     * @var string
     *
     * @ORM\Column(name="superficie_instalada", type="string", length=255)
     */
    private $superficieInstalada;

    /**
     * @var string
     *
     * @ORM\Column(name="superficieSinEdificar", type="string", length=255)
     */
    private $superficieSinEdificar;

    /**
     * @var string
     *
     * @ORM\Column(name="dotacion_personal", type="string", length=255)
     */
    private $dotacionPersonal;

    /**
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="dimencionamientoPlanta")
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
     * Set superficieTotal.
     *
     * @param string $superficieTotal
     *
     * @return DimencionamientoPlanta
     */
    public function setSuperficieTotal($superficieTotal)
    {
        $this->superficieTotal = $superficieTotal;

        return $this;
    }

    /**
     * Get superficieTotal.
     *
     * @return string
     */
    public function getSuperficieTotal()
    {
        return $this->superficieTotal;
    }

    /**
     * Set superficieCubierta.
     *
     * @param string $superficieCubierta
     *
     * @return DimencionamientoPlanta
     */
    public function setSuperficieCubierta($superficieCubierta)
    {
        $this->superficieCubierta = $superficieCubierta;

        return $this;
    }

    /**
     * Get superficieCubierta.
     *
     * @return string
     */
    public function getSuperficieCubierta()
    {
        return $this->superficieCubierta;
    }

    /**
     * Set superficieInstalada.
     *
     * @param string $superficieInstalada
     *
     * @return DimencionamientoPlanta
     */
    public function setSuperficieInstalada($superficieInstalada)
    {
        $this->superficieInstalada = $superficieInstalada;

        return $this;
    }

    /**
     * Get superficieInstalada.
     *
     * @return string
     */
    public function getSuperficieInstalada()
    {
        return $this->superficieInstalada;
    }

    /**
     * Set superficieSinEdificar.
     *
     * @param string $superficieSinEdificar
     *
     * @return DimencionamientoPlanta
     */
    public function setSuperficieSinEdificar($superficieSinEdificar)
    {
        $this->superficieSinEdificar = $superficieSinEdificar;

        return $this;
    }

    /**
     * Get superficieSinEdificar.
     *
     * @return string
     */
    public function getSuperficieSinEdificar()
    {
        return $this->superficieSinEdificar;
    }


    /**
     * Set dotacionPersonal.
     *
     * @param string $dotacionPersonal
     *
     * @return DimencionamientoPlanta
     */
    public function setDotacionPersonal($dotacionPersonal)
    {
        $this->dotacionPersonal = $dotacionPersonal;

        return $this;
    }

    /**
     * Get dotacionPersonal.
     *
     * @return string
     */
    public function getDotacionPersonal()
    {
        return $this->dotacionPersonal;
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
