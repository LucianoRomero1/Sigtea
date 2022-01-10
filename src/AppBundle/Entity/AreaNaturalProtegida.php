<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AreaNaturalProtegida
 *
 * @ORM\Table(name="area_natural_protegida")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AreaNaturalProtegidaRepository")
 */
class AreaNaturalProtegida
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
     * @ORM\Column(name="ribera", type="integer", nullable=true)
     */
    private $ribera;

    /**
     * @var int|null
     *
     * @ORM\Column(name="crestaBarranca", type="integer", nullable=true)
     */
    private $crestaBarranca;

    /**
     * @var string|null
     *
     * @ORM\Column(name="otros", type="string", length=45, nullable=true)
     */
    private $otros;

    /**
     * @ORM\ManyToOne(targetEntity="Urbanizacion", inversedBy="AreaNaturalProtegida")
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
     * Set ribera.
     *
     * @param int|null $ribera
     *
     * @return AreaNaturalProtegida
     */
    public function setRibera($ribera = null)
    {
        $this->ribera = $ribera;

        return $this;
    }

    /**
     * Get ribera.
     *
     * @return int|null
     */
    public function getRibera()
    {
        return $this->ribera;
    }

    /**
     * Set crestaBarranca.
     *
     * @param int|null $crestaBarranca
     *
     * @return AreaNaturalProtegida
     */
    public function setCrestaBarranca($crestaBarranca = null)
    {
        $this->crestaBarranca = $crestaBarranca;

        return $this;
    }

    /**
     * Get crestaBarranca.
     *
     * @return int|null
     */
    public function getCrestaBarranca()
    {
        return $this->crestaBarranca;
    }

    /**
     * Set otros.
     *
     * @param string|null $otros
     *
     * @return AreaNaturalProtegida
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
