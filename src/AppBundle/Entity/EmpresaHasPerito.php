<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpresaHasPerito
 *
 * @ORM\Table(name="empresaHasPerito")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmpresaHasPeritoRepository")
 */
class EmpresaHasPerito
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
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="empresaHasActividad")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;

    /**
     * @ORM\ManyToOne(targetEntity="Perito", inversedBy="empresaHasActividad")
     * @ORM\JoinColumn(name="perito_id", referencedColumnName="id")
     */
    private $perito;


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

    /**
     * Set perito.
     *
     * @param Perito $perito
     *
     * @return Perito
     */
    public function setPerito($perito)
    {
        $this->perito = $perito;

        return $this;
    }

    /**
     * Get perito.
     *
     * @return Perito
     */
    public function getPerito()
    {
        return $this->perito;
    }
}
