<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formulario
 *
 * @ORM\Table(name="formulario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormularioRepository")
 */
class Formulario
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
     * @ORM\Column(name="estado", type="integer")
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity="Anexo", mappedBy="formulario")
     */
    protected $anexo;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="formulario")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;
    
    /**
     * @ORM\ManyToOne(targetEntity="Tramite", inversedBy="formulario")
     * @ORM\JoinColumn(name="tramite_id", referencedColumnName="id")
     */
    private $tramite;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->anexo = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set estado.
     *
     * @param int $estado
     *
     * @return Formulario
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado.
     *
     * @return int
     */
    public function getEstado()
    {
        return $this->estado;
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
     * Set tramite.
     *
     * @param Tramite $tramite
     *
     * @return Tramite
     */
    public function setTramite($tramite)
    {
        $this->tramite = $tramite;

        return $this;
    }

    /**
     * Get tramite.
     *
     * @return Tramite
     */
    public function getTramite()
    {
        return $this->tramite;
    }
}
