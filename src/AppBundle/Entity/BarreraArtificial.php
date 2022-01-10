<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BarreraArtificial
 *
 * @ORM\Table(name="barrera_artificial")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BarreraArtificialRepository")
 */
class BarreraArtificial
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
     * @ORM\Column(name="ubicacion", type="string", length=255, nullable=true)
     */
    private $ubicacion;

    /**
     * @var int|null
     *
     * @ORM\Column(name="altura", type="integer", nullable=true)
     */
    private $altura;

    /**
     * @var int|null
     *
     * @ORM\Column(name="longitud", type="integer", nullable=true)
     */
    private $longitud;

    /**
     * @var string|null
     *
     * @ORM\Column(name="material", type="string", length=255, nullable=true)
     */
    private $material;

      /**
     * @var string|null
     *
     * @ORM\Column(name="tipo", type="string", length=255, nullable=true)
     */
    private $tipo;

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
     * @return BarreraArtificial
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
     * Set ubicacion.
     *
     * @param string|null $ubicacion
     *
     * @return BarreraArtificial
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
     * Set altura.
     *
     * @param int|null $altura
     *
     * @return BarreraArtificial
     */
    public function setAltura($altura = null)
    {
        $this->altura = $altura;

        return $this;
    }

    /**
     * Get altura.
     *
     * @return int|null
     */
    public function getAltura()
    {
        return $this->altura;
    }

    /**
     * Set longitud.
     *
     * @param int|null $longitud
     *
     * @return BarreraArtificial
     */
    public function setLongitud($longitud = null)
    {
        $this->longitud = $longitud;

        return $this;
    }

    /**
     * Get longitud.
     *
     * @return int|null
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * Set material.
     *
     * @param string|null $material
     *
     * @return BarreraArtificial
     */
    public function setMaterial($material = null)
    {
        $this->material = $material;

        return $this;
    }

    /**
     * Get material.
     *
     * @return string|null
     */
    public function getMaterial()
    {
        return $this->material;
    }

     /**
     * Set tipo.
     *
     * @param string|null $tipo
     *
     * @return BarreraArtificial
     */
    public function setTipo($tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return string|null
     */
    public function getTipo()
    {
        return $this->tipo;
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
