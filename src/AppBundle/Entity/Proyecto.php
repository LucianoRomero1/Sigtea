<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proyecto
 *
 * @ORM\Table(name="proyecto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProyectoRepository")
 */
class Proyecto
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
     * @ORM\Column(name="definicion", type="string", length=1800, nullable=true)
     */
    private $definicion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cierre", type="string", length=2600, nullable=true)
     */
    private $cierre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="produccionAnual", type="string", length=1800, nullable=true)
     */
    private $produccionAnual;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cantidad_turno_horario", type="string", length=45, nullable=true)
     */
    private $cantidadTurnoHorario;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="proyecto")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;


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
     * Set definicion.
     *
     * @param string|null $definicion
     *
     * @return Proyecto
     */
    public function setDefinicion($definicion = null)
    {
        $this->definicion = $definicion;

        return $this;
    }

    /**
     * Get definicion.
     *
     * @return string|null
     */
    public function getDefinicion()
    {
        return $this->definicion;
    }

    /**
     * Set cierre.
     *
     * @param string|null $cierre
     *
     * @return Proyecto
     */
    public function setCierre($cierre = null)
    {
        $this->cierre = $cierre;

        return $this;
    }

    /**
     * Get cierre.
     *
     * @return string|null
     */
    public function getCierre()
    {
        return $this->cierre;
    }

    /**
     * Set produccionAnual.
     *
     * @param string|null $produccionAnual
     *
     * @return Proyecto
     */
    public function setProduccionAnual($produccionAnual = null)
    {
        $this->produccionAnual = $produccionAnual;

        return $this;
    }

    /**
     * Get produccionAnual.
     *
     * @return string|null
     */
    public function getProduccionAnual()
    {
        return $this->produccionAnual;
    }

    /**
     * Set cantidadTurnoHorario.
     *
     * @param string|null $cantidadTurnoHorario
     *
     * @return Proyecto
     */
    public function setCantidadTurnoHorario($cantidadTurnoHorario = null)
    {
        $this->cantidadTurnoHorario = $cantidadTurnoHorario;

        return $this;
    }

    /**
     * Get cantidadTurnoHorario.
     *
     * @return string|null
     */
    public function getCantidadTurnoHorario()
    {
        return $this->cantidadTurnoHorario;
    }

    /**
     * Set empresa.
     *
     * @param Empresa $empresa
     *
     * @return Empresa
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa.
     *
     * @return Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}
