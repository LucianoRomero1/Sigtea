<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PartidaInmobiliaria
 *
 * @ORM\Table(name="partida_inmobiliaria")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartidaInmobiliariaRepository")
 */
class PartidaInmobiliaria
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
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;

    /**
     * @var float
     *
     * @ORM\Column(name="latitud", type="string", length=255)
     */
    private $latitud;

    /**
     * @var float
     *
     * @ORM\Column(name="longitud", type="string", length=255)
     */
    private $longitud;

    /**
     * @ORM\OneToMany(targetEntity="InmuebleAnexo", mappedBy="plantaInmobiliaria")
     */
    protected $inmuebleAnexo;

    /**
     * @ORM\OneToOne(targetEntity="Planta")
     * @ORM\JoinColumn(name="planta_id", referencedColumnName="id")
     */
    public $planta;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inmuebleAnexo = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set numero.
     *
     * @param int $numero
     *
     * @return PartidaInmobiliaria
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero.
     *
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set latitud.
     *
     * @param float $latitud
     *
     * @return PartidaInmobiliaria
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;

        return $this;
    }

    /**
     * Get latitud.
     *
     * @return float
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * Set longitud.
     *
     * @param float $longitud
     *
     * @return PartidaInmobiliaria
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;

        return $this;
    }

    /**
     * Get longitud.
     *
     * @return float
     */
    public function getLongitud()
    {
        return $this->longitud;
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
