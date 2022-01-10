<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpresaHasActividad
 *
 * @ORM\Table(name="empresaHasActividad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmpresaHasActividadRepository")
 */
class EmpresaHasActividad
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
     * @ORM\Column(name="tipo", type="integer")
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="Actividad", inversedBy="empresaHasActividad")
     * @ORM\JoinColumn(name="actividad", referencedColumnName="id")
     */
    private $actividad;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="empresaHasActividad")
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
     * Set tipo.
     *
     * @param int $tipo
     *
     * @return EmpresaHasActividad
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return int
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set actividad.
     *
     * @param Actividad $actividad
     *
     * @return Actividad
     */
    public function setActividad($actividad)
    {
        $this->actividad = $actividad;

        return $this;
    }

    /**
     * Get actividad.
     *
     * @return Actividad
     */
    public function getActividad()
    {
        return $this->actividad;
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
