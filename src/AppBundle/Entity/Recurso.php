<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recurso
 *
 * @ORM\Table(name="recurso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecursoRepository")
 */
class Recurso
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
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="recurso")
     * @ORM\JoinColumn(name="planta_id", referencedColumnName="id")
     */
    private $planta; 

    /**
     * @ORM\OneToMany(targetEntity="Agua", mappedBy="recurso")
     */
    protected $agua;
    
    /**
     * @ORM\OneToMany(targetEntity="ElectricaPropia", mappedBy="recurso")
     */
    protected $electricaPropia;
    
    /**
     * @ORM\OneToMany(targetEntity="ElectricaAdquirida", mappedBy="recurso")
     */
    protected $electricaAdquirida;
    
    /**
     * @ORM\OneToMany(targetEntity="OtroRecurso", mappedBy="recurso")
     */
    protected $otroRecurso;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->agua = new \Doctrine\Common\Collections\ArrayCollection();
        $this->electricaPropia = new \Doctrine\Common\Collections\ArrayCollection();
        $this->electricaAdquirida = new \Doctrine\Common\Collections\ArrayCollection();
        $this->otroRecurso = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set tipo.
     *
     * @param int $tipo
     *
     * @return Recurso
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
     * Set planta.
     *
     * @param int $planta
     *
     * @return Recurso
     */
    public function setPlanta($planta)
    {
        $this->planta = $planta;

        return $this;
    }

    /**
     * Get planta.
     *
     * @return int
     */
    public function getPlanta()
    {
        return $this->planta;
    }
}
