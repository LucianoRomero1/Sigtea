<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actividad
 *
 * @ORM\Table(name="actividad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActividadRepository")
 */
class Actividad
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
     * @ORM\Column(name="cuacm", type="integer")
     */
    private $cuacm;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreActividad", type="string", length=100)
     */
    private $nombreActividad;

    /**
     * @var int
     *
     * @ORM\Column(name="estandar", type="integer")
     */
    private $estandar;

    /**
     * @var int
     *
     * @ORM\Column(name="grupo_id", type="integer")
     */
    private $grupo;

    /**
     * @ORM\OneToMany(targetEntity="EmpresaHasActividad", mappedBy="empresa")
     */
    public $empresaHasActividad;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->empresaHasActividad = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set cuacm.
     *
     * @param int $cuacm
     *
     * @return Actividad
     */
    public function setCuacm($cuacm)
    {
        $this->cuacm = $cuacm;

        return $this;
    }

    /**
     * Get cuacm.
     *
     * @return int
     */
    public function getCuacm()
    {
        return $this->cuacm;
    }

    /**
     * Set nombreActividad.
     *
     * @param string $nombreActividad
     *
     * @return Actividad
     */
    public function setNombreActividad($nombreActividad)
    {
        $this->nombreActividad = $nombreActividad;

        return $this;
    }

    /**
     * Get nombreActividad.
     *
     * @return string
     */
    public function getNombreActividad()
    {
        return $this->nombreActividad;
    }

    /**
     * Set estandar.
     *
     * @param int $estandar
     *
     * @return Actividad
     */
    public function setEstandar($estandar)
    {
        $this->estandar = $estandar;

        return $this;
    }

    /**
     * Get estandar.
     *
     * @return int
     */
    public function getEstandar()
    {
        return $this->estandar;
    }

    /**
     * Set grupo.
     *
     * @param int $grupo
     *
     * @return Actividad
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo.
     *
     * @return int
     */
    public function getGrupo()
    {
        return $this->grupo;
    }
}
