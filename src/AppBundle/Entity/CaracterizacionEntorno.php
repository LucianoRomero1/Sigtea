<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CaracterizacionEntorno
 *
 * @ORM\Table(name="caracterizacion_entorno")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CaracterizacionEntornoRepository")
 */
class CaracterizacionEntorno
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
     * @ORM\Column(name="descripcion_inmediata", type="string", length=3000, nullable=true)
     */
    private $descripcionInmediata;

    /**
     * @var string|null
     *
     * @ORM\Column(name="via_acceso", type="string", length=2400, nullable=true)
     */
    private $viaAcceso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="situacion_ambiental", type="string", length=2000, nullable=true)
     */
    private $situacionAmbiental;

    /**
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="caracterizacion_entorno")
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
     * Set descripcionInmediata.
     *
     * @param string|null $descripcionInmediata
     *
     * @return CaracterizacionEntorno
     */
    public function setDescripcionInmediata($descripcionInmediata = null)
    {
        $this->descripcionInmediata = $descripcionInmediata;

        return $this;
    }

    /**
     * Get descripcionInmediata.
     *
     * @return string|null
     */
    public function getDescripcionInmediata()
    {
        return $this->descripcionInmediata;
    }

    /**
     * Set viaAcceso.
     *
     * @param string|null $viaAcceso
     *
     * @return CaracterizacionEntorno
     */
    public function setViaAcceso($viaAcceso = null)
    {
        $this->viaAcceso = $viaAcceso;

        return $this;
    }

    /**
     * Get viaAcceso.
     *
     * @return string|null
     */
    public function getViaAcceso()
    {
        return $this->viaAcceso;
    }

    /**
     * Set situacionAmbiental.
     *
     * @param string|null $situacionAmbiental
     *
     * @return CaracterizacionEntorno
     */
    public function setSituacionAmbiental($situacionAmbiental = null)
    {
        $this->situacionAmbiental = $situacionAmbiental;

        return $this;
    }

    /**
     * Get situacionAmbiental.
     *
     * @return string|null
     */
    public function getSituacionAmbiental()
    {
        return $this->situacionAmbiental;
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
