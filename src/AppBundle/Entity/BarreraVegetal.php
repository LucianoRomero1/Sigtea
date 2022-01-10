<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BarreraVegetal
 *
 * @ORM\Table(name="barrera_vegetal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BarreraVegetalRepository")
 */
class BarreraVegetal
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
     * @ORM\Column(name="numero", type="integer", nullable=true)
     */
    private $numero;

    /**
     * @var string|null
     *
     * @ORM\Column(name="genero_especie", type="string", length=255, nullable=true)
     */
    private $generoEspecie;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_plantacion", type="date", nullable=true)
     */
    private $fechaPlantacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sistema_plantacion", type="string", length=255, nullable=true)
     */
    private $sistemaPlantacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ubicacion", type="string", length=255, nullable=true)
     */
    private $ubicacion;

    /**
     * @var int|null
     *
     * @ORM\Column(name="numero_arboles", type="integer", nullable=true)
     */
    private $numeroArboles;


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
     * Set numero.
     *
     * @param int|null $numero
     *
     * @return BarreraVegetal
     */
    public function setNumero($numero = null)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero.
     *
     * @return int|null
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set generoEspecie.
     *
     * @param string|null $generoEspecie
     *
     * @return BarreraVegetal
     */
    public function setGeneroEspecie($generoEspecie = null)
    {
        $this->generoEspecie = $generoEspecie;

        return $this;
    }

    /**
     * Get generoEspecie.
     *
     * @return string|null
     */
    public function getGeneroEspecie()
    {
        return $this->generoEspecie;
    }

    /**
     * Set fechaPlantacion.
     *
     * @param \DateTime|null $fechaPlantacion
     *
     * @return BarreraVegetal
     */
    public function setfechaPlantacion($fechaPlantacion = null)
    {
        $this->fechaPlantacion = $fechaPlantacion;

        return $this;
    }

    /**
     * Get fechaPlantacion.
     *
     * @return \DateTime|null
     */
    public function getfechaPlantacion()
    {
        return $this->fechaPlantacion;
    }

    /**
     * Set sistemaPlantacion.
     *
     * @param string|null $sistemaPlantacion
     *
     * @return BarreraVegetal
     */
    public function setSistemaPlantacion($sistemaPlantacion = null)
    {
        $this->sistemaPlantacion = $sistemaPlantacion;

        return $this;
    }

    /**
     * Get sistemaPlantacion.
     *
     * @return string|null
     */
    public function getSistemaPlantacion()
    {
        return $this->sistemaPlantacion;
    }

    /**
     * Set ubicacion.
     *
     * @param string|null $ubicacion
     *
     * @return BarreraVegetal
     */
    public function setUbicacion($ubicacion = null)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion.
     *
     * @return string|null
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Set numeroArboles.
     *
     * @param int|null $numeroArboles
     *
     * @return BarreraVegetal
     */
    public function setNumeroArboles($numeroArboles = null)
    {
        $this->numeroArboles = $numeroArboles;

        return $this;
    }

    /**
     * Get numeroArboles.
     *
     * @return int|null
     */
    public function getNumeroArboles()
    {
        return $this->numeroArboles;
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
