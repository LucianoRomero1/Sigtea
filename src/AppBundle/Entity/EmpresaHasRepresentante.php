<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpresaHasRepresentante
 *
 * @ORM\Table(name="empresaHasRepresentante")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmpresaHasRepresentanteRepository")
 */
class EmpresaHasRepresentante
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
     * @ORM\ManyToOne(targetEntity="Representante", inversedBy="empresaHasRepresentante")
     * @ORM\JoinColumn(name="representante_id", referencedColumnName="id")
     */
    private $representante;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="empresaHasRepresentante")
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
     * Set representante.
     *
     * @param int $representante
     *
     * @return EmpresaHasRepresentante
     */
    public function setRepresentante($representante)
    {
        $this->representante = $representante;

        return $this;
    }

    /**
     * Get representante.
     *
     * @return int
     */
    public function getRepresentante()
    {
        return $this->representante;
    }
   
    /**
     * Set empresa.
     *
     * @param int $empresa
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
     * @return int
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}
