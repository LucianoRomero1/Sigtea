<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AfectacionA
 *
 * @ORM\Table(name="afectacion_a")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AfectacionARepository")
 */
class AfectacionA
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
     * @ORM\Column(name="aspectoBiotico", type="integer", nullable=true)
     */
    private $aspectoBiotico;

    /**
     * @var int|null
     *
     * @ORM\Column(name="coberturaVegetal", type="integer", nullable=true)
     */
    private $coberturaVegetal;

    /**
     * @var int|null
     *
     * @ORM\Column(name="fauna", type="integer", nullable=true)
     */
    private $fauna;

    /**
     * @var string|null
     *
     * @ORM\Column(name="otros", type="string", length=45, nullable=true)
     */
    private $otros;

    /**
     * @ORM\ManyToOne(targetEntity="Urbanizacion", inversedBy="AfectacionA")
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
     * Set aspectoBiotico.
     *
     * @param int|null $aspectoBiotico
     *
     * @return AfectacionA
     */
    public function setAspectoBiotico($aspectoBiotico = null)
    {
        $this->aspectoBiotico = $aspectoBiotico;

        return $this;
    }

    /**
     * Get aspectoBiotico.
     *
     * @return int|null
     */
    public function getAspectoBiotico()
    {
        return $this->aspectoBiotico;
    }

    /**
     * Set coberturaVegetal.
     *
     * @param int|null $coberturaVegetal
     *
     * @return AfectacionA
     */
    public function setCoberturaVegetal($coberturaVegetal = null)
    {
        $this->coberturaVegetal = $coberturaVegetal;

        return $this;
    }

    /**
     * Get coberturaVegetal.
     *
     * @return int|null
     */
    public function getCoberturaVegetal()
    {
        return $this->coberturaVegetal;
    }

    /**
     * Set fauna.
     *
     * @param int|null $fauna
     *
     * @return AfectacionA
     */
    public function setFauna($fauna = null)
    {
        $this->fauna = $fauna;

        return $this;
    }

    /**
     * Get fauna.
     *
     * @return int|null
     */
    public function getFauna()
    {
        return $this->fauna;
    }

    /**
     * Set otros.
     *
     * @param string|null $otros
     *
     * @return AfectacionA
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
