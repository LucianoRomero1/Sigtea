<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProcesoGrano
 *
 * @ORM\Table(name="proceso_grano")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProcesoGranoRepository")
 */
class ProcesoGrano
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
     * @var string|null
     *
     * @ORM\Column(name="etapa", type="string", length=255, nullable=true)
     */
    private $etapa;

    /**
     * @var int|null
     *
     * @ORM\Column(name="paso", type="integer", nullable=true)
     */
    private $paso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="operatoria", type="string", length=255, nullable=true)
     */
    private $operatoria;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observacion", type="string", length=3000, nullable=true)
     */
    private $observacion;

    
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
     * Set etapa.
     *
     * @param string|null $etapa
     *
     * @return ProcesoGrano
     */
    public function setEtapa($etapa = null)
    {
        $this->etapa = $etapa;

        return $this;
    }

    /**
     * Get etapa.
     *
     * @return string|null
     */
    public function getEtapa()
    {
        return $this->etapa;
    }

    /**
     * Set paso.
     *
     * @param int|null $paso
     *
     * @return ProcesoGrano
     */
    public function setPaso($paso = null)
    {
        $this->paso = $paso;

        return $this;
    }

    /**
     * Get paso.
     *
     * @return int|null
     */
    public function getPaso()
    {
        return $this->paso;
    }

    /**
     * Set operatoria.
     *
     * @param string|null $operatoria
     *
     * @return ProcesoGrano
     */
    public function setOperatoria($operatoria = null)
    {
        $this->operatoria = $operatoria;

        return $this;
    }

    /**
     * Get operatoria.
     *
     * @return string|null
     */
    public function getOperatoria()
    {
        return $this->operatoria;
    }

    /**
     * Set observacion.
     *
     * @param string|null $observacion
     *
     * @return ProcesoGrano
     */
    public function setObservacion($observacion = null)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion.
     *
     * @return string|null
     */
    public function getObservacion()
    {
        return $this->observacion;
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
