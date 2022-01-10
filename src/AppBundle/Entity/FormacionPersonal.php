<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormacionPersonal
 *
 * @ORM\Table(name="formacion_personal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormacionPersonalRepository")
 */
class FormacionPersonal
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
     * @ORM\Column(name="cantidad_obrero", type="string", length=255)
     */
    private $cantidadObrero;

    /**
     * @var string
     *
     * @ORM\Column(name="capacitacion_obrero", type="string", length=255)
     */
    private $capacitacionObrero;

    /**
     * @var string
     *
     * @ORM\Column(name="cantidad_tecnico", type="string", length=255)
     */
    private $cantidadTecnico;

    /**
     * @var string
     *
     * @ORM\Column(name="capacitacion_tecnico", type="string", length=255)
     */
    private $capacitacionTecnico;

    /**
     * @var string
     *
     * @ORM\Column(name="cantidad_profesional", type="string", length=255)
     */
    private $cantidadProfecional;

    /**
     * @var string
     *
     * @ORM\Column(name="capacitacion_profesional", type="string", length=255)
     */
    private $capacitacionProfecional;

    /**
     * @var string
     *
     * @ORM\Column(name="horario_trabajo", type="string", length=255)
     */
    private $horarioTrabajo;

    /**
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="formacionPersonal")
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
     * Set cantidadObrero.
     *
     * @param string $cantidadObrero
     *
     * @return FormacionPersonal
     */
    public function setCantidadObrero($cantidadObrero)
    {
        $this->cantidadObrero = $cantidadObrero;

        return $this;
    }

    /**
     * Get cantidadObrero.
     *
     * @return string
     */
    public function getCantidadObrero()
    {
        return $this->cantidadObrero;
    }

    /**
     * Set capacitacionObrero.
     *
     * @param string $capacitacionObrero
     *
     * @return FormacionPersonal
     */
    public function setCapacitacionObrero($capacitacionObrero)
    {
        $this->capacitacionObrero = $capacitacionObrero;

        return $this;
    }

    /**
     * Get capacitacionObrero.
     *
     * @return string
     */
    public function getCapacitacionObrero()
    {
        return $this->capacitacionObrero;
    }

    /**
     * Set cantidadTecnico.
     *
     * @param string $cantidadTecnico
     *
     * @return FormacionPersonal
     */
    public function setCantidadTecnico($cantidadTecnico)
    {
        $this->cantidadTecnico = $cantidadTecnico;

        return $this;
    }

    /**
     * Get cantidadTecnico.
     *
     * @return string
     */
    public function getCantidadTecnico()
    {
        return $this->cantidadTecnico;
    }

    /**
     * Set capacitacionTecnico.
     *
     * @param string $capacitacionTecnico
     *
     * @return FormacionPersonal
     */
    public function setCapacitacionTecnico($capacitacionTecnico)
    {
        $this->capacitacionTecnico = $capacitacionTecnico;

        return $this;
    }

    /**
     * Get capacitacionTecnico.
     *
     * @return string
     */
    public function getCapacitacionTecnico()
    {
        return $this->capacitacionTecnico;
    }

    /**
     * Set cantidadProfecional.
     *
     * @param string $cantidadProfecional
     *
     * @return FormacionPersonal
     */
    public function setCantidadProfecional($cantidadProfecional)
    {
        $this->cantidadProfecional = $cantidadProfecional;

        return $this;
    }

    /**
     * Get cantidadProfecional.
     *
     * @return string
     */
    public function getCantidadProfecional()
    {
        return $this->cantidadProfecional;
    }

    /**
     * Set capacitacionProfecional.
     *
     * @param string $capacitacionProfecional
     *
     * @return FormacionPersonal
     */
    public function setCapacitacionProfecional($capacitacionProfecional)
    {
        $this->capacitacionProfecional = $capacitacionProfecional;

        return $this;
    }

    /**
     * Get capacitacionProfecional.
     *
     * @return string
     */
    public function getCapacitacionProfecional()
    {
        return $this->capacitacionProfecional;
    }

    /**
     * Set horarioTrabajo.
     *
     * @param string $horarioTrabajo
     *
     * @return FormacionPersonal
     */
    public function setHorarioTrabajo($horarioTrabajo)
    {
        $this->horarioTrabajo = $horarioTrabajo;

        return $this;
    }

    /**
     * Get horarioTrabajo.
     *
     * @return string
     */
    public function getHorarioTrabajo()
    {
        return $this->horarioTrabajo;
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
