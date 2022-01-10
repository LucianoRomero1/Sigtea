<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MarcaBandera
 *
 * @ORM\Table(name="marca_bandera")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MarcaBanderaRepository")
 */
class MarcaBandera
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="entorno", type="string", length=1000)
     */
    private $entorno;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="marcaBandera")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;

    /**
     * @ORM\OneToMany(targetEntity="ActividadServicio", mappedBy="marcaBandera")
     */
    protected $actividadServicio;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->actividadServicio = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return MarcaBandera
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set entorno.
     *
     * @param string $entorno
     *
     * @return MarcaBandera
     */
    public function setEntorno($entorno)
    {
        $this->entorno = $entorno;

        return $this;
    }

    /**
     * Get entorno.
     *
     * @return string
     */
    public function getEntorno()
    {
        return $this->entorno;
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
